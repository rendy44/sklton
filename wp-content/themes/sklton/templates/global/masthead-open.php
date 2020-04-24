<?php
/**
 * Masthead open template.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$masthead_class = sk_validate_var( $masthead_class, 'masthead' );
$masthead_size  = sk_validate_var( $masthead_size, 'col-md-10 col-lg-8', false );
$masthead_size .= ' mx-auto';
?>

<section class="<?php echo esc_attr( $masthead_class ); ?>">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( $masthead_size ); ?>">
