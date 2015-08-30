<?php

// Return WordCampus data
add_shortcode( 'wordcampus_data', function( $args, $content = NULL ) {

    // Process args
    $defaults = array(
        'set' => null,
        'format' => 'number' // Other options: percent, both
    );
    $args = wp_parse_args($args, $defaults);

    // Build the content
    $content = null;

    switch( $args['set'] ) {

        case 'no_of_interested':
            return wordcampus_get_interested_count();

        case 'attend_in_person':

            // Get the count
            $attend_in_person_count = wordcampus_get_attend_in_person_count();

            switch( $args[ 'format' ] ) {

                case 'number':
                case 'both':
                    $number = $attend_in_person_count;

                    if ( 'number' == $args[ 'format' ] ) {
                        return $number;
                    }

                case 'percent':
                case 'both':

                    // Get total
                    $total = wordcampus_get_interested_count();

                    // Add percentage
                    $percent = round( ( $attend_in_person_count / $total ) * 100 ) . '%';

                    if ( 'percent' == $args[ 'format' ] ) {
                        return $percent;
                    }

                    return "{$number} ({$percent})";

                default:
                    return $attend_in_person_count;

            }

            break;

        case 'attend_live_stream':

            // Get the count
            $attend_live_stream_count = wordcampus_get_attend_live_stream_count();

            switch( $args[ 'format' ] ) {

                case 'number':
                case 'both':
                    $number = $attend_live_stream_count;

                    if ( 'number' == $args[ 'format' ] ) {
                        return $number;
                    }

                case 'percent':
                case 'both':

                    // Get total
                    $total = wordcampus_get_interested_count();

                    // Add percentage
                    $percent = round( ( $attend_live_stream_count / $total ) * 100 ) . '%';

                    if ( 'percent' == $args[ 'format' ] ) {
                        return $percent;
                    }

                    return "{$number} ({$percent})";

                default:
                    return $attend_live_stream_count;

            }

            break;

    }

    return $content;

});