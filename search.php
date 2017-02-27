<?php

get_header();

// Get the search query.
$search_query = get_search_query();

if ( ! have_posts() ) :

	?>
	<p class="wpc-search-result-message no-results"><?php printf( __( 'No search results were found for %s.', 'wpcampus' ), '<span class="search-term">' . $search_query . '</span>' ); ?></p>
	<?php

else :

	?>
	<p class="wpc-search-result-message"><?php printf( __( 'Search results for %s:', 'wpcampus' ), '<span class="search-term">' . $search_query . '</span>' ); ?></p>
	<div class="wpc-articles wpc-search-results">
		<?php

		while ( have_posts() ) :
			the_post();

			// Get post information.
			$post_id = get_the_ID();
			$post_permalink = get_permalink( $post_id );

			?>
			<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
				<h2><a href="<?php echo $post_permalink; ?>"><?php the_title(); ?></a></h2>
				<?php

				the_excerpt();

				?>
			</article>
			<?php

		endwhile;

		?>
	</div>
	<?php

endif;

get_footer();
