<?php
/**
 * Main file of the theme.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants.
defined( 'TEMP_DIR' ) || define( 'TEMP_DIR', get_template_directory() );
defined( 'TEMP_URI' ) || define( 'TEMP_URI', get_template_directory_uri() );
defined( 'TEMP_PATH' ) || define( 'TEMP_PATH', get_theme_file_path() );
defined( 'TEMP_PREFIX' ) || define( 'TEMP_PREFIX', 'skltn_' );

// Require the main class.
require_once TEMP_DIR . '/includes/class-main.php';
