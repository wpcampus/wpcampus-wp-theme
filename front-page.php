<?php

get_header();

// Print front page content.
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		the_content();

	endwhile;
endif;

// Get blog posts.
$blogs = new WP_Query( array(
	'post_type'         => 'post',
	'page'              => 1,
	'posts_per_page'    => 5,
));

// Print blog posts.
if ( $blogs->have_posts() ) :

	?>
	<h2><?php _e( 'From the Blog' ,'wpcampus' ); ?></h2>
	<div class="wpc-articles">
		<?php

		while ( $blogs->have_posts() ) :
			$blogs->the_post();

			// Get post information.
			$post_id = get_the_ID();
			$post_permalink = get_permalink( $post_id );

			?>
			<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
				<h3><a href="<?php echo $post_permalink; ?>"><?php the_title(); ?></a></h3>
				<?php

				the_excerpt();

				?>
			</article>
			<?php

		endwhile;

		// Restore original post data.
		wp_reset_postdata();

		?>
	</div>
	<?php

endif;

get_footer();
