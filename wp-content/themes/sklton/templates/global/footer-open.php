<?php
/**
 * Footer open template.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$footer_class = sk_validate_var( $footer_class, 'footer' );
$footer_size  = sk_validate_var( $footer_size, 'col-md-10 col-lg-8', false );
$footer_size .= ' mx-auto d-flex h-100 justify-content-center align-items-center';
?>

<footer class="<?php echo esc_attr( $footer_class ); ?>">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( $footer_size ); ?>">
