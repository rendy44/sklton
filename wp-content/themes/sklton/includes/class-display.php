<?php
/**
 * Display class.
 * Used to manage display and content in various pages.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.9
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
		 * @version 0.0.2
		 * @since 0.0.1
		 */
		private function __construct() {
			$this->global_display();
			$this->post_display();
		}

		/**
		 * Manage display for global content.
		 *
		 * @version 0.0.3
		 * @since 0.0.1
		 */
		private function global_display() {

			// Navbar.
			add_action( 'sklton_after_header_content', array( $this, 'navbar' ), 10 );

			// Masthead display.
			add_action( 'sklton_after_header_content', array( $this, 'masthead_open' ), 20 );
			add_action( 'sklton_after_header_content', array( $this, 'masthead_content' ), 30 );
			add_action( 'sklton_after_header_content', array( $this, 'masthead_close' ), 40 );
			add_filter( 'sklton_masthead_content_title', array( $this, 'masthead_title' ), 10, 1 );

			// Footer display.
			add_action( 'sklton_footer_content', array( $this, 'footer_open' ), 10 );
			add_action( 'sklton_footer_content', array( $this, 'footer_content' ), 20 );
			add_action( 'sklton_footer_content', array( $this, 'footer_close' ), 30 );
		}

		/**
		 * Manage display for single post.
		 *
		 * @since 0.0.6
		 */
		private function post_display() {

			// Global post display.
			add_action( 'sklton_before_post_content', array( $this, 'global_post_content_open' ), 10, 2 );
			add_action( 'sklton_before_post_content', array( $this, 'maybe_post_two_columns_open' ), 20, 2 );
			add_filter( 'sklton_post_content_open_args', array( $this, 'modify_post_content_open_args' ), 10, 3 );
			add_action( 'sklton_post_content', array( $this, 'global_post_content' ), 10, 1 );
			add_action( 'sklton_after_post_content', array( $this, 'maybe_post_two_columns_close' ), 40, 2 );
			add_action( 'sklton_after_post_content', array( $this, 'global_post_content_close' ), 50, 2 );
		}

		/**
		 * Callback for displaying navbar.
		 *
		 * @since 0.0.9
		 */
		public function navbar() {
			$args = array(
				'nav_location' => 'top_nav',
			);

			/**
			 * Sklton navbar args filter hook.
			 *
			 * @param array $args default args.
			 *
			 * @since 0.0.9
			 */
			$args = apply_filters( 'sklton_navbar_args', $args );

			sk_template( 'global/navbar', $args );
		}

		/**
		 * Callback for displaying masthead opening tag.
		 *
		 * @version 0.0.4
		 * @since 0.0.1
		 */
		public function masthead_open() {
			$args = array(
				'section_class' => is_front_page() ? 'masthead masthead-front' : 'masthead',
			);

			/**
			 * Sklton masthead opening tag args filter hook.
			 *
			 * @param array $args default args.
			 *
			 * @since 0.0.1
			 */
			$args = apply_filters( 'sklton_masthead_open_args', $args );

			sk_template( 'global/section-open', $args );
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
			 *
			 * @hooked $this->masthead_title() - 10
			 *
			 * @since 0.0.1
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
		 * @version 0.0.2
		 * @since 0.0.1
		 */
		public function masthead_close() {
			sk_template( 'global/section-close' );
		}

		/**
		 * Callback for modifying masthead title.
		 *
		 * @param string $title default masthead title.
		 *
		 * @return string
		 *
		 * @since 0.0.3
		 */
		public function masthead_title( $title ) {

			// Modify title depends on the current page.
			if ( is_front_page() ) {
				$title = __( 'Welcome to Sklton!', 'sklton' );
			} elseif ( is_archive() ) {
				$title = get_the_archive_title();
			} elseif ( is_404() ) {
				$title = __( 'Not Found', 'sklton' );
			}

			return $title;
		}

		/**
		 * Callback for displaying footer opening tag.
		 *
		 * @since 0.0.4
		 */
		public function footer_open() {
			$args = array(
				'footer_class' => 'footer-dark',
			);

			/**
			 * Sklton footer opening tag args filter hook.
			 *
			 * @param array $args default args.
			 *
			 * @since 0.0.1
			 */
			$args = apply_filters( 'sklton_footer_open_args', $args );

			sk_template( 'global/footer-open', $args );
		}

		/**
		 * Callback for displaying footer content.
		 *
		 * @since 0.0.4
		 */
		public function footer_content() {
			sk_template( 'global/footer-content' );
		}

		/**
		 * Callback for displaying footer closing tag.
		 *
		 * @since 0.0.4
		 */
		public function footer_close() {
			sk_template( 'global/footer-close' );
		}

		/**
		 * Callback for displaying post content opening tag.
		 *
		 * @param int    $current_post_id id of the post.
		 * @param string $current_post_type name of the post type.
		 *
		 * @since 0.0.7
		 */
		public function global_post_content_open( $current_post_id, $current_post_type ) {
			$args = array(
				'section_class' => "single-post single-{$current_post_type}-post-type",
			);

			/**
			 * Sklton post content opening tag args filter hook.
			 *
			 * @param array $args default args.
			 * @param int $current_post_id id of the post.
			 * @param string $current_post_type name of the post type.
			 *
			 * @hooked this->modify_post_content_open_args() - 10
			 *
			 * @since 0.0.7
			 */
			$args = apply_filters( 'sklton_post_content_open_args', $args, $current_post_id, $current_post_type );

			sk_template( 'global/section-open', $args );
		}

		/**
		 * Callback maybe for displaying post two columns opening tag.
		 *
		 * @param int    $current_post_id id of the post.
		 * @param string $current_post_type name of the post type.
		 *
		 * @since 0.0.8
		 */
		public function maybe_post_two_columns_open( $current_post_id, $current_post_type ) {

			// Make sure we are on post type post.
			if ( 'post' === $current_post_type ) {

				// Make sure the sidebar is active.
				if ( is_active_sidebar( 'sk_sidebar' ) ) {
					?>
					<div class="row">
					<div class="col-lg-9">
					<?php
				}
			}
		}

		/**
		 * Callback for modifying post content open args.
		 *
		 * @param array  $args default args.
		 * @param int    $current_post_id id of the post.
		 * @param string $current_post_type name of the post type.
		 *
		 * @return array
		 *
		 * @since 0.0.7
		 */
		public function modify_post_content_open_args( $args, $current_post_id, $current_post_type ) {

			// Make sure we are on post type post.
			if ( 'post' === $current_post_type ) {

				// Also make sure that the sidebar is active.
				if ( sk_is_using_sidebar() ) {

					// Merge the args.
					$args['section_size'] = 'col-md-12';
				}
			}

			return $args;
		}

		/**
		 * Callback for displaying global single post's content.
		 *
		 * @since 0.0.7
		 */
		public function global_post_content() {
			echo '<article>'; // phpcs:ignore
			the_content();
			echo '</article>'; // phpcs:ignore
		}

		/**
		 * Callback maybe for displaying post two columns opening tag.
		 *
		 * @param int    $current_post_id id of the post.
		 * @param string $current_post_type name of the post type.
		 *
		 * @since 0.0.8
		 */
		public function maybe_post_two_columns_close( $current_post_id, $current_post_type ) {

			// Make sure we are on post type post.
			if ( 'post' === $current_post_type ) {

				// Make sure the sidebar is active.
				if ( is_active_sidebar( 'sk_sidebar' ) ) {
					?>
					</div> <!-- /.col-lg-9 -->
					<div class="col-lg-3">
						<?php dynamic_sidebar( 'sk_sidebar' ); ?>
					</div>
					</div> <!-- /.row -->
					<?php
				}
			}
		}

		/**
		 * Callback for displaying post content closing tag.
		 *
		 * @since 0.0.7
		 */
		public function global_post_content_close() {
			sk_template( 'global/section-close' );
		}
	}

	Display::init();
}
