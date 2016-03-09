<?php

// Adds our admin meta boxes.
add_action( 'add_meta_boxes', 'wpcampus_add_meta_boxes', 1, 2 );
function wpcampus_add_meta_boxes( $post_type, $post ) {

	// Add a meta box to link to the podcast guide
	add_meta_box(
		'wpcampus-podcast-guide',
		'WPCampus Podcast Guide',
		'wpcampus_print_meta_boxes',
		'podcast',
		'side',
		'high'
	);

}

// Print our meta boxes
function wpcampus_print_meta_boxes( $post, $metabox ) {
	switch( $metabox[ 'id' ] ) {

		case 'wpcampus-podcast-guide':
			?><div style="background:rgba(0,115,170,0.07);padding:18px;color:#000;margin:-6px -12px -12px -12px;">Be sure to read our <a href="https://docs.google.com/document/d/1GG8-qb4OQ3TzDyB1UI00GvRw-agyIO1AT8WUPuyDgHg/edit#heading=h.8dr748uym2qn" target="_blank">WPCampus Podcast Guide</a> to help walk you through the process and ensure proper setup.</div><?php
			break;

	}
}

