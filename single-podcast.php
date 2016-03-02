<?php

get_header();

if ( ! have_posts() ) {

	?><p>Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.</p>
	<p>If you can't find what you're looking for in the menu, please <a href="<?php echo get_bloginfo('url'); ?>/contact/">reach out to us</a> and let us know. We'd be happy to help.</p><?php

} else {
    while ( have_posts() ) {
        the_post();

	    ?><div class="wpcampus-podcast-single"><?php

		    // Print the date
		    if ( $date = get_the_date( 'l, F j, Y', get_the_ID() ) ) {
			    ?><p class="podcast-meta">Recorded <?php echo $date; ?></p><?php
		    }

		    the_content();

	    ?></div><?php

    }
}

?><div class="panel dark-blue center" style=margin-bottom:20px;"><a href="<?php echo get_bloginfo('url'); ?>/podcast/">The WPCampus Podcast</a> is broadcasted live every Wednesday at 12 p.m. EST.</div>

<div style="text-align: center">
	<ul class="button-group">
		<li><a href="https://itun.es/i6YF9HH" class="button">Listen on iTunes</a></li>
		<li><a href="<?php echo get_bloginfo('url'); ?>/feed/podcast" class="button">View the RSS feed</a></li>
	</ul>
</div><?php

get_footer();