<?php
/**
 * Settings Class
 * This class is used to override default behaviour of the WordPress.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.4
 */

namespace Sklton;

use stdClass;
use WP_Post;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Sklton\Settings' ) ) {

	/**
	 * Class Settings
	 *
	 * @package Sklton
	 */
	class Settings {

		/**
		 * Instance variable.
		 *
		 * @var null
		 */
		private static $instance = null;

		/**
		 * Singleton.
		 *
		 * @return Settings|null
		 */
		public static function init() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Settings constructor.
		 *
		 * @since 0.0.1
		 */
		private function __construct() {
			$this->theme_supports();
		}

		/**
		 * Modify theme supports.
		 *
		 * @version 0.0.3
		 * @since 0.0.1
		 */
		private function theme_supports() {

			// Add supports.
			add_theme_support( 'title-tag' );
			add_theme_support( 'menus' );
			add_theme_support( 'post-thumbnails' );

			// Register widget.
			add_action( 'widgets_init', array( $this, 'register_widgets' ) );

			// Register nav menu.
			add_action( 'after_setup_theme', array( $this, 'register_menus' ) );

			// Manage nav menu class.
			add_filter( 'nav_menu_css_class', array( $this, 'nav_menu_class' ), 10, 4 );

			// Manage nav menu link class.
			add_filter( 'nav_menu_link_attributes', array( $this, 'nav_menu_link_attributes' ), 10, 4 );

			// Remove tag generator.
			remove_action( 'wp_head', 'wp_generator' );

			// Manage guttenberg availability.
			add_filter( 'use_block_editor_for_post', array( $this, 'modify_guttenberg_availability' ), 10, 2 );
		}

		/**
		 * Callback for registering widgets.
		 *
		 * @version 0.0.2
		 * @since 0.0.2
		 */
		public function register_widgets() {
			register_sidebar(
				array(
					'name'          => __( 'Sidebar', 'sklton' ),
					'id'            => 'sk_sidebar',
					'before_widget' => '<div class="card widget-item">',
					'before_title'  => '<h5 class="card-header">',
					'after_title'   => '</h5>',
					'after_widget'  => '</div>',
				)
			);
		}

		/**
		 * Callback for registering nav menus.
		 *
		 * @since 0.0.8
		 */
		public function register_menus() {
			$args = array( 'top_nav' => __( 'Top Nav', 'sklton' ) );

			/**
			 * Sklton nav menus filter hook.
			 *
			 * @param array $args default nav menu.
			 *
			 * @since 0.0.8
			 */
			$args = apply_filters( 'sklton_nav_menus', $args );

			register_nav_menus( $args );
		}

		/**
		 * Callback for modifying menu class.
		 *
		 * @param string[] $classes Array of the CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 *
		 * @return string[]
		 *
		 * @since 0.0.4
		 */
		public function nav_menu_class( $classes, $item, $args, $depth ) {

			// Merge the class.
			$classes[] = 'nav-item';

			return $classes;
		}

		/**
		 * Callback for modifying menu link attributes.
		 *
		 * @param array    $atts attributes html.
		 * @param WP_Post  $item The current menu item.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 *
		 * @return array
		 *
		 * @since 0.0.4
		 */
		public function nav_menu_link_attributes( $atts, $item, $args, $depth ) {

			// Merge the attribute.
			$atts['class'] = 'nav-link';

			return $atts;
		}

		/**
		 * Callback for modifying guttenberg availability.
		 *
		 * @param bool    $use_block_editor Whether the post can be edited or not.
		 * @param WP_Post $post The post being checked.
		 *
		 * @return bool
		 *
		 * @since 0.0.1
		 */
		public function modify_guttenberg_availability( $use_block_editor, $post ) {
			if ( 'post' === $post->post_type ) {
				$use_block_editor = false;
			}

			return $use_block_editor;
		}
	}

	Settings::init();
}
