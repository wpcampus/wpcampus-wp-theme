<?php

// Get some site information.
$blog_url = get_bloginfo( 'url' );

?>
					</div><!-- .wpc-content -->
					<?php get_sidebar(); ?>
				</div><!-- .inside -->
			</div><!-- #wpc-main -->
			<?php

			get_template_part( 'partials/get-involved' );

			?>
			<div id="wpc-footer">
				<div class="inside">
					<a class="wpc-logo" href="<?php echo $blog_url; ?>"><span class="for-screen-reader"><?php printf( __( '%1$s: Where %2$s Meets Higher Education', 'wpcampus' ), 'WPCampus', 'WordPress' ); ?></span></a>
					<?php

					// Print the footer menu.
					wp_nav_menu( array(
						'theme_location'    => 'footer',
						'container'         => 'div',
						'container_class'   => 'wpc-footer-menu-wrapper',
						'menu_id'           => 'wpc-footer-menu',
						'menu_class'        => 'wpc-footer-menu',
						'fallback_cb'       => false,
					) );

					?>
					<p><strong>WPCampus is a community of networking, resources, and events for those using WordPress in the world of higher education.</strong><br />
					If you are not a member of the WPCampus community, we'd love for you to <a href="<?php echo $blog_url; ?>/get-involved/">get involved</a>.<br />
					<em>This site is powered by <a href="https://wordpress.org/">WordPress</a>. You can view, and contribute to, the theme on <a href="https://github.com/wpcampus/wpcampus-wp-theme">GitHub</a>.</em></p>
					<p class="copyright">&copy; <?php echo date( 'Y' ); ?> WPCampus</p>
				</div><!-- .inside -->
			</div><!-- #wpc-footer -->
		</div> <!-- #wpc-wrapper -->
		<?php wp_footer(); ?>
	</body>
</html>
