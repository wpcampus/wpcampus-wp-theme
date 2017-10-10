<?php

/**
 * Remove the auto <p> when needed.
 */
function wpcampus_add_remove_filters() {

	// Remove on order t-shirt page.
	if ( is_page( 'order-wpcampus-shirt' ) ) {
		remove_filter( 'the_content', 'wpautop' );
	}
}
add_action( 'wp', 'wpcampus_add_remove_filters' );

/**
 * Add the AddThis bar before articles.
 */
function wpcampus_add_addthis_before_article() {

	if ( ! is_singular( array( 'post', 'podcast', 'video' ) ) ) {
		return;
	}

	?>
	<div class="addthis_sharing_toolbox"></div>
	<?php
}
add_action( 'wpcampus_before_article_content', 'wpcampus_add_addthis_before_article' );

/**
 * Add contributor info after articles.
 */
function wpcampus_add_contributor_after_article() {
	if ( is_singular( array( 'post', 'podcast', 'video' ) ) ) {

		// Print the multi authors.
		$authors = array();
		if ( function_exists( 'my_multi_author' ) && method_exists( my_multi_author(), 'get_authors' ) ) {
			$authors = my_multi_author()->get_authors();
			if ( ! empty( $authors ) ) {
				foreach ( $authors as $author_id ) {
					wpcampus_print_contributor( $author_id );
				}
			}
		}

		// If no authors, print the primary contributor.
		if ( empty( $authors ) ) {
			wpcampus_print_contributor();
		}
	}
}
add_action( 'wpcampus_after_article', 'wpcampus_add_contributor_after_article', 15 );

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
	if ( is_singular( 'post' ) && 'Blog' == $item->title ) {
		$classes[] = 'current-menu-item';
	} elseif ( is_singular( 'podcast' ) && '/podcast/' == $item->url ) {
		$classes[] = 'current-menu-item';
	} elseif ( is_singular( 'video' ) && 'Videos' == $item->title ) {
		$classes[] = 'current-menu-item';
	} elseif ( is_singular( 'tribe_events' ) && '/events/' == $item->url ) {
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
	if ( is_singular( 'post' ) ) {
		return '<span class="fade type">' . __( 'Blog:', 'wpcampus' ) . '</span> ' . $page_title;
	} elseif ( is_home() ) {
		return sprintf( __( 'The %s Blog', 'wpcampus' ), 'WPCampus' );
	} elseif ( is_author() ) {

		// Build the filtered title.
		$author_page_title = '<span class="fade type">' . __( 'Contributor:', 'wpcampus' ) . '</span> ';

		// Get the queried author.
		$author = get_queried_object();

		// Get queried author ID.
		if ( ! empty( $author->ID ) && $author->ID > 0 ) {
			$author_page_title .= get_the_author_meta( 'display_name', $author->ID );
		} else {
			$author_page_title .= get_the_author();
		}

		return $author_page_title;

	} elseif ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
		return __( 'Events', 'wpcampus' );
	} elseif ( is_post_type_archive( 'podcast' ) ) {
		return sprintf( __( 'The %s Podcast', 'wpcampus' ), 'WPCampus' );
	} elseif ( is_post_type_archive( 'product' ) || is_singular( 'product' ) ) {
		return sprintf( __( 'The %s Shop', 'wpcampus' ), 'WPCampus' );
	} elseif ( is_singular( 'podcast' ) ) {
		return '<span class="fade type">' . __( 'Podcast:', 'wpcampus' ) . '</span> ' . $page_title;
	} elseif ( is_singular( 'video' ) ) {
		return '<span class="fade type">' . __( 'Video:', 'wpcampus' ) . '</span> ' . $page_title;
	} elseif ( is_category() ) {

		// Add category header.
		$categories = get_the_category();
		if ( ! empty( $categories ) ) :
			$category = array_shift( $categories );
			if ( ! empty( $category ) ) :
				return '<span class="fade">' . sprintf( __( 'The %s Blog:', 'wpcampus' ), 'WPCampus' ) . '</span> ' . $category->name;
			endif;
		endif;

	} elseif ( is_archive() ) {

		// Get the post type.
		$post_type = get_post_type();
		if ( 'post' == $post_type ) {
			return sprintf( __( 'The %s Blog', 'wpcampus' ), 'WPCampus' );
		}
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
 * Adjust queries
 */
function wpcampus_adjust_queries( $query ) {

	// Don't run in the admin.
	if ( is_admin() ) {
		return;
	}

	// Only for the main query.
	if ( ! $query->is_main_query() ) {
		return;
	}

	/*
	 * For now, get all posts and podcasts posts.
	 *
	 * @TODO add pagination.
	 */
	if ( is_post_type_archive( array( 'podcast', 'post', 'video' ) ) && $query->is_main_query() ) {
		$query->set( 'nopaging', true );
	}

	// Make sure these pages get all post types.
	if ( is_search() || is_author() || is_category() || is_tag() ) {
		$query->set( 'post_type', array( 'post', 'podcast', 'video' ) );
	}
}
add_action( 'pre_get_posts', 'wpcampus_adjust_queries' );

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


/**
 * Filter the page title.
 */
function wpcampus_filter_page_title_tag( $page_title , $separator) {
    if (is_post_type_archive( 'product' )) {
        $page_title = sprintf( __( 'The %s Shop', 'wpcampus' ), 'WPCampus' );
    }
    /*
	 * Change the page title.
	 *
	 * Had to write in for events because the
	 * events plugin was overwriting the
	 * 'post_type_archive_title' filter.
	 */

	return $page_title;
}
add_filter( 'wp_title', 'wpcampus_filter_page_title_tag', 20, 2 );
