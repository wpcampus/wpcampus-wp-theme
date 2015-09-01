<?php

$blog_url = get_bloginfo('url');

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php wp_title( '-', true, 'left' ); ?></title>

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

    <div id="wpcampus-banner">
        <ul class="menu">
            <li<?php echo is_front_page() ? ' class="current"' : null; ?>><a href="<?php echo $blog_url; ?>">Get Involved</a></li>
            <li<?php echo is_page( 'contact' ) ? ' class="current"' : null; ?>><a href="<?php echo $blog_url; ?>/contact/">Contact Us</a></li>
        </ul>
    </div> <!-- #wpcampus-banner -->

    <div id="wpcampus-hero">
        <div class="row">
            <div class="small-12 columns">
                <div class="wpcampus-header">
                    <a class="wpcampus-logo" href="<?php echo $blog_url; ?>">
                        <span class="wpcampus-word">WordCampus</span>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/wordcampus.svg" />
                    </a>
                    <span class="wpcampus-tagline">Where WordPress Meets Higher Education</span>
                    <?php /*<a class="button">Get Involved</a>*/ ?>
                </div> <!-- .wpcampus-header -->
            </div>
        </div>
    </div><?php

    if ( ! is_front_page() ) {
        ?><h1 id="wpcampus-main-page-title"><?php the_title(); ?></h1><?php
    }

    ?><div id="wpcampus-main">
        <div class="row">
            <div class="small-12 columns">