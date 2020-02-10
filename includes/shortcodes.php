<?php

// We have to remove the default shortcode filter.
remove_filter( 'the_content', 'do_shortcode', 11 ); // AFTER wpautop()

/**
 * Strips extra space around and within shortcodes.
 */
function wpcampus_strip_shortcode_space( $content ) {

	// Clean it.
	$content = strtr( $content, array(
		"\n["       => '[',
		"]\n"       => ']',
		'<p>['      => '[',
		']</p>'     => ']',
		']<br>'     => ']',
		']<br />'   => ']',
	));

	// Return the content.
	return do_shortcode( $content );
}
add_filter( 'the_content', 'wpcampus_strip_shortcode_space', 11 );

/**
 * Include columns in content.
 */
function wpcampus_process_columns_shortcode( $args, $content = null ) {

	// Make sure there's content to wrap.
	if ( ! $content ) {
		return null;
	}

	// Process for more levels of shortcode, wrap in row and return.
	return '<div class="row">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'columns', 'wpcampus_process_columns_shortcode' );

/**
 * Include columns in content.
 */
function wpcampus_process_col_shortcode( $args, $content = null ) {

	// Make sure there's content to wrap.
	if ( ! $content ) {
		return null;
	}

	// Process args.
	$defaults = array(
		'small'     => '12',
		'medium'    => false,
		'large'     => false,
	);
	$args = wp_parse_args( $args, $defaults );

	// Setup column classes.
	$column_classes = array();

	foreach ( array( 'small', 'medium', 'large' ) as $size ) {

		// If a value was passed, make sure its a number.
		if ( ! empty( $args[ $size ] ) && ! is_numeric( $args[ $size ] ) && ! is_int( $args[ $size ] ) ) {
			continue;
		}

		// Add the class.
		$column_classes[] = "{$size}-" . $args[ $size ];

	}

	return '<div class="' . implode( ' ', $column_classes ) . ' columns">' . do_shortcode( $content ) . '</div>';
}
add_shortcode( 'col', 'wpcampus_process_col_shortcode' );

/**
 * Return WPCampus data via the
 * [wpcampus_data] shortcode.
 */
function wpcampus_process_data_shortcode( $args, $content = null ) {

	// Process args.
	$defaults = array(
		'set'       => null,
		'format'    => 'number', // Other options: percent, both
	);
	$args = wp_parse_args( $args, $defaults );

	// Build the content.
	$content = null;

	switch ( $args['set'] ) {

		case 'no_of_interested':
			return wpcampus_get_interested_count();
			break;

		case 'attend_in_person':
			return format_wpcampus_data_set( wpcampus_get_attend_in_person_count(), $args['format'] );
			break;

		case 'attend_has_location':
			return format_wpcampus_data_set( wpcampus_get_interested_has_location_count(), $args['format'] );
			break;

		case 'attend_live_stream':
			return format_wpcampus_data_set( wpcampus_get_attend_live_stream_count(), $args['format'] );
			break;

		case 'work_in_higher_ed':
			return format_wpcampus_data_set( wpcampus_get_work_in_higher_ed_count(), $args['format'] );
			break;

		case 'work_for_company':
			return format_wpcampus_data_set( wpcampus_get_work_for_company_count(), $args['format'] );
			break;

		case 'work_outside_higher_ed':
			return format_wpcampus_data_set( wpcampus_get_work_outside_higher_ed_count(), $args['format'] );
			break;

		case 'group_attending':
		case 'group_hosting':
		case 'group_planning':
		case 'group_speaking':
		case 'group_sponsoring':
			return format_wpcampus_data_set( wpcampus_get_group_count( preg_replace( '/^group\_/i', '', $args['set'] ) ), $args['format'] );
			break;

		case 'no_of_votes_on_new_name':
			return format_wpcampus_data_set( wpcampus_get_vote_on_new_name_count() );
			break;

	}

	return $content;
}
add_shortcode( 'wpcampus_data', 'wpcampus_process_data_shortcode' );

function format_wpcampus_data_set( $count, $format = 'number' ) {

	switch ( $format ) {

		case 'number':
		case 'both':
			$number = $count;

			if ( 'number' == $format ) {
				return $number;
			}

		case 'percent':
		case 'both':

			// Get total.
			$total = wpcampus_get_interested_count();

			// Add percentage.
			$percent = round( ( $count / $total ) * 100 ) . '%';

			if ( 'percent' == $format ) {
				return $percent;
			}

			return "{$number} ({$percent})";

		default:
			return $count;
	}
}

function wpcampus_shortcode_wpcampus_print_contributor( $args ) {
	$args = shortcode_atts(
		[
			'id'           => 0,
			'current_user' => false,
		],
		$args,
		'wpc_print_contributor'
	);

	if ( ! empty( $args['current_user'] ) ) {
		$args['id'] = get_current_user_id();
	}

	return wpcampus_print_contributor( $args['id'], false );
}

add_shortcode( 'wpc_print_contributor', 'wpcampus_shortcode_wpcampus_print_contributor' );
