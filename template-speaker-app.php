<?php

/**
 * Template Name: WPCampus: Speaker App
 */

/**
 * Load speaker app specific assets.
 */
function wpcampus_speaker_app_assets() {

	// Load the counter part to the iframe resizer.
	wp_enqueue_script( 'wpc-iframe-resizer', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/iframeResizer.contentWindow.min.js', array(), null );

	// Is registered in speakers plugin.
	wp_enqueue_script( 'wpc-speaker-app' );

}

add_action( 'wp_enqueue_scripts', 'wpcampus_speaker_app_assets', 20 );

get_template_part( 'template-content-only' );
