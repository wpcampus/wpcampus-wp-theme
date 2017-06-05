<?php

// Get some site information.
$blog_url = get_bloginfo( 'url' );
$theme_dir = trailingslashit( get_template_directory_uri() );
$is_front_page = is_front_page();
$is_events_page = is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' );

// Do we have a search query?
$search_query = is_search() ? get_search_query() : '';

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<a href="#wpc-main" id="skip-to-content"><?php _e( 'Skip to Content', 'wpcampus' ); ?></a>
	<div id="wpc-wrapper">
		<?php

		// Set up banner classes.
		$banner_class = array();

		if ( $search_query ) {
			$banner_class[] = 'search-open';
		}

		?>
		<div id="wpc-banner"<?php echo $banner_class ? ' class="' . implode( ' ', $banner_class ) . '"' : ''; ?>>
			<div class="inside">
				<div class="wpc-menu-wrapper">
					<div class="toggle-main-menu">
						<div class="toggle-icon">
							<div class="bar one"></div>
							<div class="bar two"></div>
							<div class="bar three"></div>
						</div>
					</div>
					<div class="wpc-menu-container">
						<div class="wpc-buttons">
							<a class="button primary" href="<?php echo $blog_url; ?>/get-involved/"><?php _e( 'Get Involved', 'wpcampus' ); ?></a>
							<a class="button secondary" href="<?php echo $blog_url; ?>/members/"><?php _e( 'Members', 'wpcampus' ); ?></a>
						</div>
						<?php

						// Print the main menu.
						wp_nav_menu( array(
							'theme_location'    => 'primary',
							'container'         => false,
							'menu_id'           => 'wpc-menu',
							'menu_class'        => 'wpc-menu',
							'fallback_cb'       => false,
						));

						?>
					</div>
				</div>
				<div class="wpc-search-wrapper">
					<div class="wpc-search-wrapper-bg"></div>
					<div class="wpc-search-form-wrapper">
						<?php get_search_form(); ?>
					</div>
					<div class="wpc-search-icon">
						<div class="wpc-search-magnifying"></div>
						<div class="wpc-search-close"></div>
					</div>
				</div>
				<a id="wpc-banner-logo" class="wpc-logo" href="<?php echo $blog_url; ?>"><?php wpc_theme_print_eduwapuu( false ); ?><span class="for-screen-reader"><?php printf( __( '%1$s: Where %2$s Meets Higher Education', 'wpcampus' ), 'WPCampus', 'WordPress' ); ?></span></a>
			</div><!-- .inside -->
		</div><!-- #wpc-banner -->
		<?php

		// Include the hero area.
		get_template_part( 'partials/hero' );

		// Include notifications.
		require( STYLESHEETPATH . '/partials/notification.html' );

		// Include breadcrumbs.
		//echo wpcampus_get_breadcrumbs_html();

		?>
		<div id="wpc-main">
			<div class="inside from-left">
				<div class="wpc-content">
