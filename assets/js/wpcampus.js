(function( $ ) {
	'use strict';

	// Changes .svg to .png if doesn't support SVG (Fallback)
	if ( ! Modernizr.svg ) {

		$( 'img[src*="svg"]' ).attr( 'src', function() {
			return $( this ).attr( 'src' ).replace( '.svg', '.png' );
		});

	}

	// Open/close search.
	var $banner = $( '#wpc-banner' );
	var $search_wrapper = $banner.find( '.wpc-search-wrapper' );
	var $search_wrapper_orig_width = 65;
	var $search_wrapper_full_width = '100%';
	var $search_icon = $search_wrapper.find( '.wpc-search-icon' );
	var $search_icon_open_left = 40;

	// If banner is " pre-opened".
	if ( $banner.hasClass( 'search-open' ) ) {

		// Set up the search wrapper.
		$search_wrapper.css({'width':$search_wrapper_full_width});
		$search_icon.css({'left':$search_icon_open_left+'px'});

		// Close search if ESC key.
		$( 'body' ).bind( 'keypress', wpc_banner_search_keypress_handler );

	}

	// When clicking the search icon...
	$search_icon.on( 'touchstart click', function( $event ) {

		if ( $banner.hasClass( 'search-open' ) ) {

			// Close the banner search.
			wpc_close_banner_search();

		} else {

			// Open the search wrapper.
			wpc_open_banner_search();

		}
	});

	/**
	 * Open the banner search.
	 */
	function wpc_open_banner_search() {

		// Start the transition.
		$banner.addClass( 'search-open-transition' ).removeClass( 'search-close' );

		// Move the icon a little to make sure the banner has side padding.
		$search_icon.animate({
			left: $search_icon_open_left
		}, { duration: 800, queue: false });

		// Animate the search wrapper.
		$search_wrapper.animate({
			width: $search_wrapper_full_width
		}, { duration: 800, queue: false, complete: function() {

			// Add the open and remove the transition class.
			$banner.addClass( 'search-open' ).removeClass( 'search-open-transition' );

		}});

		// Give focus to search input.
		$banner.find( '#s' ).focus();

		// Close search if ESC key.
		$( 'body' ).bind( 'keypress', wpc_banner_search_keypress_handler );
	}

	/**
	 * Close the banner search.
	 */
	function wpc_close_banner_search() {

		// Start the transition.
		$banner.addClass( 'search-close-transition search-close' ).removeClass( 'search-open' );

		// Move the icon a little to make sure the banner has side padding.
		$search_icon.animate({
			left: 0
		}, { duration: 800, queue: false });

		// Animate the search wrapper.
		$search_wrapper.animate({
			width: $search_wrapper_orig_width
		}, { duration: 800, queue: false, complete: function() {

			// Remove the transition class.
			$banner.removeClass( 'search-close-transition search-close' );

		}});

		// Remove ESC bind.
		$( "body" ).unbind( 'keypress', wpc_banner_search_keypress_handler );

	}

	/**
	 * Handle the keypress for banner search.
	 */
	function wpc_banner_search_keypress_handler(e) {

		// If ESC is pressed, close banner search.
		if ( 27 == e.which ) {
			wpc_close_banner_search();
		}
	}

	// Get the banner and main menu
	/*var $banner = jQuery( '#wpc-banner' );
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

	});*/

})( jQuery );