<?php

get_header();

?>
<p>The WPCampus Podcast is a monthly show where members of the community come together to discuss relevant topics, unique ways that WordPress is being used in higher education, share tutorials and walkthroughs, and more.</p>

<div class="panel dark-blue center" style="margin-bottom:20px;">New episodes of The WPCampus Podcast are released every month.</div>

<div style="text-align: center">
	<ul class="button-group">
		<li><a href="https://itun.es/i6YF9HH" class="button"><?php printf( __( 'Listen on %s', 'wpcampus' ), 'iTunes' ); ?></a></li>
		<li><a href="<?php echo get_bloginfo( 'url' ); ?>/feed/podcast" class="button"><?php printf( __( 'View the %s feed', 'wpcampus' ), 'RSS' ); ?></a></li>
	</ul>
</div>
<?php

if ( have_posts() ) :

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
					<p class="podcast-meta"><?php printf( __( 'Recorded %s', 'wpcampus' ), $date ); ?></p>
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
