<?php

// Return WordCampus data
add_shortcode( 'wordcampus_data', function( $args, $content = NULL ) {

    // Process args
    $defaults = array(
        'data' => null,
    );
    $args = wp_parse_args($args, $defaults);

    // Build the content
    $content = null;

    switch( $args['data']) {

        case 'no_of_interested':

            if ( $counts = GFAPI::count_entries( 1, array( 'status' => 'active' ) ) ) {
                return $counts;
            }

            break;

    }

    return $content;

});