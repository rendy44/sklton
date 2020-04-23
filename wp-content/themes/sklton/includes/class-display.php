<?php
/**
 * Display class.
 * Used to manage display and content in various pages.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.1
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
			add_action( 'sklton_after_header_content', array( $this, 'masthead_close' ), 30 );
		}

		/**
		 * Callback for displaying masthead opening tag.
		 *
		 * @since 0.0.1
		 */
		public function masthead_open() {
			sk_template( 'global/masthead-open' );
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
