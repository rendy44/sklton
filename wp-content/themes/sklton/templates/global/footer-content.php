<?php
/**
 * Footer content template.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* translators: %1$s: current date, %2$s: site name, %3$s: site description */
echo sprintf( __( '<p>&copy; %1$s %2$s - %3$s</p>', 'sklton' ), gmdate( 'Y' ), get_bloginfo( 'name' ), get_bloginfo( 'description' ) ); // phpcs:ignore
