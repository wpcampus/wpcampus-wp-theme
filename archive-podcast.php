<?php

get_header();

?><p>The WPCampus Podcast is a weekly show where members of the community come together to discuss relevant topics, unique ways that WordPress is being used in higher education, share tutorials and walkthroughs, and more.</p>

<div class="panel royal-blue center" style=margin-bottom:30px;">Our podcast is broadcasted live every Wednesday at 12 p.m. EST.</div><?php

if ( ! have_posts() ) {

	?><p>Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.</p>
	<p>If you can't find what you're looking for in the menu, please <a href="<?php echo get_bloginfo('url'); ?>/contact/">reach out to us</a> and let us know. We'd be happy to help.</p><?php

} else {
    while ( have_posts() ) {
        the_post();

	    ?><hr />
	    <h2><?php the_title(); ?></h2><?php
        the_content();

    }
}

get_footer();