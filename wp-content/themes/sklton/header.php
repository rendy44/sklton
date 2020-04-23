<?php
/**
 * Header template.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} ?>

	<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
		<link rel="pingback" href=" <?php bloginfo( 'pingback_url' ); ?>">
		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>

<?php
/**
 * Load WordPress built-in function after body tag.
 *
 * @since 0.0.1
 */
wp_body_open();

/**
 * Sklton after header content action hook.
 *
 * @hooked Sklton\Display->masthead_open() - 10
 * @hooked Sklton\Display->masthead_close() - 30
 *
 * @version 0.0.2
 * @since 0.0.1
 */
do_action( 'sklton_after_header_content' );
