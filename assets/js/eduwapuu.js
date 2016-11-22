(function( $ ) {
	'use strict';

	// Set the speeds
	var left_eye_duration = 2600;
	var right_eye_duration = 2900;

	// Start by reading to the right.
	setTimeout( eduwapuu_read_right, 3000 );

	// Move his eyes to the right.
	function eduwapuu_read_right() {

		$( '#wpc-hero .eduwapuu .left-eye' ).animate({
			cx: 107,
			cy: 67
		}, {
			duration: left_eye_duration,
			queue: false,
			complete: function() {}
		});

		$( '#wpc-hero .eduwapuu .right-eye' ).animate({
			cx: 73,
			cy: 75
		}, {
			duration: right_eye_duration,
			queue: false,
			complete: function() {
				setTimeout( eduwapuu_read_left, 3000 );
			}
		});
		
	}

	// Move his eyes to the left.
	function eduwapuu_read_left() {

		$( '#wpc-hero .eduwapuu .left-eye' ).animate({
			cx: 113,
			cy: 64
		}, {
			duration: left_eye_duration - 150,
			queue: false,
			complete: function() {}
		});

		$( '#wpc-hero .eduwapuu .right-eye' ).animate({
			cx: 78,
			cy: 72
		}, {
			duration: right_eye_duration,
			queue: false,
			complete: function() {
				setTimeout( eduwapuu_read_right, 3000 );
			}
		});
	}

})( jQuery );