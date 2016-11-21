<?php

$blog_url = get_bloginfo('url');
$stylesheet_dir = get_stylesheet_directory_uri();
$is_front_page = is_front_page();
$is_events_page = is_post_type_archive('tribe_events') || is_singular('tribe_events');

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php wp_title( '-', true, 'left' ); ?></title>

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
    <a href="#wpcampus-main" id="skip-to-content">Skip to Content</a>

    <div id="wpcampus-banner">
        <div class="toggle-main-menu">
            <div class="toggle-icon">
                <div class="bar one"></div>
                <div class="bar two"></div>
                <div class="bar three"></div>
            </div>
            <div class="open-menu-label">Menu</div>
            <div class="close-menu-label">Close</div>
        </div>
        <div id="wpcampus-main-menu" class="menu">
            <ul>
                <li class="icon has-icon-alt home<?php echo $is_front_page ? ' current' : null; ?>"><a href="<?php echo $blog_url; ?>"><img src="<?php echo $stylesheet_dir; ?>/images/home-white.svg" alt="Visit the WPCampus home page" /><span class="icon-alt">Home</span></a></li>
                <li class="has-submenu<?php echo is_page( 'get-involved' ) || is_page( 'member-survey' ) ? ' current' : null; ?>">
	                <a href="<?php echo $blog_url; ?>/get-involved/">Get Involved</a>
	                <ul>
		                <li><a href="/get-involved/">Get Involved</a></li>
		                <li><a href="/member-survey/">Member Survey</a></li>
	                </ul>
                </li>
                <li class="has-submenu"><a href="<?php echo $blog_url; ?>/conferences/">Conferences</a>
                    <ul>
	                    <li><a href="<?php echo $blog_url; ?>/online/">WPCampus Online</a></li>
                        <li><a href="https://2016.wpcampus.org/">WPCampus 2016</a></li>
                    </ul>
                </li>
                <li<?php echo is_post_type_archive('podcast') || is_singular('podcast') ? ' class="current"' : null; ?>><a href="<?php echo $blog_url; ?>/podcast/">Podcast</a></li>
                <li<?php echo $is_events_page ? ' class="current"' : null; ?>><a href="<?php echo $blog_url; ?>/events/">Events</a></li>
                <li<?php echo is_page( 'contact' ) ? ' class="current"' : null; ?>><a href="<?php echo $blog_url; ?>/contact/">Contact</a></li>
                <li class="icon twitter"><a href="https://twitter.com/wpcampusorg"><img src="<?php echo $stylesheet_dir; ?>/images/twitter-white.svg" alt="Follow WPCampus on Twitter" /></a></li>
                <li class="icon youtube"><a href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $stylesheet_dir; ?>/images/youtube-white.svg" alt="Follow WPCampus on YouTube" /></a></li>
                <li class="icon github"><a href="https://github.com/wpcampus/"><img src="<?php echo $stylesheet_dir; ?>/images/github-white.svg" alt="Follow WPCampus on GitHub" /></a></li>
            </ul>
        </div>
    </div> <!-- #wpcampus-banner -->

    <div id="wpcampus-hero">
        <div class="row">
            <div class="small-12 columns">
                <div class="wpcampus-header"><?php

                    // If home, add a <h1>
                    echo $is_front_page ? '<h1>' : null;

                    ?><a class="wpcampus-logo" href="<?php echo $blog_url; ?>">
                        <span class="screen-reader-text">WPCampus</span>
                        <img src="<?php echo $stylesheet_dir; ?>/images/wpcampus-white.svg" alt="" />
                        <span class="wpcampus-tagline">Where WordPress Meets Higher Education</span>
                    </a><?php

                    // If home, close the <h1>
                    echo $is_front_page ? '</h1>' : null;

                    // Create buttons
                    $get_involved_button = '<a href="/get-involved/" class="button royal-blue">Get Involved</a>';
                    $member_survey_button = '<a href="/member-survey/" class="button royal-blue">Member Survey</a>';
                    $attending_wcus_button = '<a href="/attending-wcus/" class="button royal-blue">Attending WCUS?</a>';

                    // Print buttons
                    if ( is_page( 'online/call-for-speakers' ) ) {
                        echo "{$get_involved_button} {$attending_wcus_button}";
                    } else if ( is_page( 'get-involved' ) ) {
                        echo $attending_wcus_button;
                    } else if ( is_page( 'attending-wcus' ) ) {
	                    echo $get_involved_button;
                    } else {
                       echo "{$get_involved_button} {$attending_wcus_button}";
                    }

                ?></div> <!-- .wpcampus-header -->
            </div>
        </div>
    </div><?php

    /*<div id="wpc-notification">
        <p><strong>The <a href="https://2016.wpcampus.org/speakers/">WPCampus 2016 call for speakers</a> is open and will close at 12 midnight EST on March 21, 2016.</strong></p>
    </div> <!-- #wpc-notification --><?php */

    if ( ! $is_front_page ) {
        ?><div id="wpcampus-main-page-title">
            <h1><?php

                // For 404s
                if ( is_404() ) {
                    echo 'Page Not Found';
                }

                // Print a title we can filter
                else {
                    echo apply_filters( 'wpcampus_page_title', get_the_title() );
                }

            ?></h1><?php

            // Include breadcrumbs
            if ( $breadcrumbs_html = wpcampus_get_breadcrumbs_html() ) {
                echo $breadcrumbs_html;
            }

        ?></div><?php

    }

    ?><div id="wpcampus-main">
        <div class="row">
            <div class="small-12 columns">