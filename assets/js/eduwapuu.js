(function( $ ) {
	'use strict';

	// Set some objects.
	var $eduwapuu = $( '.eduwapuu-wrapper.animate .eduwapuu' );
	var $eduwapuu_left_eye = $eduwapuu.find( '.left-eye' );
	var $eduwapuu_right_eye = $eduwapuu.find( '.right-eye' );
	var $eduwapuu_mouth = $eduwapuu.find( '.mouth' );
	var $eduwapuu_mouth_dropped = $eduwapuu.find( '.mouth-dropped' );

	// Set some object information.
	var left_eye_radius_x = parseInt( $eduwapuu_left_eye.attr( 'rx' ) );
	var left_eye_radius_y = parseInt( $eduwapuu_left_eye.attr( 'ry' ) );
	var right_eye_radius_x = parseInt( $eduwapuu_right_eye.attr( 'rx' ) );
	var right_eye_radius_y = parseInt( $eduwapuu_right_eye.attr( 'ry' ) );

	// Set the positions.
	var left_eye_left_x = 113;
	var left_eye_left_y = 64;
	var right_eye_left_x = 78;
	var right_eye_left_y = 72;

	var left_eye_right_x = 107;
	var left_eye_right_y = 67;
	var right_eye_right_x = 73;
	var right_eye_right_y = 75;

	// Set the speeds.
	var left_eye_duration = 2600;
	var right_eye_duration = 2900;

	// Count how many times it reads and where it's reading.
	var read_direction = 'right';
	var read_right = 0;
	var read_left = 0;

	// Is its mouth dropped?
	var mouth_dropped = false;
	var mouth_drop_duration = 1500;
	var mouth_close_duration = 500;
	var mouth_dropped_orig_height = parseInt( $eduwapuu_mouth_dropped.attr( 'ry' ) );
	var mouth_dropped_open_y = parseInt( $eduwapuu_mouth_dropped.attr( 'cy' ) );
	var mouth_dropped_close_y = 80.367;
	var mouth_dropped_close_ry = 0.1;

	// Is it smiling?
	var mouth_smiling = false;

	// Build the coordinates for the smile.
	var mouth_smile = [];
	mouth_smile.push( $eduwapuu_mouth.attr( 'd' ) );

	// The final smile position.
	mouth_smile.push( 'M115,75.2c0,0-10.4,11.4-24,4.4c0,0-10.8,8.8-19,1.6' );

	// Start by reading to the right.
	setTimeout( eduwapuu_read_right, 3000 );

	// Will determine where the eyes are and continue reading.
	function eduwapuu_continue_reading() {
		if ( 'left' == read_direction ) {
			eduwapuu_read_right();
		} else {
			eduwapuu_read_left()
		}
	}

	// Move its eyes to the right.
	function eduwapuu_read_right() {

		read_direction = 'right';

		$eduwapuu_left_eye.animate({
			cx: left_eye_right_x,
			cy: left_eye_right_y
		}, {
			duration: left_eye_duration,
			queue: false,
			complete: function() {}
		});

		$eduwapuu_right_eye.animate({
			cx: right_eye_right_x,
			cy: right_eye_right_y
		}, {
			duration: right_eye_duration,
			queue: false,
			complete: function() {

				read_right++;

				setTimeout( eduwapuu_read_left, 3000 );

			}
		});

	}

	// Move its eyes to the left.
	function eduwapuu_read_left() {

		read_direction = 'left';

		$eduwapuu_left_eye.animate({
			cx: left_eye_left_x,
			cy: left_eye_left_y
		}, {
			duration: left_eye_duration - 150,
			queue: false,
			complete: function() {}
		});

		$eduwapuu_right_eye.animate({
			cx: right_eye_left_x,
			cy: right_eye_left_y
		}, {
			duration: right_eye_duration,
			queue: false,
			complete: function() {

				read_left++;

				if ( 0 !== ( read_left % 2 ) ) {
					eduwapuu_mouth_drop();
				} else {
					setTimeout( eduwapuu_read_right, 3000 );
				}

			}
		});
	}

	// Make the eduwapuu smile.
	function eduwapuu_smile() {
		if ( mouth_smiling ) {
			return;
		}

		mouth_smiling = true;

		$eduwapuu_mouth.attr( 'd', mouth_smile[ mouth_smile.length - 1 ] );

		setTimeout( eduwapuu_unsmile, 3000 );

		// Set the height of the mouth really low and show the mouth.
		//$eduwapuu_mouth_dropped.attr( 'ry', mouth_dropped_close_ry ).attr( 'cy', mouth_dropped_close_y ).show();

		/*$eduwapuu_mouth.animate({
			rx: left_eye_radius_x + 1
		}, {
			duration: 3000,
			queue: false,
			complete: function() {},
			step: function( now, fx ) {

				//var data = fx.elem.id + " " + fx.prop + ": " + now;
				//$( "body" ).append( "<div>" + data + "</div>" );

			}
		});*/

	}

	// Make the eduwapuu unsmile.
	function eduwapuu_unsmile() {
		if ( ! mouth_smiling ) {
			return;
		}

		mouth_smiling = false;

		// Reset the smile.
		$eduwapuu_mouth.attr( 'd', mouth_smile[0] );

		setTimeout( eduwapuu_continue_reading, 3000 );

	}

	// Drop the eduwapuu's mouth.
	function eduwapuu_mouth_drop() {
		if ( mouth_dropped ) {
			return;
		}

		// Set the height of the mouth really low and show the mouth.
		$eduwapuu_mouth_dropped.attr( 'ry', mouth_dropped_close_ry ).attr( 'cy', mouth_dropped_close_y ).show();

		$eduwapuu_left_eye.animate({
			rx: left_eye_radius_x + 1,
			ry: left_eye_radius_y + 1
		}, {
			duration: mouth_drop_duration,
			queue: false,
			complete: function() {}
		});

		$eduwapuu_right_eye.animate({
			rx: right_eye_radius_x + 1,
			ry: right_eye_radius_y + 1
		}, {
			duration: mouth_drop_duration,
			queue: false,
			complete: function() {}
		});

		$eduwapuu_mouth_dropped.animate({
			ry: mouth_dropped_orig_height,
			cy: mouth_dropped_open_y
		}, {
			duration: mouth_drop_duration,
			queue: false,
			complete: function() {

				// Mouth is dropped.
				mouth_dropped = true;

				// Close the mouth in 3 seconds.
				setTimeout( eduwapuu_mouth_close, 3000 );

			}
		});

	}

	// Close the eduwapuu's mouth.
	function eduwapuu_mouth_close() {
		if ( ! mouth_dropped ) {
			return;
		}

		$eduwapuu_left_eye.animate({
			rx: left_eye_radius_x,
			ry: left_eye_radius_y
		}, {
			duration: mouth_close_duration,
			queue: false,
			complete: function() {}
		});

		$eduwapuu_right_eye.animate({
			rx: right_eye_radius_x,
			ry: right_eye_radius_y
		}, {
			duration: mouth_close_duration,
			queue: false,
			complete: function() {}
		});

		$eduwapuu_mouth_dropped.animate({
			ry: mouth_dropped_close_ry,
			cy: mouth_dropped_close_y
		}, {
			duration: mouth_close_duration,
			queue: false,
			complete: function() {

				// Hide the mouth.
				$eduwapuu_mouth_dropped.hide();

				// Mouth is no longer dropped.
				mouth_dropped = false;

				// Make it smile.
				eduwapuu_smile();

			}
		});

	}

})( jQuery );