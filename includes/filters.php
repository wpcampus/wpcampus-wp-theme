<?php

/**
 * Filter the <body> class.
 */
function wpc_filter_body_class( $classes, $class ) {

	// See if there is a sidebar.
	$sidebar_id = wpc_get_current_sidebar();
	if ( $sidebar_id ) {
		$classes[] = 'has-sidebar';
		$classes[] = 'has-sidebar-' . preg_replace( '/^wpc\-sidebar\-/i', '', $sidebar_id );
	}

	return $classes;
}
add_filter( 'body_class', 'wpc_filter_body_class', 10, 2 );

/**
 * Filter the page title.
 */
function wpc_filter_page_title( $page_title ) {

	/*
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
}
add_filter( 'wpcampus_page_title', 'wpc_filter_page_title' );

/**
 * Filter the post type archive title.
 */
function wpc_filter_post_type_archive_title( $title, $post_type ) {

	/*
	 * Had to write in because events plugin was
	 * overwriting the 'post_type_archive_title' filter.
	 */
	if ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
		return __( 'Events', 'wpcampus' );
	}

	if ( is_post_type_archive( 'podcast' ) ) {
		return __( 'Podcast', 'wpcampus' );
	}

	return $title;
}
add_filter( 'wpcampus_post_type_archive_title', 'wpc_filter_post_type_archive_title', 100, 2 );

/**
 * Filter/build our own map infowindow content.
 */
function wpc_filter_gmb_mashup_infowindow( $response, $marker_data, $post_id ) {

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

}
add_filter( 'gmb_mashup_infowindow_content', 'wpc_filter_gmb_mashup_infowindow', 100, 3 );
