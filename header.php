<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php wp_title( '-', true, 'left' ); ?></title>

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

    <div id="wpcampus-banner"></div> <!-- #wpcampus-banner -->

    <div id="wpcampus-hero">
        <div class="row">
            <div class="small-12 columns">
                <div class="wpcampus-header">
                    <a class="wpcampus-logo" href="<?php echo get_bloginfo('url'); ?>">
                        <span class="wpcampus-word">WordCampus</span>
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/wordcampus.svg" />
                    </a>
                    <span class="wpcampus-tagline">Where WordPress Meets Higher Education</span>
                    <a class="button">Get Involved</a>
                </div> <!-- .wpcampus-header -->
            </div>
        </div>
    </div>

    <div id="wpcampus-main">
        <div class="row">
            <div class="small-12 columns">

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras risus urna, ullamcorper in ullamcorper in, dapibus vel leo. Nam diam odio, aliquam quis accumsan a, viverra non sem. Pellentesque non fringilla sapien.</p>