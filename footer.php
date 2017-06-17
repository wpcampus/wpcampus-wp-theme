<?php

$stylesheet_dir = get_stylesheet_directory_uri();
$images_dir = "{$stylesheet_dir}/assets/images/";

			?>
			</div> <!-- .columns -->
		</div> <!-- .row -->
	</div> <!-- #wpcampus-main -->
	<div id="wpcampus-footer">
		<div class="row">
			<div class="small-12 columns">
				<div class="addthis_sharing_toolbox"></div>
				<a class="wpc-logo"  href="https://wpcampus.org/"><img src="<?php echo $images_dir; ?>wpcampus-logo-tagline.svg" alt="WPCampus: Where WordPress Meets Higher Education" /></a>
				<?php

				// Print the footer menu.
				wp_nav_menu( array(
					'theme_location'    => 'footer',
					'container'         => false,
					'menu_id'           => 'wpc-footer-menu',
					'menu_class'        => 'wpc-footer-menu',
					'fallback_cb'       => false,
				));

				?>
				<p><strong>WPCampus is a community of networking, resources, and events for those using WordPress in the world of higher education.</strong><br />If you are not a member of the WPCampus community, we'd love for you to <a href="https://wpcampus.org/get-involved/">get involved</a>.</p>
				<p class="disclaimer">This site is powered by <a href="https://wordpress.org/">WordPress</a>. You can view, and contribute to, the theme on <a href="https://github.com/wpcampus/wpcampus-wp-theme">GitHub</a>.<br />WPCampus events are not WordCamps and are not affiliated with the WordPress Foundation.</p>
				<?php wpcampus_print_social_media_icons(); ?>
				<p class="copyright">&copy; <?php echo date( 'Y' ); ?> WPCampus</p>
			</div>
		</div>
	</div> <!-- #wpcampus-footer -->
	<?php wp_footer(); ?>
	</body>
</html>
