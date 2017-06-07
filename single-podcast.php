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

	    ?>
	    <div class="wpcampus-podcast-single">
	        <?php

		    // Print the date.
		    if ( $date = get_the_date( 'l, F j, Y', get_the_ID() ) ) :
			    ?>
			    <p class="podcast-meta">Recorded <?php echo $date; ?></p>
			    <?php
		    endif;

		    the_content();

	        ?>
	    </div>
	    <?php
	endwhile;
endif;

?>
<div class="panel dark-blue center" style="margin-bottom:20px;">New episodes of <a href="/podcast/">The WPCampus Podcast</a> are released every month.</div>
<div style="text-align: center">
	<ul class="button-group">
		<li><a href="https://itun.es/i6YF9HH" class="button">Listen on iTunes</a></li>
		<li><a href="https://play.google.com/music/listen?u=0#/ps/Imipnlywvba5v3lqu7y646dg6z4" class="button">Listen on Google Play</a></li>
		<li><a href="/feed/podcast" class="button">View RSS feed</a></li>
	</ul>
</div>
<?php

get_footer();
