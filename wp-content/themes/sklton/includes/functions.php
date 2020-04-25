<?php
/**
 * Function list.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.2
 */

use Sklton\Template;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Validate default variable.
 *
 * @param string $var variable.
 * @param mixed  $default_val variable default value.
 * @param bool   $merge whether merge default value or replace it.
 *
 * @return mixed
 *
 * @version 0.0.2
 * @since 0.0.1
 */
function sk_validate_var( $var, $default_val, $merge = true ) {
	return isset( $var ) && $var ? ( $merge ? $default_val . ' ' . $var : $var ) : $default_val;
}

/**
 * Render template.
 *
 * @param string $template_name template name.
 * @param array  $args list of variable.
 * @param bool   $echo whether echo the template or not.
 *
 * @return string|void
 */
function sk_template( $template_name, $args = array(), $echo = true ) {
	return Template::render( $template_name, $args, $echo );
}
