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

//! Load favicons
add_action( 'wp_head', 'wordcampus_add_favicons' );
add_action( 'admin_head', 'wordcampus_add_favicons' );
add_action( 'login_head', 'wordcampus_add_favicons' );
function wordcampus_add_favicons() {

    // Set the images folder
    $favicons_folder = get_stylesheet_directory_uri() . '/images/favicons/';

    // Print the default icons
    ?><link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wordcampus-favicon-60.png"/>
    <link rel="apple-touch-icon" href="<?php echo $favicons_folder; ?>wordcampus-favicon-60.png"/><?php

    // Set the image sizes
    $image_sizes = array( 57, 72, 76, 114, 120, 144, 152 );

    foreach( $image_sizes as $size ) {
        ?><link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wordcampus-favicon-<?php echo $size; ?>.png"/><?php
    }

}

//! Hide Query Monitor if admin bar isn't showing
add_filter( 'qm/process', function( $show_qm, $is_admin_bar_showing ) {
    return $is_admin_bar_showing;
});