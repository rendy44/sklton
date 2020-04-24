<?php
/**
 * Display class.
 * Used to manage display and content in various pages.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.2
 */

namespace Sklton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Sklton\Display' ) ) {

	/**
	 * Class Display.
	 *
	 * @package Sklton
	 */
	class Display {

		/**
		 * Instance variable.
		 *
		 * @var null
		 */
		private static $instance = null;

		/**
		 * Singleton.
		 *
		 * @return Display|null
		 */
		public static function init() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Display constructor.
		 *
		 * @since 0.0.1
		 */
		private function __construct() {
			$this->global_display();
		}

		/**
		 * Manage display for global content.
		 *
		 * @since 0.0.1
		 */
		private function global_display() {

			// Masthead display.
			add_action( 'sklton_after_header_content', array( $this, 'masthead_open' ), 10 );
			add_action( 'sklton_after_header_content', array( $this, 'masthead_content' ), 20 );
			add_action( 'sklton_after_header_content', array( $this, 'masthead_close' ), 30 );
		}

		/**
		 * Callback for displaying masthead opening tag.
		 *
		 * @version 0.0.2
		 * @since 0.0.1
		 */
		public function masthead_open() {
			$args = array(
				'masthead_class' => is_front_page() ? 'masthead-front' : '',
			);

			/**
			 * Sklton masthead opening tag args filter hook.
			 *
			 * @param array $args default args.
			 *
			 * @since 0.0.1
			 */
			$args = apply_filters( 'sklton_masthead_open_args', $args );

			sk_template( 'global/masthead-open', $args );
		}

		/**
		 * Callback for displaying masthead content.
		 *
		 * @since 0.0.2
		 */
		public function masthead_content() {
			$masthead_title = get_the_title();

			/**
			 * Sklton masthead content title filter hook.
			 *
			 * @param string $masthead_title default masthead title.
			 */
			$masthead_title = apply_filters( 'sklton_masthead_content_title', $masthead_title );

			$args = array(
				'masthead_title' => $masthead_title,
			);

			/**
			 * Sklton masthead content args.
			 *
			 * @param array $args default args.
			 *
			 * @since 0.0.2
			 */
			$args = apply_filters( 'sklton_masthead_content_args', $args );

			sk_template( 'global/masthead-content', $args );
		}

		/**
		 * Callback for displaying masthead closing tag.
		 *
		 * @since 0.0.1
		 */
		public function masthead_close() {
			sk_template( 'global/masthead-close' );
		}
	}

	Display::init();
}
