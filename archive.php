<?php

/**
 * Add contributor info before articles.
 */
function wpcampus_author_archive_add_contributor() {
	if ( is_author() ) {
		wpcampus_print_contributor();
	}
}
add_action( 'wpcampus_before_articles', 'wpcampus_author_archive_add_contributor' );

get_header();

if ( ! have_posts() ) :
	wpcampus_print_404();
else :

	// Setup article arguments.
	$args = array(
		'header'        => 'h2',
		'print_content' => false,
	);

	add_filter( 'the_title', 'wpcampus_prepend_post_title', 100, 2 );

	// Print the articles.
	wpcampus_print_articles( $args );

	remove_filter( 'the_title', 'wpcampus_prepend_post_title', 100, 2 );

endif;

get_footer();
