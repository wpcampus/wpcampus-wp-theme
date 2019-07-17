<?php

function wpcampus_add_document() {
	?>
	<script>
		document.domain='wpcampus.org';
	</script>
	<?php
}
add_action( 'login_head', 'wpcampus_add_document' );

function wpcampus_wp_title( $title, $sep, $seplocation ) {
	global $wp_query;

	if ( is_post_type_archive() ) {
		$post_type = $wp_query->get( 'post_type' );
		$post_type_obj = get_post_type_object( $post_type );
		return $post_type_obj->labels->name . " {$sep} " . get_bloginfo( 'title' );
	}

	return $title;
}
add_filter( 'wp_title', 'wpcampus_wp_title', 20, 3 );

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

function wpcampus_hide_from_archive( $pieces, $query ) {
	global $wpdb;

	// Only for archives.
	if ( ! $query->is_archive() && ! $query->is_home() && ! $query->get( 'wpc_hide_archive' ) ) {
		return $pieces;
	}

	if ( is_admin() ) {
		return $pieces;
	}

	// Join to get post meta.
	$pieces['join'] .= " LEFT JOIN {$wpdb->postmeta} hide_meta ON hide_meta.post_id = {$wpdb->posts}.ID AND hide_meta.meta_key = 'wpc_hide_archive'";

	// We don't want posts who are set to be hid.
	$pieces['where'] .= " AND hide_meta.meta_value IS NULL OR hide_meta.meta_value != '1'";

	return $pieces;
}
add_filter( 'posts_clauses', 'wpcampus_hide_from_archive', 100, 2 );

/**
 * Add article thumbnail before excerpt.
 */
function wpcampus_add_excerpt_thumbnail() {

	// Get the featured image.
	$post_thumbnail_id = get_post_thumbnail_id( get_the_ID() );

	$featured_image_src = '';
	$image_alt = '';

	if ( $post_thumbnail_id > 0 ) {

		$featured_image = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );

		if ( ! empty( $featured_image[0] ) ) {
			$featured_image_src = $featured_image[0];
			$image_alt = get_post_meta( $post_thumbnail_id, '_wp_attachment_image_alt', true );
		}
	}

	// Set default thumbnail.
	if ( empty( $featured_image_src ) ) {
		$featured_image_src = 'https://wpcampus.org/wp-content/uploads/WPCampus-graphic-header-e1557180472741-300x300.png';
	}

	do_action( 'wpcampus_before_article_thumbnail' );

	?>
	<img role="presentation" class="article-thumbnail" src="<?php echo esc_attr( $featured_image_src ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>"/>
	<?php

	do_action( 'wpcampus_after_article_thumbnail' );

}
add_action( 'wpcampus_before_article_excerpt', 'wpcampus_add_excerpt_thumbnail' );

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
	} elseif ( is_singular( 'resource' ) && 'Resources' == $item->title ) {
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

	} elseif ( is_post_type_archive( 'opportunity' ) ) {
		return __( 'Volunteer Opportunities', 'wpcampus' );
	} elseif ( is_post_type_archive( 'notification' ) || is_singular( 'notification' ) ) {
		return __( 'Announcements', 'wpcampus' );
	} elseif ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
		return __( 'Events', 'wpcampus' );
	} elseif ( is_post_type_archive( 'podcast' ) ) {
		return sprintf( __( 'The %s Podcast', 'wpcampus' ), 'WPCampus' );
	} elseif ( is_post_type_archive( 'product' ) || is_singular( 'product' ) ) {
		return sprintf( __( 'The %s Shop', 'wpcampus' ), 'WPCampus' );
	} elseif ( is_post_type_archive( 'resource' ) ) {
		return __( 'Resources', 'wpcampus' );
	} elseif ( is_singular( 'podcast' ) ) {
		return '<span class="fade type">' . __( 'Podcast:', 'wpcampus' ) . '</span> ' . $page_title;
	} elseif ( is_singular( 'resource' ) ) {
		return '<span class="fade type">' . __( 'Resource:', 'wpcampus' ) . '</span> ' . $page_title;
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
function wpcampus_adjust_queries( &$query ) {

	// Don't run in the admin.
	if ( is_admin() ) {
		return;
	}

	// Only for the main query.
	if ( ! $query->is_main_query() ) {
		return;
	}

	$all_post_types = array( 'podcast', 'post', 'resource' );

	/*
	 * For now, get all posts and podcasts posts.
	 *
	 * @TODO add pagination.
	 */
	if ( is_post_type_archive( $all_post_types ) ) {
		if ( $query->is_main_query() ) {
			$query->set( 'nopaging', true );
		}
	}

	// Make sure these pages get all post types.
	if ( is_search() || is_author() || is_category() || is_tag() ) {
		$query->set( 'nopaging', true );
		$query->set( 'post_type', $all_post_types );
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
 * Filter the WordPress SEO OpenGraph image.
 */
function wpcampus_filter_wpseo_opengraph_image( $image ) {

	// For shop pages, use the shop promo.
	if ( is_post_type_archive( 'product' ) || is_singular( 'product' ) ) {
		return get_bloginfo( 'url' ) . '/wp-content/uploads/shop-fb-promo.png';
	}

	return $image;
}
add_filter( 'wpseo_opengraph_image', 'wpcampus_filter_wpseo_opengraph_image' );

/**
 * Filter the breadcrumbs.
 *
 * @param $crumbs
 *
 * @return mixed
 */
function wpcampus_filter_breadcrumbs( $crumbs ) {

	/*
	 * Prefix breadcrumbs with "Get Involved".
	 */
	if ( is_post_type_archive( 'opportunity' ) || is_singular( 'opportunity' ) ) {

		$new_crumbs = [];

		foreach ( $crumbs as $crumb ) {

			if ( 'Opportunities' == $crumb['label'] ) {
				$new_crumbs[] = [
					'url' => '/get-involved/',
					'label' => __( 'Get Involved', 'wpcampus' ),
				];
			}

			$new_crumbs[] = $crumb;
		}

		return $new_crumbs;
	}

	return $crumbs;
}
add_filter( 'wpcampus_breadcrumbs', 'wpcampus_filter_breadcrumbs' );
