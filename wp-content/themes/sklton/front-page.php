<?php
/**
 * Front page template.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load theme header.
 *
 * @since 0.0.1
 */
get_header();

/**
 * Sklton before front page content action hook.
 *
 * @since 0.0.1
 */
do_action( 'sklton_before_front_page_content' );

while ( have_posts() ) {
	the_post();

	// Get front page id.
	$page_id = get_the_ID();

	/**
	 * Sklton before front page loop content action hook.
	 *
	 * @param int $page_id id of the front page.
	 *
	 * @since 0.0.1
	 */
	do_action( 'sklton_before_front_page_loop_content', $page_id );

	/**
	 * Sklton front page loop content action hook.
	 *
	 * @param int $page_id id of the front page.
	 *
	 * @since 0.0.1
	 */
	do_action( 'sklton_front_page_loop_content', $page_id );

	/**
	 * Sklton after front page loop content action hook.
	 *
	 * @param int $page_id id of the front page.
	 *
	 * @since 0.0.1
	 */
	do_action( 'sklton_after_front_page_loop_content', $page_id );
}

/**
 * Sklton after front page content action hook.
 *
 * @since 0.0.1
 */
do_action( 'sklton_after_front_page_content' );

/**
 * Load theme footer.
 *
 * @since 0.0.1
 */
get_footer();
