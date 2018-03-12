<?php

/**
 * Template Name: WPCampus: Sessions
 */

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		wpcampus_print_article();

	endwhile;
endif;

?>
<div id="wpcampus-sessions" class="loading">
	<p class="loading-msg"><?php _e( '- Loading sessions -', 'wpcampus' ); ?></p>
</div>
<?php

get_footer();
