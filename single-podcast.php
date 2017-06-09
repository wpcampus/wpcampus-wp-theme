<?php

// Add promo block.
add_action( 'wpcampus_after_article', 'wpcampus_print_podcast_promo', 10 );

/**
 * Add contributor info after articles.
 */
function wpcampus_blog_add_contributor() {
	wpcampus_print_contributor();
}
add_action( 'wpcampus_after_article', 'wpcampus_blog_add_contributor', 15 );

get_header();

if ( ! have_posts() ) :
	wpcampus_print_404();
else :
	while ( have_posts() ) :
		the_post();

		wpcampus_print_article();

		comments_template();

	endwhile;
endif;

get_footer();
