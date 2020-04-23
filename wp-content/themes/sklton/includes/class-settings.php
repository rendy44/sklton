<?php
/**
 * Settings Class
 * This class is used to override default behaviour of the WordPress.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.1
 */

namespace Sklton;

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
		 * @since 0.0.1
		 */
		private function theme_supports() {

			// Add supports.
			add_theme_support( 'title-tag' );
			add_theme_support( 'menus' );
			add_theme_support( 'post-thumbnails' );

			// Remove tag generator.
			remove_action( 'wp_head', 'wp_generator' );

			// Manage guttenberg availability.
			add_filter( 'use_block_editor_for_post', array( $this, 'modify_guttenberg_availability' ), 10, 2 );
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
