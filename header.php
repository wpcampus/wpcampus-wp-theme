<?php

// Get some site information.
$blog_url = get_bloginfo( 'url' );
$theme_dir = trailingslashit( get_template_directory_uri() );
$is_front_page = is_front_page();
$is_events_page = is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' );

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<a href="#wpc-main" id="skip-to-content"><?php _e( 'Skip to Content', 'wpcampus' ); ?></a>
	<div id="wpc-wrapper">
		<div id="wpc-banner">
			<div class="inside">
				<a class="wpc-logo" href="<?php echo $blog_url; ?>"><span class="for-screen-reader"><?php printf( __( '%1$s: Where %2$s Meets Higher Education', 'wpcampus' ), 'WPCampus', 'WordPress' ); ?></span></a>
				<?php

				// Print the main menu.
				wp_nav_menu( array(
					'theme_location'    => 'primary',
					'container'         => 'div',
					'container_class'   => 'wpc-primary-menu-wrapper',
					'menu_id'           => 'wpc-primary-menu',
					'menu_class'        => 'wpc-primary-menu',
					'fallback_cb'       => false,
				) );

				?>
				<div class="buttons">
					<a class="button primary" href="<?php echo $blog_url; ?>/get-involved/"><?php _e( 'Get Involved', 'wpcampus' ); ?></a>
					<a class="button secondary" href="<?php echo $blog_url; ?>/members/"><?php _e( 'Members', 'wpcampus' ); ?></a>
				</div>
			</div><!-- .inside -->
		</div><!-- #wpc-banner -->
		<?php

		get_template_part( 'partials/hero' );

		get_template_part( 'partials/notification' );

		// Include breadcrumbs.
		//echo wpcampus_get_breadcrumbs_html();

		?>
		<div id="wpc-main">
			<div class="inside from-left">
				<div class="wpc-content">
