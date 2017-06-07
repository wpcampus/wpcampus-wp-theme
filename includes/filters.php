<?php

/**
 * Remove the auto <p> when needed.
 */
function wpcampus_remove_filters() {

	// Remove on order t-shirt page.
	if ( is_page( 'order-wpcampus-shirt' ) ) {
		remove_filter( 'the_content', 'wpautop' );
	}
}
add_action( 'wp', 'wpcampus_remove_filters' );

/**
 * Filter the nav menu item CSS.
 *
 * @param   $classes - array - The CSS classes that are applied to the menu item's `<li>` element.
 * @param   $item - WP_Post - The current menu item.
 * @param   $args- stdClass - An object of wp_nav_menu() arguments.
 * @param   $depth - int - Depth of menu item. Used for padding.
 * @return  array - the filtered classes array.
 */
function wpcampus_filter_nav_menu_css_class( $classes, $item, $args, $depth ) {
	if ( is_singular( 'podcast' ) && '/podcast/' == $item->url ) {
		$classes[] = 'current-menu-item';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'wpcampus_filter_nav_menu_css_class', 100, 4 );

/**
 * Filter the page title.
 */
function wpcampus_filter_page_title( $page_title ) {

	/*
	 * Change the page title.
	 *
	 * Had to write in for events because the
	 * events plugin was overwriting the
	 * 'post_type_archive_title' filter.
	 */
	if ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
		return __( 'Events', 'wpcampus' );
	} elseif ( is_post_type_archive( 'podcast' ) ) {
		return sprintf( __( 'The %s Podcast', 'wpcampus' ), 'WPCampus' );
	} elseif ( is_singular( 'podcast' ) ) {
		return '<span class="fade">' . __( 'Podcast:', 'wpcampus' ) . '</span> ' . $page_title;
	}

	return $page_title;
}
add_filter( 'wpcampus_page_title', 'wpcampus_filter_page_title' );

/**
 * Filter the post type archive title.
 */
function wpcampus_filter_post_type_archive_title( $title, $post_type ) {

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
add_filter( 'wpcampus_post_type_archive_title', 'wpcampus_filter_post_type_archive_title', 100, 2 );

/**
 * Filter/build our own map infowindow content.
 */
function wpcampus_filter_gmb_mashup_infowindow_content( $response, $marker_data, $post_id ) {

	// Only for interest posts.
	if ( 'wpcampus_interest' != get_post_type( $marker_data['id'] ) ) {
		return $response;
	}

	// Build new infowindow content.
	$response['infowindow'] = '<div id="infobubble-content" class="main-place-infobubble-content">';

	// Get location
	$location = wpcampus_get_interest_location( $post_id );
	if ( ! empty( $location ) ) {
		$response['infowindow'] .= '<p class="place-title">' . $location . '</p>';
	}

	// Close the window element.
	$response['infowindow'] .= '</div>';

	return $response;
}
add_filter( 'gmb_mashup_infowindow_content', 'wpcampus_filter_gmb_mashup_infowindow_content', 100, 3 );
