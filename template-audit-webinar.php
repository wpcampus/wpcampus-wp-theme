<?php

/**
 * Template Name: WPCampus: Audit webinar
 */

/**
 * Load speaker app specific assets.
 */
function wpcampus_audit_webinar_assets() {
	wp_enqueue_script( 'wpc-parent-iframe' );
}
//add_action( 'wp_enqueue_scripts', 'wpcampus_audit_webinar_assets', 20 );

/**
 * Filter the content.
 */
function wpcampus_audit_webinar_content( $content ) {

	$iframe_url = 'https://zoom.us/webinar/register/WN_pF_MmSw8RPKnph38pLiyaQ'; //get_option( 'wpc_speaker_app_url' );
	if ( empty( $iframe_url ) ) {
		return;
	}

	$iframe_title = 'Gutenberg Accessibility Audit Q&A registration form'; //get_option( 'wpc_speaker_app_title' );

	ob_start();

	echo $content;

	// sandbox="allow-top-navigation allow-scripts allow-forms allow-same-origin"
	?>
	<iframe title="<?php echo esc_attr( $iframe_title ); ?>" id="wpcampus-speaker-app" class="wpc-iframe-resize" src="<?php echo $iframe_url; ?>" scrolling="yes"></iframe>
	<?php

	return ob_get_clean();
}
//add_filter( 'the_content', 'wpcampus_audit_webinar_content' );

get_template_part( 'index' );
