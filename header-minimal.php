<?php

$stylesheet_dir = get_stylesheet_directory_uri();
$images_dir = "{$stylesheet_dir}/assets/images/";
$is_front_page = is_front_page();
$is_events_page = is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '-', true, 'left' ); ?></title>
	<?php wp_head(); ?>
</head>
<body <?php body_class( 'header-minimal' ); ?>>
<?php

// Print network banner.
if ( function_exists( 'wpcampus_print_network_banner' ) ) {
	wpcampus_print_network_banner( array(
		'skip_nav_id' => 'wpcampus-main',
	));
}

?>
<div id="wpcampus-banner" role="navigation">
	<button class="wpc-toggle-menu" data-toggle="wpcampus-banner" aria-label="<?php _e( 'Toggle menu', 'wpcampus' ); ?>">
		<div class="toggle-icon">
			<div class="bar one"></div>
			<div class="bar two"></div>
			<div class="bar three"></div>
		</div>
		<div class="open-menu-label"><?php _e( 'Menu', 'wpcampus' ); ?></div>
		<div class="close-menu-label"><?php _e( 'Close', 'wpcampus' ); ?></div>
	</button>
	<div id="wpcampus-main-menu" class="menu">
		<ul class="icons">
			<li class="icon has-icon-alt home<?php echo $is_front_page ? ' current' : null; ?>"><a href="/"><img src="<?php echo $images_dir; ?>home-white.svg" alt="<?php printf( esc_attr__( 'Visit the %s home page', 'wpcampus' ), 'WPCampus' ); ?>" /><span class="icon-alt"><?php _e( 'Home', 'wpcampus' ); ?></span></a></li>
		</ul>
		<?php

		// Print the header menu.
		wp_nav_menu( array(
			'theme_location'    => 'primary',
			'container'         => false,
			'menu_class'        => false,
		));

		?>
	</div>
</div> <!-- #wpcampus-banner -->
<div role="complementary" id="wpcampus-hero">
	<div class="row">
		<div class="small-12 columns">
			<div class="wpcampus-header">
				<?php

				// If home, add a <h1>.
				echo $is_front_page ? '<h1>' : null;

				?>
				<a class="wpcampus-logo" href="/">
					<img src="<?php echo $images_dir; ?>wpcampus-white.svg" alt="" />
					<span class="screen-reader-text">WPCampus</span>
					<span class="wpcampus-tagline"><?php printf( __( 'Where %s Meets Higher Education', 'wpcampus' ), 'WordPress' ); ?></span>
				</a>
				<?php

				// If home, close the <h1>.
				echo $is_front_page ? '</h1>' : null;

				?>
			</div><!-- .wpcampus-header -->
		</div>
	</div>
</div>
<div role="main" id="wpcampus-main">
	<?php
	/*<div id="wpc-online-details">
		<div class="row">
			<div class="small-12 columns centered">
				<p><strong>The WPCampus 2017 <a href="https://2017.wpcampus.org/call-for-speakers/">call for speakers</a> has been extended until March 29, 2017.</strong><br />Share your WordPress and higher ed knowledge with our community. <a class="wpc-details-action" href="https://2017.wpcampus.org/call-for-speakers/"><strong>Apply to speak at WPCampus 2017</strong></a></p>
			</div>
		</div>
	</div>*/

	if ( ! $is_front_page ) :
		?>
		<div id="wpcampus-main-page-title">
			<div class="inside">
				<?php

				do_action( 'wpcampus_before_page_title' );

				?>
				<h1><?php

					// Print page title.
					if ( is_404() ) {
						echo 'Page Not Found';
					} else {
						echo apply_filters( 'wpcampus_page_title', get_the_title() );
					}

					?></h1>
				<?php

				do_action( 'wpcampus_after_page_title' );

				// If article, include article meta.
				if ( is_singular( array( 'post', 'podcast', 'video' ) ) ) {
					wpcampus_print_article_meta();
				}

				// Include breadcrumbs.
				if ( apply_filters( 'wpcampus_print_breadcrumbs', true ) ) {
					wpcampus_print_breadcrumbs();
				}

				?>
			</div>
		</div>
		<?php
	endif;

	?>
	<div id="wpcampus-content">
		<div class="row">
			<div class="small-12 columns">
