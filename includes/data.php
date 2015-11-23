<?php

// Get number of interested
function wpcampus_get_interested_count() {
    return GFAPI::count_entries( 1, array( 'status' => 'active' ) );
}

// Get number of interested who want to attend in person
function wpcampus_get_attend_in_person_count() {
    $search_criteria = array( 'status' => 'active' );
    $search_criteria['field_filters'][] = array( 'key' => '6', 'operator' => 'like', 'value' => 'Attend in person' );
    return $counts = GFAPI::count_entries( 1, $search_criteria );
}

// Get number of interested who want to attend via live stream
function wpcampus_get_attend_live_stream_count() {
    $search_criteria = array( 'status' => 'active' );
    $search_criteria['field_filters'][] = array( 'key' => '6', 'operator' => 'like', 'value' => 'Attend via live stream' );
    return $counts = GFAPI::count_entries( 1, $search_criteria );
}

// Get number of interested who work in higher ed
function wpcampus_get_work_in_higher_ed_count() {
    $search_criteria = array( 'status' => 'active' );
    $search_criteria['field_filters'][] = array( 'key' => '5', 'operator' => 'contains', 'value' => 'I work at a higher ed institution' );
    return $counts = GFAPI::count_entries( 1, $search_criteria );
}

// Get number of interested who work for a company that supports higher ed
function wpcampus_get_work_for_company_count() {
    $search_criteria = array( 'status' => 'active' );
    $search_criteria['field_filters'][] = array( 'key' => '5', 'operator' => 'contains', 'value' => 'I freelance or work for a company that supports higher ed' );
    return $counts = GFAPI::count_entries( 1, $search_criteria );
}

// Get number of interested who work outside higher ed
function wpcampus_get_work_outside_higher_ed_count() {
    $search_criteria = array( 'status' => 'active' );
    $search_criteria['field_filters'][] = array( 'key' => '5', 'operator' => 'contains', 'value' => 'I work outside higher ed but am interested in higher ed' );
    return $counts = GFAPI::count_entries( 1, $search_criteria );
}

// Get interest by the best time of the year
function wpcampus_get_interest_best_time_of_year() {

    // Store counts - start with total
    $counts = array(
        'Total' => wpcampus_get_interested_count(),
    );

    // Set options
    $options = array(
        'Early Spring', 'Middle Spring', 'Late Spring',
        'Early Summer', 'Middle Summer', 'Late Summer',
        'Early Fall', 'Middle Fall', 'Late Fall'
    );

    // Get by option
    foreach ( $options as $option ) {

        // Setup search criteria
        $search_criteria = array( 'status' => 'active' );

        // Setup field filters
        $search_criteria['field_filters'][] = array( 'key' => '13', 'operator' => 'contains', 'value' => $option );

        // Get the count
        $counts[ $option ] = GFAPI::count_entries( 1, $search_criteria );

    }

    return $counts;

}

// Get number of interest by country
function wpcampus_get_interest_by_country() {
    global $wpdb;
    return $wpdb->get_results( "SELECT meta_value AS country, COUNT(*) AS count FROM {$wpdb->postmeta} WHERE meta_key = 'traveling_country' AND meta_value != '' GROUP BY meta_value ORDER BY count DESC");
};

// Get number of interested who provided their location
function wpcampus_get_interested_has_location_count() {
    global $wpdb;

    // Build query
    $query = "SELECT COUNT(posts.ID) AS count FROM {$wpdb->posts} posts";

    foreach( array( 'city', 'state' ) as $meta_key ) {
        $query .= " INNER JOIN {$wpdb->postmeta} {$meta_key} ON {$meta_key}.post_id = posts.ID AND {$meta_key}.meta_key = 'traveling_{$meta_key}' AND {$meta_key}.meta_value != ''";
    }

    $query .= " WHERE posts.post_type = 'wpcampus_interest' AND posts.post_status = 'publish'";

    return $wpdb->get_var($query);
}

// Get interest location
function wpcampus_get_interest_location( $post_id ) {

    // Get data
    $location = array();
    foreach( array( 'traveling_city', 'traveling_state', 'traveling_country' ) as $meta_key ) {
        $location[] = ucfirst( get_post_meta( $post_id, $meta_key, true ) );
    }

    // Build string
    if ( $location = array_filter( $location ) ) {
        return implode( ', ', $location );
    }

    return false;
}

