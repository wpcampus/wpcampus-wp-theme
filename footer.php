<?php do_action( 'wpc_add_after_content' ); ?>

				</div> <!-- .columns -->
			</div> <!-- .row -->
		</div><!--#wpcampus-content-->
	</main> <!-- #wpcampus-main -->
	<?php

	if ( function_exists( 'wpcampus_print_mailchimp_signup' ) ) {

		// Not for the resources speaker training page.
		if ( ! is_single( 30097 ) ) {
			wpcampus_print_mailchimp_signup();
		}
	}

	if ( function_exists( 'wpcampus_print_network_coc' ) ) {
		wpcampus_print_network_coc();
	}

	// Print network footer.
	if ( function_exists( 'wpcampus_print_network_footer' ) ) {
		wpcampus_print_network_footer();
	}

	wp_footer();

	?>
	</body>
</html>
