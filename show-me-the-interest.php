<?php

// Template Name: Show Me The Interest

// Add the AddThis script
add_action( 'wp_footer', function() {
    ?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55c7ed90ac8a8479" async="async"></script><?php
});

get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();

        the_content();

    }

}

get_footer();