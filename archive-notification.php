<?php

get_header();

if ( ! have_posts() ) :
	wpcampus_print_404();
else :

	// Setup article arguments.
	$args = array(
		'header'        => 'h2',
		'print_content' => true,
	);

	add_filter( 'the_title', 'wpcampus_prepend_post_title', 100, 2 );

	// Print the articles.
	wpcampus_print_articles( $args );

	remove_filter( 'the_title', 'wpcampus_prepend_post_title', 100, 2 );

endif;

get_footer();
