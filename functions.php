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

// Add the AddThis script to the footer
add_action( 'wp_footer', function() {
    ?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55c7ed90ac8a8479" async="async"></script><?php
});

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

// Add login styles
add_action( 'login_head', function() {

    ?><style type="text/css">
    #login h1 a {
        display: block;
        background: url( "<?php echo get_stylesheet_directory_uri(); ?>/images/wordcampus-black.svg" ) center bottom no-repeat;
        background-size: 100% auto;
        width: 90%;
        height: 50px;
    }
    .login form {
        padding-bottom: 35px;
    }
    .login form .forgetmenot {
        float: none;
    }
    #login form p.submit {
        display: block;
        clear: both;
        margin: 20px 0 0 0;
    }
    .login form .button {
        display: block;
        background: #555;
        float: none;
        width: 100%;
        height: auto !important;
        border: 0;
        color: #fff;
        cursor: pointer;
        padding: 12px 0 12px 0 !important;
        font-size: 1.1em;
        line-height: 1em !important;
        text-transform: uppercase;
    }
    .login form .button:hover {
        background: #222;
    }
    </style><?php

});

//! Filter login logo URL
add_filter( 'login_headerurl', function( $login_header_url ) {
    return get_bloginfo( 'url' );
});

//! Hide Query Monitor if admin bar isn't showing
add_filter( 'qm/process', function( $show_qm, $is_admin_bar_showing ) {
    return $is_admin_bar_showing;
});