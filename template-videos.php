<?php

/**
 * Template Name: WPCampus: Videos
 */

function wpc_theme_enable_watch_videos() {
	if ( function_exists( 'wpcampus_network_enable' ) ) {
		wpcampus_network_enable( 'videos' );
	}
}
add_action( 'get_header', 'wpc_theme_enable_watch_videos' );

// Will hold the filters.
$filters = array();

// Is there a selected playlist?
$filters['playlist'] = ! empty( $_GET['playlist'] ) ? sanitize_text_field( $_GET['playlist'] ) : get_query_var( 'videos_playlist' );

// Is there a selected category?
$filters['category'] = ! empty( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : get_query_var( 'videos_category' );

// Is there a selected author?
$filters['author'] = ! empty( $_GET['author'] ) ? sanitize_text_field( $_GET['author'] ) : get_query_var( 'videos_author' );

// Are we searching?
$filters['search'] = ! empty( $_GET['search'] ) ? sanitize_text_field( $_GET['search'] ) : get_query_var( 'videos_search' );

// Remove empty filters.
$filters = array_filter( $filters );

// Show the filters.
$filters['show_filters'] = true;

get_header();

if ( ! have_posts() ) :
	wpcampus_print_404();
else :
	while ( have_posts() ) :
		the_post();

		wpcampus_print_article();

		if ( function_exists( 'wpcampus_print_watch_videos' ) ) {
			wpcampus_print_watch_videos( 'wpc-videos', $filters );
		}

	endwhile;
endif;

get_footer();
