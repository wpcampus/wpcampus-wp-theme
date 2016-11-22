(function( $ ) {
	'use strict';

	// Changes .svg to .png if doesn't support SVG (Fallback)
	if ( ! Modernizr.svg ) {

		$( 'img[src*="svg"]' ).attr( 'src', function() {
			return $( this ).attr( 'src' ).replace( '.svg', '.png' );
		});

	}

	// Get the banner and main menu
	var $banner = jQuery( '#wpc-banner' );
	var $main_menu = jQuery( '#wpcampus-main-menu' );

	// Add listener to all elements who have the class to toggle the main menu
	jQuery( '.toggle-main-menu' ).on( 'touchstart click', function( $event ) {

		// Stop stuff from happening
		$event.stopPropagation();
		$event.preventDefault();

		// If banner isn't open, open it
		if ( ! $banner.hasClass( 'open-menu' ) ) {

			$banner.addClass( 'open-menu' );
			$main_menu.slideDown( 400 );

		} else {

			$banner.removeClass( 'open-menu' );
			$main_menu.slideUp( 400 );

		}

	});

})( jQuery );