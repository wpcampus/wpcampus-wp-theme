<?php do_action( 'wpc_add_after_content' ); ?>

			</div> <!-- .columns -->
		</div> <!-- .row -->
	</div> <!-- #wpcampus-main -->
	<?php

	// Print network footer.
	if ( function_exists( 'wpcampus_print_network_footer' ) ) {
		wpcampus_print_network_footer();
	}

	wp_footer();

	?>
	</body>
</html>
