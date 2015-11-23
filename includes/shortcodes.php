<?php

// Return WPCampus data
add_shortcode( 'wpcampus_data', function( $args, $content = NULL ) {

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
            return wpcampus_get_interested_count();
            break;

        case 'attend_in_person':
            return format_wpcampus_data_set( wpcampus_get_attend_in_person_count(), $args[ 'format' ] );
            break;

        case 'attend_has_location':
            return format_wpcampus_data_set( wpcampus_get_interested_has_location_count(), $args[ 'format' ] );
            break;

        case 'attend_live_stream':
            return format_wpcampus_data_set( wpcampus_get_attend_live_stream_count(), $args[ 'format' ] );
            break;

        case 'work_in_higher_ed':
            return format_wpcampus_data_set( wpcampus_get_work_in_higher_ed_count(), $args[ 'format' ] );
            break;

        case 'work_for_company':
            return format_wpcampus_data_set( wpcampus_get_work_for_company_count(), $args[ 'format' ] );
            break;

        case 'work_outside_higher_ed':
            return format_wpcampus_data_set( wpcampus_get_work_outside_higher_ed_count(), $args[ 'format' ] );
            break;

        case 'group_attending':
        case 'group_hosting':
        case 'group_planning':
        case 'group_speaking':
        case 'group_sponsoring':
            return format_wpcampus_data_set( wpcampus_get_group_count( preg_replace( '/^group\_/i', '', $args['set'] ) ), $args[ 'format' ] );
            break;

        case 'no_of_votes_on_new_name':
            return format_wpcampus_data_set( wpcampus_get_vote_on_new_name_count() );
            break;

    }

    return $content;

});

function format_wpcampus_data_set( $count, $format = 'number' ) {

    switch( $format ) {

        case 'number':
        case 'both':
            $number = $count;

            if ( 'number' == $format ) {
                return $number;
            }

        case 'percent':
        case 'both':

            // Get total
            $total = wpcampus_get_interested_count();

            // Add percentage
            $percent = round( ( $count / $total ) * 100 ) . '%';

            if ( 'percent' == $format ) {
                return $percent;
            }

            return "{$number} ({$percent})";

        default:
            return $count;

    }

}