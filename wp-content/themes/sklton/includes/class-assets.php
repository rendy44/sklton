<?php
/**
 * Assets Class.
 * This class is used for collecting and mapping assets that will be loaded both in front-end and wp-admin.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.3
 */

namespace Sklton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Sklton\Assets' ) ) {

	/**
	 * Class Assets
	 *
	 * @package Sklton
	 */
	class Assets {

		/**
		 * Front-end css variable.
		 *
		 * @var array
		 *
		 * @since 0.0.1
		 */
		private $front_css;

		/**
		 * Front-end js variable.
		 *
		 * @var array
		 *
		 * @since 0.0.1
		 */
		private $front_js;

		/**
		 * Admin css variable.
		 *
		 * @var array
		 *
		 * @since 0.0.1
		 */
		private $admin_css;

		/**
		 * Admin js variable.
		 *
		 * @var array
		 *
		 * @since 0.0.1
		 */
		private $admin_js;

		/**
		 * Treat js as module variable.
		 *
		 * @var array
		 *
		 * @since 0.0.3
		 */
		private $as_module;

		/**
		 * Instance variable.
		 *
		 * @var null
		 */
		private static $instance = null;

		/**
		 * Singleton.
		 *
		 * @return Assets|null
		 */
		public static function init() {
			if ( null === self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Assets constructor.
		 *
		 * @since 0.0.1
		 */
		private function __construct() {

			// Load front assets.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front_assets' ) );
			// Maybe convert js as module.
			add_filter( 'script_loader_tag', array( $this, 'load_as_module' ), 10, 3 );
		}

		/**
		 * Callback for loading front-end assets.
		 */
		public function enqueue_front_assets() {
			$this->load_assets( 'css' );
			$this->load_assets( 'js' );
		}

		/**
		 * Filters the HTML script tag of an enqueued script.
		 *
		 * @param string $tag The <script> tag for the enqueued script.
		 * @param string $handle The script's registered handle.
		 * @param string $src The script's source URL.
		 *
		 * @return  string
		 *
		 * @version 0.0.2
		 * @since 0.0.3
		 */
		public function load_as_module( $tag, $handle, $src ) {
			$js_prefix = TEMP_PREFIX . 'module_';

			// Validate the module list before fetching it.
			if ( ! empty( $this->as_module ) ) {
				if ( in_array( $handle, $this->as_module, true ) || false !== strpos( $handle, $js_prefix ) ) {
					$tag = '<script type="module" src="' . esc_url( $src ) . '"></script>'; // phpcs:ignore
				}
			}

			return $tag;
		}

		/**
		 * Map assets in back-end.
		 *
		 * @since 0.0.1
		 */
		private function map_admin_assets() {

			// Prepare back-end js.
			$js_files = array();

			/**
			 * Sklton back-end js filter hook.
			 *
			 * @param array $js_files default js files.
			 *
			 * @since 0.0.1
			 */
			$js_files = apply_filters( 'sklton_back_end_js', $js_files );

			// Do load js files.
			$this->do_map_assets_by_type( $js_files, 'js', false );

			// Prepare back-end css.
			$css_files = array();

			/**
			 * Sklton back-end css filter hook.
			 *
			 * @param array $css_files default css files.
			 *
			 * @since 0.0.1
			 */
			$css_files = apply_filters( 'sklton_back_end_css', $css_files );

			// Do load css files.
			$this->do_map_assets_by_type( $css_files, 'css', false );
		}

		/**
		 * Map assets in front-end.
		 *
		 * @version 0.0.2
		 * @since 0.0.1
		 */
		private function map_front_assets() {

			// Prepare front-end js.
			$js_files = array(
				'bootstrap' => array(
					'src'       => TEMP_URI . '/assets/vendor/js/bootstrap.min.js',
					'deps'      => array( 'jquery' ),
					'is_module' => false,
				),
				'sklton'    => array(
					'src'  => TEMP_URI . '/assets/js/app.min.js',
					'deps' => array( 'jquery' ),
					'vars' => array(
						'ajax_url' => admin_url( 'admin-ajax.php' ),
						'prefix'   => TEMP_PREFIX,
					),
				),
			);

			/**
			 * Sklton front-end js filter hook.
			 *
			 * @param array $js_files default js files.
			 *
			 * @since 0.0.1
			 */
			$js_files = apply_filters( 'sklton_front_end_js', $js_files );

			// Do load js files.
			$this->do_map_assets_by_type( $js_files, 'js' );

			// Prepare front-end css.
			$css_files = array(
				'font'      => array(
					'src' => 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap',
				),
				'bootstrap' => array(
					'src' => TEMP_URI . '/assets/vendor/css/bootstrap.min.css',
				),
				'sklton'    => array(
					'src' => TEMP_URI . '/assets/css/app.css',
				),
			);

			/**
			 * Sklton front-end css filter hook.
			 *
			 * @param array $css_files default css files.
			 *
			 * @since 0.0.1
			 */
			$css_files = apply_filters( 'sklton_front_end_css', $css_files );

			// Do load css files.
			$this->do_map_assets_by_type( $css_files, 'css' );
		}

		/**
		 * Load front-end's assets.
		 *
		 * @param string $type type of the asset, css|js.
		 * @param bool   $is_front whether load assets in front-end or not.
		 *
		 * @since 0.0.1
		 */
		private function load_assets( $type = 'css', $is_front = true ) {

			$asset_loc = $is_front ? 'front' : 'admin';
			$map_func  = "map_{$asset_loc}_assets";

			// Map assets.
			$this->$map_func();

			// Define property name where assets are stored.
			$prop_assets_name = $asset_loc . '_' . $type;

			// Get mapped assets.
			$assets          = $this->{$prop_assets_name};
			$loader_function = 'css' === $type ? 'wp_enqueue_style' : 'wp_enqueue_script';

			// Loop assets.
			if ( ! empty( $assets ) ) {
				foreach ( (array) $assets as $asset_name => $asset_arg ) {
					$loader_function( $asset_name, $asset_arg['src'], $asset_arg['deps'], $asset_arg['ver'], $asset_arg['in_footer'] );

					// Maybe localize script.
					if ( 'js' === $type && ! empty( $asset_arg['vars'] ) ) {
						wp_localize_script( $asset_name, 'obj', $asset_arg['vars'] );
					}
				}
			}
		}

		/**
		 * Add asset for front-end.
		 *
		 * @param string $name name of the asset.
		 * @param array  $args array of the new asset.
		 * @param string $type type of the asset, css|js.
		 * @param bool   $is_front whether map front-end's assets or not.
		 *
		 * @version 0.0.2
		 * @since 0.0.1
		 */
		private function map_individual_asset( $name, $args, $type = 'css', $is_front = true ) {

			// Prepare default args.
			$default_args = array(
				'src'       => '',
				'deps'      => array(),
				'ver'       => '0.0.1',
				'in_footer' => false,
				'is_module' => true,
			);

			// Merge args.
			$args = wp_parse_args( $args, $default_args );

			// Maybe add to module.
			if ( 'js' === $type && $args['is_module'] ) {
				$this->as_module[] = $name;
			}

			$asset_loc = $is_front ? 'front' : 'admin';

			// Merge the assets, whether it is css or js.
			if ( 'css' === $type ) {
				$this->front_css[ $name ] = $args;
				$args['in_footer']        = 'all';
			} else {
				$this->front_js[ $name ] = $args;
			}
		}

		/**
		 * Do load the assets.
		 *
		 * @param array  $assets list of the assets.
		 * @param string $type type of the asset, css|js.
		 * @param bool   $is_front whether map front-end's assets or not.
		 *
		 * @since 0.0.1
		 */
		private function do_map_assets_by_type( $assets, $type = 'css', $is_front = true ) {

			// Make sure the assets is available.
			if ( ! empty( $assets ) ) {

				// Loop the assets.
				foreach ( $assets as $asset_name => $asset_arg ) {

					// Add the asset.
					$this->map_individual_asset( $asset_name, $asset_arg, $type, $is_front );
				}
			}
		}
	}

	Assets::init();
}
