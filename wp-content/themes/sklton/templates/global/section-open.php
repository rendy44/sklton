<?php
/**
 * Section open template.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$section_class = sk_validate_var( $section_class, 'section' );
$section_size  = sk_validate_var( $section_size, 'col-md-10 col-lg-8', false );
$section_size .= ' mx-auto';
?>

<section class="<?php echo esc_attr( $section_class ); ?>">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr( $section_size ); ?>">
