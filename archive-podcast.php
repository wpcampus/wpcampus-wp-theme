<?php

get_header();

?>
<p>The WPCampus Podcast is a monthly show where members of the community come together to discuss relevant topics, unique ways that WordPress is being used in higher education, share tutorials and walkthroughs, and more.</p>
<div class="panel dark-blue center" style="margin-bottom:20px;">New episodes of The WPCampus Podcast are released every month.</div>
	<div style="text-align: center">
	<ul class="button-group">
		<li><a href="https://itun.es/i6YF9HH" class="button">Listen on iTunes</a></li>
		<li><a href="https://play.google.com/music/listen?u=0#/ps/Imipnlywvba5v3lqu7y646dg6z4" class="button">Listen on Google Play</a></li>
		<li><a href="/feed/podcast" class="button">View RSS feed</a></li>
	</ul>
</div>
<?php

if ( ! have_posts() ) :

	?>
	<p>Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.</p>
	<p>If you can't find what you're looking for in the menu, please <a href="/contact/">reach out to us</a> and let us know. We'd be happy to help.</p>
	<?php
else :

	?>
	<div class="wpcampus-podcasts">
		<?php

	    while ( have_posts() ) :
	        the_post();

		    // Get the date.
		    $date = get_the_date( 'l, F j, Y', get_the_ID() );

		    ?>
		    <hr />
			<div class="wpcampus-podcast">
		        <h2 class="podcast-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		        <?php

		        if ( $date ) :
			        ?>
			        <p class="podcast-meta">Recorded <?php echo $date; ?></p>
			        <?php
		        endif;

	            the_content();

				?>
		    </div>
		    <?php
	    endwhile;

		?>
	</div><!--.wpcampus-podcasts-->
	<?php

endif;

get_footer();
