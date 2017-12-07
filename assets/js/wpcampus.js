(function($) {
	'use strict';

	$(document).ready(function() {

		// Changes .svg to .png if doesn't support SVG.
		if ( ! Modernizr.svg ) {

			$( 'img[src*="svg"]' ).attr( 'src', function() {
				return $( this ).attr( 'src' ).replace( '.svg', '.png' );
			});
		}

		// Get the banner and main menu.
		var $banner = $( '#wpcampus-banner' );
		var $main_menu = $( '#wpcampus-main-menu' );

		// Add listener to all elements who have the class to toggle the main menu.
		$( '.toggle-main-menu' ).on( 'touchstart click', function( $event ) {
			$event.stopPropagation();
			$event.preventDefault();

			// If banner isn't open, open it.
			if ( !$banner.hasClass( 'open-menu' ) ) {

				$banner.addClass( 'open-menu' );
				$main_menu.slideDown( 400 );

			} else {

				$banner.removeClass( 'open-menu' );
				$main_menu.slideUp( 400 );

			}
		});
	});
})(jQuery);