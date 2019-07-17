<?php

get_header();

wpcampus_print_main_callout();

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
	'post_type'        => array( 'post', 'podcast', 'resource', 'video', 'opportunity' ), // @TODO add notification
	'posts_per_page'   => 5, // @TODO add pagination
	'wpc_hide_archive' => true,
));
if ( $query_posts->have_posts() ) :

	// Add article meta after header.
	add_action( 'wpcampus_after_article_header', 'wpcampus_print_article_meta', 5 );

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

		wpcampus_print_articles( $args, false, $query_posts );

		?>
		<ul class="button-group">
			<li><a href="/announcements/" class="button"><?php _e( 'Announcements', 'wpcampus' ); ?></a></li>
			<li><a href="/blog/" class="button"><?php _e( 'Blog', 'wpcampus' ); ?></a></li>
			<li><a href="/podcast/" class="button"><?php _e( 'Podcast', 'wpcampus' ); ?></a></li>
			<li><a href="/resources/" class="button"><?php _e( 'Resources', 'wpcampus' ); ?></a></li>
			<li><a href="/videos/" class="button"><?php _e( 'Videos', 'wpcampus' ); ?></a></li>
		</ul>
	</div>
	<?php

	remove_filter( 'the_title', 'wpcampus_prepend_post_title', 100, 2 );

	// Reset the main query post data.
	wp_reset_postdata();

endif;

get_footer();
