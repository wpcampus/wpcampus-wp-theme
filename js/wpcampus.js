(function( $ ) {
	'use strict';

	// Changes .svg to .png if doesn't support SVG (Fallback)
	if ( ! Modernizr.svg ) {

		$( 'img[src*="svg"]' ).attr( 'src', function() {
			return $( this ).attr( 'src' ).replace( '.svg', '.png' );
		});

	}

})( jQuery );