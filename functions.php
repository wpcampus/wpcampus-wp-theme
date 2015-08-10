<?php

//! Setup styles and scripts
add_action( 'wp_enqueue_scripts', function () {

    // Get the directory
    $wordcampus_dir = trailingslashit( get_stylesheet_directory_uri() );

    // Load Fonts
    wp_enqueue_style( 'wordcampus-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:600,400,300' );

    // Enqueue the base styles
    wp_enqueue_style( 'wordcampus', $wordcampus_dir . 'css/styles.min.css', array( 'wordcampus-fonts' ), false );

    // Enqueue modernizr - goes in header
    wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js' );

}, 10 );

//! Hide Query Monitor if admin bar isn't showing
add_filter( 'qm/process', function( $show_qm, $is_admin_bar_showing ) {
    return $is_admin_bar_showing;
});