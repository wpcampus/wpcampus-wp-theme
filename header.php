<?php

$blog_url = get_bloginfo( 'url' );
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
<body <?php body_class(); ?>>
	<a href="#wpcampus-main" id="skip-to-content"><?php _e( 'Skip to Content', 'wpcampus' ); ?></a>
	<div id="wpcampus-banner">
		<div class="toggle-main-menu">
			<div class="toggle-icon">
				<div class="bar one"></div>
				<div class="bar two"></div>
				<div class="bar three"></div>
			</div>
			<div class="open-menu-label"><?php _e( 'Menu', 'wpcampus' ); ?></div>
			<div class="close-menu-label"><?php _e( 'Close', 'wpcampus' ); ?></div>
		</div>
		<?php

		// Get the primary menu.
		$primary_menu = wp_nav_menu( array(
			'theme_location'    => 'primary',
			'container'         => false,
			'menu_class'        => false,
			'echo'              => false,
		));

		?>
		<div id="wpcampus-main-menu" class="menu">
	        <ul class="icons">
		        <li class="icon has-icon-alt home<?php echo $is_front_page ? ' current' : null; ?>"><a href="<?php echo $blog_url; ?>"><img src="<?php echo $images_dir; ?>home-white.svg" alt="<?php printf( esc_attr__( 'Visit the %s home page', 'wpcampus' ), 'WPCampus' ); ?>" /><span class="icon-alt"><?php _e( 'Home', 'wpcampus' ); ?></span></a></li>
	        </ul>
	        <?php echo $primary_menu; ?>
	        <ul class="icons social-media">
	            <li class="icon twitter"><a href="https://twitter.com/wpcampusorg"><img src="<?php echo $images_dir; ?>twitter-white.svg" alt="<?php printf( esc_attr__( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Twitter' ); ?>" /></a></li>
	            <li class="icon facebook"><a href="https://www.facebook.com/wpcampus"><img src="<?php echo $images_dir; ?>facebook-white.svg" alt="<?php printf( esc_attr__( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Facebook' ); ?>" /></a></li>
	            <li class="icon youtube"><a href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $images_dir; ?>youtube-white.svg" alt="<?php printf( esc_attr__( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'YouTube' ); ?>" /></a></li>
	            <li class="icon github"><a href="https://github.com/wpcampus/"><img src="<?php echo $images_dir; ?>github-white.svg" alt="<?php printf( esc_attr__( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'GitHub' ); ?>" /></a></li>
	        </ul>
	        <?php
	        // @TODO Remove after testing.
	        /* ?>
            <ul>
                <li class="has-submenu<?php echo is_page( 'get-involved' ) || is_page( 'member-survey' ) ? ' current' : null; ?>">
	                <a href="<?php echo $blog_url; ?>/get-involved/">Get Involved</a>
	                <ul>
		                <li><a href="/get-involved/">Get Involved</a></li>
		                <li><a href="/member-survey/">Member Survey</a></li>
	                </ul>
                </li>
                <li class="has-submenu"><a href="<?php echo $blog_url; ?>/conferences/">Conferences</a>
                    <ul>
	                    <li><a href="https://2017.wpcampus.org/">WPCampus 2017</a></li>
	                    <li><a href="<?php echo $blog_url; ?>/online/">WPCampus Online</a></li>
                        <li><a href="https://2016.wpcampus.org/">WPCampus 2016</a></li>
                    </ul>
                </li>
                <li<?php echo is_post_type_archive( 'podcast' ) || is_singular( 'podcast' ) ? ' class="current"' : null; ?>><a href="<?php echo $blog_url; ?>/podcast/">Podcast</a></li>
                <li<?php echo $is_events_page ? ' class="current"' : null; ?>><a href="<?php echo $blog_url; ?>/events/">Events</a></li>
                <li<?php echo is_page( 'contact' ) ? ' class="current"' : null; ?>><a href="<?php echo $blog_url; ?>/contact/">Contact</a></li>
            </ul>
	        <?php */
	        ?>
		</div> <!-- #wpcampus-main-menu -->
	</div> <!-- #wpcampus-banner -->
	<div id="wpcampus-hero">
		<div class="row">
			<div class="small-12 columns">
				<div class="wpcampus-header">
					<?php

					// If home, add a <h1>.
					echo $is_front_page ? '<h1>' : null;

					?><a class="wpcampus-logo" href="<?php echo $blog_url; ?>">
						<span class="screen-reader-text">WPCampus</span>
						<img src="<?php echo $images_dir; ?>wpcampus-white.svg" alt="" />
						<span class="wpcampus-tagline"><?php printf( __( 'Where %s Meets Higher Education', 'wpcampus' ), 'WordPress' ); ?></span>
					</a><?php

					// If home, close the <h1>.
					echo $is_front_page ? '</h1>' : null;

					// Create buttons.
					$get_involved_button = '<a href="/get-involved/" class="button royal-blue">' . __( 'Get Involved', 'wpcampus' ) . '</a>';
					$member_survey_button = '<a href="/member-survey/" class="button royal-blue">' . __( 'Member Survey', 'wpcampus' ) . '</a>';
					//$ed_survey_button = '<a href="https://2017.wpcampus.org/announcements/wordpress-in-education-survey/" class="button royal-blue">' . sprintf( __( '%s in Education Survey', 'wpcampus' ), 'WP' ) . '</a>';
					//$wpc_online_button = '<a href="https://online.wpcampus.org/watch/" class="button royal-blue">' . sprintf( __( 'Watch %s Online', 'wpcampus' ), 'WPCampus' ) . '</a>';
					$wpc_2017_button = '<a href="https://2017.wpcampus.org/" class="button royal-blue">' . sprintf( __( '%s 2017 Conference', 'wpcampus' ), 'WPCampus' ) . '</a>';

					// Print buttons.
					if ( is_page( 'get-involved' ) ) {
						echo "{$member_survey_button} {$wpc_2017_button}";
					} else {
						echo "{$get_involved_button}{$wpc_2017_button}";
					}

					?>
				</div><!-- .wpcampus-header -->
			</div>
		</div>
	</div>
	<?php
	/*<div id="wpc-online-details">
		<div class="row">
			<div class="small-12 columns centered">
				<p><strong>The WPCampus 2017 <a href="https://2017.wpcampus.org/call-for-speakers/">call for speakers</a> has been extended until March 29, 2017.</strong><br />Share your WordPress and higher ed knowledge with our community. <a class="wpc-details-action" href="https://2017.wpcampus.org/call-for-speakers/"><strong>Apply to speak at WPCampus 2017</strong></a></p>
			</div>
		</div>
	</div>*/
	?>
	<div id="wpc-notifications"></div>
	<script id="wpc-notification-template" type="x-tmpl-mustache">
		{{#.}}
			<div class="wpc-notification">
				<div class="wpc-notification-message">
					{{{content.rendered}}}
				</div>
			</div>
		{{/.}}
	</script>
	<?php

	if ( ! $is_front_page ) :
		?>
		<div id="wpcampus-main-page-title">
			<div class="inside">
				<h1><?php

				/*
				 * Print page title.
				 */
				if ( is_404() ) {
					echo 'Page Not Found';
				} else {
					echo apply_filters( 'wpcampus_page_title', get_the_title() );
				}

				?></h1>
				<?php

				// If article, include article meta.
				if ( is_singular( array( 'post', 'podcast', 'video' ) ) ) {
					wpcampus_print_article_meta();
				}

				// Include breadcrumbs.
				wpcampus_print_breadcrumbs();

				?>
			</div>
		</div>
		<?php
	endif;

	?>
	<div id="wpcampus-main">
		<div class="row">
			<div id="wpcampus-content" class="small-12 columns">
