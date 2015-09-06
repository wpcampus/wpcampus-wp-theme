<?php

// Get saved university info before ACF runs
add_action( 'acf/save_post', function( $post_id ) {
    global $saved_university_location;

    // Only for universities post type
    if ( 'universities' != get_post_type( $post_id ) ) {
        return;
    }

    // Get saved location before ACF updates the info
    $saved_university_location = wordcampus_get_university_location( $post_id );

}, 1 );

// Runs when university posts are saved after ACF runs
add_action( 'acf/save_post', function( $post_id ) {
    global $saved_university_location;

    // Only for universities post type
    if ( 'universities' != get_post_type( $post_id ) ) {
        return;
    }

    // Get updated location
    $updated_university_location = wordcampus_get_university_location( $post_id );

    // If updated is not different than saved, then no point
    if ( $updated_university_location == $saved_university_location ) {
        return;
    }

    // Delete the existing post meta
    delete_post_meta( $post_id, 'latitude' );
    delete_post_meta( $post_id, 'longitude' );

    // Get latitude and longitude
    if ( $location_lat_long = wordcampus_get_lat_long( $updated_university_location ) ) {

        // Add latitude
        if ( $latitude = isset( $location_lat_long->lat ) ? $location_lat_long->lat : false ) {
            add_post_meta($post_id, 'latitude', $latitude, true);
        }

        // Add longitude
        if ( $longitude = isset( $location_lat_long->lng ) ? $location_lat_long->lng : false ) {
            add_post_meta($post_id, 'longitude', $longitude, true);
        }

    }

}, 1000 );

// Get university location string
function wordcampus_get_university_location( $post_id ) {

    // Get data
    $location = array();
    foreach( array( 'address_1', 'address_2', 'city', 'state', 'zip_code', 'country' ) as $meta_key ) {
        $location[] = ucfirst( get_post_meta( $post_id, $meta_key, true ) );
    }

    // Build string
    if ( $location = array_filter( $location ) ) {
        return preg_replace( '/[\s]{2,}/i', ' ', implode( ', ', $location ) );
    }

    return false;
}