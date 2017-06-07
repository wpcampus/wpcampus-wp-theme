<?php

get_header();

if ( ! have_posts() ) :

	?>
	<p>Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.</p>
	<p>If you can't find what you're looking for in the menu, please <a href="/contact/">reach out to us</a> and let us know. We'd be happy to help.</p>
	<?php

else :
	while ( have_posts() ) :
		the_post();

		the_content();

	endwhile;
endif;

get_footer();
