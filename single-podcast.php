<?php

get_header();

if ( ! have_posts() ) :

	?><p>Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.</p>
	<p>If you can't find what you're looking for in the menu, please <a href="<?php echo get_bloginfo( 'url' ); ?>/contact/">reach out to us</a> and let us know. We'd be happy to help.</p><?php

else :
	while ( have_posts() ) :
		the_post();

		?>
		<div class="wpcampus-podcast-single">
			<?php

			// Print the date.
			if ( $date = get_the_date( 'l, F j, Y', get_the_ID() ) ) {

				?>
				<p class="podcast-meta">Recorded <?php echo $date; ?></p>
				<?php

			}

			the_content();

			?>
		</div>
		<?php

	endwhile;
endif;

?>
<div class="panel dark-blue center" style="margin-bottom:20px;"><?php printf( __( 'New episodes of %1$sThe %2$s Podcast%3$s are released every month.', 'wpcampus' ), '<a href="' . get_bloginfo( 'url' ) . '/podcast/">', 'WPCampus', '</a>' ); ?></div>

<div style="text-align: center">
	<ul class="button-group">
		<li><a href="https://itun.es/i6YF9HH" class="button"><?php printf( __( 'Listen on %s', 'wpcampus' ), 'iTunes' ); ?></a></li>
		<li><a href="<?php echo get_bloginfo( 'url' ); ?>/feed/podcast" class="button"><?php printf( __( 'View the %s feed', 'wpcampus' ), 'RSS' ); ?></a></li>
	</ul>
</div>
<?php

get_footer();
