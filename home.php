<?php

// Add article meta after header.
add_action( 'wpcampus_after_article_header', 'wpcampus_print_article_meta', 5 );

get_header();

if ( ! have_posts() ) :

	?>
	<p><em><?php _e( 'There are no posts at this time.', 'wpcampus' ); ?></em></p>
	<?php

else :

	// Setup article arguments.
	$args = array(
		'header'        => 'h2',
		'print_content' => false,
	);

	// Print the articles.
	wpcampus_print_articles( $args );

endif;

get_footer();
