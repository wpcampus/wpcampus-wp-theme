<?php

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		// Get post information.
		$post_id = get_the_ID();

		?>
		<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
			<h2><?php the_title(); ?></h2>
			<?php

			the_content();

			?>
		</article>
		<?php

	endwhile;
endif;

get_footer();
