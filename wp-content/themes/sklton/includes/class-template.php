<?php
/**
 * Template Class
 * This class is used to render php file into output buffer
 *
 * @author  WPerfekt
 * @package Sklton
 * @version 0.0.1
 */

namespace Sklton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Sklton\Template' ) ) {

	/**
	 * Class Template
	 *
	 * @package Sklton
	 */
	class Template {

		/**
		 * Folder name variable
		 *
		 * @var string
		 *
		 * @since 0.0.1
		 */
		private static $folder = '';

		/**
		 * Set template folder
		 *
		 * @since 0.0.1
		 */
		private static function set_default_folder() {
			$folder = 'templates';

			if ( ! self::$folder ) {

				self::do_set_folder( $folder );
			}
		}

		/**
		 * Save folder path.
		 *
		 * @param string $path the folder path.
		 *
		 * @since 0.0.1
		 */
		private static function do_set_folder( $path ) {
			self::$folder = rtrim( $path, '/' );
		}

		/**
		 * Check template file existence
		 *
		 * @param string $file_name template file name.
		 *
		 * @return string
		 *
		 * @since 0.0.1
		 */
		private static function find_template( $file_name ) {

			// Set default folder.
			self::set_default_folder();

			// Check file in plugin.
			return locate_template( self::$folder . "/{$file_name}.php" );
		}

		/**
		 * Render the template
		 *
		 * @param string $template template file path.
		 * @param array  $variables variables that will be injected into template file.
		 *
		 * @return string
		 *
		 * @since 0.0.1
		 */
		private static function render_template( $template, $variables = array() ) {
			ob_start();
			foreach ( $variables as $key => $value ) {
				${$key} = $value;
			}

			include $template;

			return ob_get_clean();
		}

		/**
		 * Render the template
		 *
		 * @param string $file_name template file name.
		 * @param array  $variables variables that will be injected into template file.
		 * @param bool   $echo whether display as variable or display in browser.
		 *
		 * @return void|string
		 *
		 * @since 0.0.1
		 */
		public static function render( $file_name, $variables = array(), $echo = true ) {
			$template = self::find_template( $file_name );
			$output   = '';
			if ( $template ) {
				$output = self::render_template( $template, $variables );
			}

			if ( $echo ) {
				echo $output; // phpcs:ignore
			} else {
				return $output;
			}
		}
	}
}
