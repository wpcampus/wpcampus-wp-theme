<?php

// Add promo block.
add_action( 'wpcampus_after_article', 'wpcampus_print_podcast_promo', 10 );

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
