<?php
/**
 * Single post template.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load theme header.
 *
 * @since 0.0.2
 */
get_header();

/**
 * Sklton before post content action hook.
 *
 * @version 0.0.2
 * @since 0.0.1
 */
do_action( 'sklton_before_outer_post_content' );

while ( have_posts() ) {
	the_post();
	global $post;

	// Get current post details.
	$current_post_id   = $post->ID;
	$current_post_type = $post->post_type;


	/**
	 * Sklton before post content action hook.
	 *
	 * @param int $current_post_id id of the post.
	 * @param string $current_post_type name of the post type.
	 *
	 * @hooked Sklton\Display->global_post_content_open() - 10
	 *
	 * @since 0.0.1
	 */
	do_action( 'sklton_before_post_content', $current_post_id, $current_post_type );

	/**
	 * Sklton post content action hook.
	 *
	 * @param int $current_post_id id of the post.
	 * @param string $current_post_type name of the post type.
	 *
	 * @since 0.0.1
	 */
	do_action( 'sklton_post_content', $current_post_id, $current_post_type );

	/**
	 * Sklton individual post type content action hook.
	 *
	 * @param int $current_post_id id of the post.
	 *
	 * @since 0.0.1
	 */
	do_action( "sklton_{$current_post_type}_post_type_content", $current_post_id );

	/**
	 * Sklton after post content action hook.
	 *
	 * @param int $current_post_id id of the post.
	 * @param string $current_post_type name of the post type.
	 *
	 * @hooked Sklton\Display->global_post_content_close() - 50
	 *
	 * @since 0.0.1
	 */
	do_action( 'sklton_after_post_content', $current_post_id, $current_post_type );
}

/**
 * Sklton after post content action hook.
 *
 * @version 0.0.2
 * @since 0.0.1
 */
do_action( 'sklton_after_outer_post_content' );

/**
 * Load theme footer.
 *
 * @since 0.0.1
 */
get_footer();
