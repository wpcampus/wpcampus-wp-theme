<?php

/**
 * Filter the page title.
 */
add_filter( 'wpcampus_page_title', function( $page_title ) {

	/**
	 * Change the title for various pages.
	 *
	 * Had to write in because events plugin was
	 * overwriting the 'post_type_archive_title' filter.
	 */
	if ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
		return __( 'Events', 'wpcampus' );
	} elseif ( is_post_type_archive( 'podcast' ) ) {
		return sprintf( __( '%s Podcast', 'wpcampus' ), 'WPCampus' );
	} elseif ( is_singular( 'podcast' ) ) {
		return '<span class="fade">' . __( 'Podcast', 'wpcampus' ) . ':</span> ' . $page_title;
	}

	return $page_title;
});

/**
 * Filter the post type archive title.
 */
add_filter( 'wpcampus_post_type_archive_title', function( $title, $post_type ) {

	// Had to write in because events plugin was overwriting the 'post_type_archive_title' filter.
	if ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
		return __( 'Events', 'wpcampus' );
	}

	if ( is_post_type_archive( 'podcast' ) ) {
		return __( 'Podcast', 'wpcampus' );
	}

	return $title;
}, 100, 2 );

/**
 * Filter/build our own map infowindow content.
 */
add_filter( 'gmb_mashup_infowindow_content', function( $response, $marker_data, $post_id ) {

	// Only for interest posts.
	if ( 'wpcampus_interest' != get_post_type( $marker_data['id'] ) ) {
		return $response;
	}

	// Build new infowindow content.
	$response['infowindow'] = '<div id="infobubble-content" class="main-place-infobubble-content">';

	// Get location.
	$location = wpcampus_get_interest_location( $post_id );
	if ( ! empty( $location ) ) {
		$response['infowindow'] .= '<p class="place-title">' . $location . '</p>';
	}

	// Close the window element.
	$response['infowindow'] .= '</div>';

	return $response;

}, 100, 3 );
