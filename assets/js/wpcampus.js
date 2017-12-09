(function($) {
	'use strict';

	$(document).ready(function() {

		// Changes .svg to .png if doesn't support SVG.
		if ( ! Modernizr.svg ) {
			$( 'img[src*="svg"]' ).attr( 'src', function() {
				return $( this ).attr( 'src' ).replace( '.svg', '.png' );
			});
		}
	});
})(jQuery);