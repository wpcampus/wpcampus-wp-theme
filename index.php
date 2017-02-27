<?php

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		// Print title on certain pages.
		if ( is_single() ) :

			?>
			<h1><?php the_title(); ?></h1>
			<?php

		endif;

		the_content();

	endwhile;
endif;

get_footer();
