<?php

get_header();

add_action( 'wpcampus_before_articles', function() {
	?>
	<p>The following are opportunities to get involved with our community. If you have any questions, please do not hesitate to use <a href="/contact/">our contact form</a>.</p>
	<?php
});

if ( ! have_posts() ) :
	?>
	<p><?php _e( 'There are no specific volunteer opportunities at this time.', 'wpcampus' ); ?> If you have any questions, please do not hesitate to use <a href="/contact/">our contact form</a>.</p>
	<?php
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