// Get interest location
function wpcampus_get_interest_location_count( $location = array() ) {
    global $wpdb;

    // Process args
    $defaults = array(
        'city' => null,
        'state' => null,
        'country' => 'United States',
    );
    $location = wp_parse_args( $location, $defaults );

    // Build query
    $query = "SELECT COUNT(posts.ID) AS count FROM {$wpdb->posts} posts";

    foreach( $location as $meta_key => $meta_value ) {
        $query .= " INNER JOIN {$wpdb->postmeta} {$meta_key} ON {$meta_key}.post_id = posts.ID AND {$meta_key}.meta_key = 'traveling_{$meta_key}' AND {$meta_key}.meta_value LIKE '{$meta_value}'";
    }

    $query .= " WHERE posts.post_type = 'wpcampus_interest' AND posts.post_status = 'publish'";

    return $wpdb->get_var($query);
}

// Get group count
function wpcampus_get_group_count( $group ) {
    $search_criteria = array( 'status' => 'active' );
    $search_criteria['field_filters'][] = array( 'key' => '7', 'operator' => 'contains', 'value' => $group );
    return $counts = GFAPI::count_entries( 1, $search_criteria );
}

function wpcampus_get_interest_sessions() {

    // Get form in
    if ( $form = GFAPI::get_form( 1 ) ) {

        // Loop through each field
        $field_id = 15;
        foreach( $form['fields'] as $field ) {

            // Only for our specific field id
            if ( $field[ 'id' ] != $field_id ) {
                continue;
            }

            // Make sure we have choices
            if ( ! $field['choices'] ) {
                return false;
            }

            // Store counts - start with total
            $counts = array(
                'Total' => wpcampus_get_interested_count(),
            );

            // Get by option
            $choice_index = 1;
            foreach ($field['choices'] as $choice) {

                // Setup search criteria
                $search_criteria = array('status' => 'active');

                // Setup field filters
				// Modified to match checkbox filter sample in get_entries(), per https://www.gravityhelp.com/documentation/article/api-functions/#get_entries
                $search_criteria[ 'field_filters' ][] = array( 'key' => "{$field_id}", 'operator' => 'in', 'value' => array( $choice['value'] ) );

                // Get the count
                $this_counts = GFAPI::count_entries(1, $search_criteria);

                // Add to counts
                $counts[ $choice['value']  ] = $this_counts;

                $choice_index++;

            }

            return $counts;

        }

    }

    return false;

}

function wpcampus_get_interest_universities() {
    $search_criteria = array( 'status' => 'active' );
    $search_criteria['field_filters'][] = array( 'key' => '5', 'operator' => 'contains', 'value' => 'I work at a higher ed institution' );
    //$search_criteria['field_filters'][] = array( 'key' => '4', 'operator' => 'is not', 'value' => '' );
    if ( $entries = GFAPI::get_entries( 1, $search_criteria ) ) {

        $work = array();

        // Go through and create list of where they work
        foreach( $entries as $entry ) {
            if ( $workplace = rgar( $entry, '4' ) ) {
                $work[] = $workplace;
            }
        }

        if ( ! empty( $work ) ) {
            return $work;
        }

    }
    return false;
}

// Get the total number of votes for the vote on our new name
function wpcampus_get_vote_on_new_name_count() {
    return GFAPI::count_entries( 6, array( 'status' => 'active' ) );
}

// Get the count by choice for the vote on our new name
function wpcampus_get_vote_on_new_name() {

    // Set the form ID
    $form_id = 6;

    // Build response
    $response = array();

    // Get form
    if ( ( $form = GFAPI::get_form( $form_id ) )
        && ( $fields = $form['fields'] ) ) {

        foreach( $fields as $field ) {

            // Get our specific field
            if ( 'Vote on New Name' == $field->adminLabel ) {

                foreach( $field->choices as $choice ) {

                    // Get the count
                    $search_criteria = array( 'status' => 'active' );
                    $search_criteria['field_filters'][] = array( 'key' => $field->id, 'operator' => '=', 'value' => $choice['value'] );
                    $choice_count = GFAPI::count_entries( $form_id, $search_criteria );

                    // Add to response
                    $response[] = array(
                        'text'  => $choice['text'],
                        'count' => $choice_count,
                    );

                }

                break;

            }

        }

    }

    return $response;
}