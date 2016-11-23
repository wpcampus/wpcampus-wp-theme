<?php

get_header();

if ( ! have_posts() ) {

	?>
	<p><?php _e( 'Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.', 'wpcampus' ); ?></p>
	<p><?php printf( __( 'If you can\'t find what you\'re looking for in the menu, please %1$sreach out%2$s and let us know. We\'d be happy to help.', 'wpcampus' ), '<a href="' . get_bloginfo( 'url' ) . '/contact/">', '</a>' ); ?></p><?php

} else {
	while ( have_posts() ) {
		the_post();

		the_content();

	}
}

get_footer();
