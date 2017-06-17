<?php

/**
 * Build the university infowindow content.
 */
add_filter( 'gmb_mashup_infowindow_content', function( $response, $marker_data, $post_id ) {

	// Only for university posts.
	if ( 'universities' != get_post_type( $marker_data['id'] ) ) {
		return $response;
	}

	// Get the title.
	$post_title = get_the_title( $post_id );

	// Get website.
	$website = get_post_meta( $post_id, 'website', true );

	// Build new infowindow content.
	$response['infowindow'] = '<div class="google-maps-info-content info-universities">';

	// Add title.
	if ( $website ) {
		$response['infowindow'] .= '<h3 class="info-title"><a href="' . $website . '" target="_blank">' . $post_title . '</a></h3>';
	} else {
		$response['infowindow'] .= '<h3 class="info-title">' . $post_title . '</h3>';
	}

	// Display location.
	$location_data = wpcampus_get_university_location( $post_id );
	if ( $location_data ) {

		// Print address.
		if ( ! empty( $location_data['city'] ) ) {

			// Build location string.
			$location = $location_data['city'];

			if ( ! empty( $location_data['state'] ) ) {
				if ( ! empty( $location_data['city'] ) ) {
					$location .= ', ';
				} else {
					$location .= '<br />';
				}
				$location .= $location_data['state'];
			}

			if ( ! empty( $location_data['country'] ) ) {
				$location .= "<br />{$location_data['country']}";
			}

			// Add location string.
			if ( $location ) {
				$response['infowindow'] .= '<p class="location">' . $location . '</p>';
			}
		}
	}

	$response['infowindow'] .= '</div>';

	return $response;
}, 100, 3 );

/**
 * Get saved university info before ACF runs.
 */
add_action( 'acf/save_post', function( $post_id ) {
	global $saved_university_location;

	// Only for universities post type.
	if ( 'universities' != get_post_type( $post_id ) ) {
		return;
	}

	// Get saved location before ACF updates the info.
	$saved_university_location = wpcampus_get_university_location_string( $post_id );

}, 1 );

/**
 * Runs when university posts are saved after ACF runs.
 */
add_action( 'acf/save_post', function( $post_id ) {
	global $saved_university_location;

	// Only for universities post type.
	if ( 'universities' != get_post_type( $post_id ) ) {
		return;
	}

	// Get updated location.
	$updated_university_location = wpcampus_get_university_location_string( $post_id );

	// If updated is not different than saved, then no point.
	if ( $updated_university_location == $saved_university_location ) {
		return;
	}

	// Delete the existing post meta.
	delete_post_meta( $post_id, 'latitude' );
	delete_post_meta( $post_id, 'longitude' );

	// Make sure our plugin is activated.
	if ( function_exists( 'wpcampus_plugin' ) ) {

		// Get latitude and longitude.
		$location_lat_long = wpcampus_plugin()->get_lat_long( $updated_university_location );
	    if ( ! empty( $location_lat_long ) ) {

		    // Add latitude.
		    if ( $latitude = isset( $location_lat_long->lat ) ? $location_lat_long->lat : false ) {
			    add_post_meta( $post_id, 'latitude', $latitude, true );
		    }

		    // Add longitude.
		    if ( $longitude = isset( $location_lat_long->lng ) ? $location_lat_long->lng : false ) {
				add_post_meta( $post_id, 'longitude', $longitude, true );
		    }
	    }
	}
}, 1000 );

/**
 * Get university location array.
 */
function wpcampus_get_university_location( $post_id ) {

	// Get data.
	$location = array();
	foreach ( array( 'address_1', 'address_2', 'city', 'state', 'zip_code', 'country' ) as $meta_key ) {
		$location[ $meta_key ] = ucfirst( get_post_meta( $post_id, $meta_key, true ) );
	}

	return $location;
}

/**
 * Get university location string.
 */
function wpcampus_get_university_location_string( $post_id ) {

	// Get/build string.
	if ( $location = array_filter( wpcampus_get_university_location( $post_id ) ) ) {
		return preg_replace( '/[\s]{2,}/i', ' ', implode( ' ', $location ) );
	}

	return false;
}
