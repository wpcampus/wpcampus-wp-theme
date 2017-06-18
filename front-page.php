<?php

get_header();

if ( ! have_posts() ) :
	wpcampus_print_404();
else :
	while ( have_posts() ) :
		the_post();

		wpcampus_print_article();

	endwhile;
endif;

// Display blog posts.
$query_posts = new WP_Query( array(
	'post_type'         => array( 'post', 'podcast', 'video' ),
	'posts_per_page'    => 5, // @TODO add pagination
));
if ( $query_posts->have_posts() ) :

	// Add article meta after header.
	add_action( 'wpcampus_after_article_header', 'wpcampus_print_article_meta', 5 );

	// Remove the callout from displaying before each article in the list.
	remove_action( 'wpcampus_before_article', 'wpcampus_print_ed_survey_callout' );

	// Setup article arguments.
	$args = array(
		'header'        => 'h3',
		'print_content' => false,
	);

	add_filter( 'the_title', 'wpcampus_prepend_post_title', 100, 2 );

	?>
	<div class="wpcampus-front-page-articles">
		<h2><?php printf( __( 'From The %s Community', 'wpcampus' ), 'WPCampus' ); ?></h2>
		<?php

		// Print the articles.
		wpcampus_print_articles( $args, $query_posts );

		?>
		<ul class="button-group">
			<li><a href="/blog/" class="button"><?php _e( 'Read more on our blog', 'wpcampus' ); ?></a></li>
			<li><a href="/videos/" class="button"><?php _e( 'Watch our videos', 'wpcampus' ); ?></a></li>
			<li><a href="/podcast/" class="button"><?php _e( 'Listen to the podcast', 'wpcampus' ); ?></a></li>
		</ul>
	</div>
	<?php

	remove_filter( 'the_title', 'wpcampus_prepend_post_title', 100, 2 );

	// Reset the main query post data.
	wp_reset_postdata();

endif;

get_footer();
