<?php

//! Filter login logo URL
add_filter( 'login_headerurl', function( $login_header_url ) {
	return get_bloginfo( 'url' );
});

// Filter/build our own map infowindow content
add_filter( 'gmb_mashup_infowindow_content', function( $response, $marker_data, $post_id ) {

	// Only for interest posts
	if ( 'wpcampus_interest' != get_post_type( $marker_data['id'] ) ) {
		return $response;
	}

	// Build new infowindow content
	$response['infowindow'] = '<div id="infobubble-content" class="main-place-infobubble-content">';

	// Get location
	if ( $location = wordcampus_get_interest_location($post_id) ) {
		$response['infowindow'] .= '<p class="place-title">' . $location . '</p>';
	}

	$response['infowindow'] .= '</div>';

	return $response;

}, 100, 3 );