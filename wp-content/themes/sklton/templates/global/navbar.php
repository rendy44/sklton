<?php
/**
 * Navbar template.
 *
 * @author WPerfekt
 * @package Sklton
 * @version 0.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$navbar_class = sk_validate_var( $navbar_class, 'sticky-top navbar-expand-lg navbar-light bg-light', false );
?>

<nav class="navbar <?php echo esc_attr( $navbar_class ); ?>">
	<div class="container">
		<a class="navbar-brand" href="<?php home_url(); ?>>">
			<?php bloginfo( 'name' ); ?>
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<?php
		wp_nav_menu(
			array(
				'theme_location'  => $nav_location,
				'menu_class'      => 'navbar-nav',
				'container_class' => 'collapse navbar-collapse',
				'container_id'    => 'navbarNavDropdown',
			)
		);

		/**
		 * Sklton after navbar menu action hook.
		 *
		 * @since 0.0.1
		 */
		do_action( 'sklton_after_navbar_menu' );
		?>
	</div>
</nav>
