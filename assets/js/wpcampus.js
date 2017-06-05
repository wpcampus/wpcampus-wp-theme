(function( $ ) {
	'use strict';

	/**
	 * Changes .svg to .png if doesn't support SVG (Fallback)
	 *
	 * @TODO: Do we need this?
	 */
	if ( ! Modernizr.svg ) {
		$( 'img[src*="svg"]' ).attr( 'src', function() {
			return $( this ).attr( 'src' ).replace( '.svg', '.png' );
		});
	}

	// Set elements
	var $banner = $( '#wpc-banner' );
	var $banner_logo = $( '#wpc-banner-logo' );
	var $menu_wrapper = $banner.find( '.wpc-menu-wrapper' );
	var $search_wrapper = $banner.find( '.wpc-search-wrapper' );
	var $search_wrapper_bg = $banner.find( '.wpc-search-wrapper-bg' );
	var $search_icon = $search_wrapper.find( '.wpc-search-icon' );

	// Set breakpoints and sizes.
	var small_breakpoint = 640;
	var banner_padding_side = 20;
	var banner_padding_side_desktop = 40;
	var search_wrapper_orig_width = 65;
	var search_wrapper_orig_width_desktop = 105;

	// Setup banner search.
	wpc_init_banner_search();

	// Toggle the menu.
	$menu_wrapper.find( '.toggle-main-menu' ).on( 'touchstart click', function( $event ) {

		// Stop stuff from happening.
		$event.stopPropagation();
		$event.preventDefault();

		// If menu isn't open, open it
		if ( ! $banner.hasClass( 'menu-open' ) ) {

			$banner.addClass( 'menu-open' );
			//$main_menu.slideDown( 400 );

		} else {

			$banner.removeClass( 'menu-open' );
			//$main_menu.slideUp( 400 );

		}

	});

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

	// When the window is resized...
	$(window).on( 'resize', function( $event ) {
		wpc_banner_check_resize();
	});

	/**
	 * Check banner sizes.
	 */
	function wpc_banner_check_resize() {

		// Check styles.
		wpc_check_banner_search_styles();

	}

	/**
	 * Returns the open width for the
	 * banner search depending on screen size.
	 */
	function wpc_get_open_banner_search_width() {
		if ( $(window).width() < small_breakpoint ) {
			return '100%';
		}
		return $banner.width() - ( $banner_logo.offset().left + $banner_logo.outerWidth() );
	}

	/**
	 * Returns the side padding for the
	 * banner depending on screen size.
	 */
	function wpc_get_banner_padding_side() {
		if ( $(window).width() < small_breakpoint ) {
			return banner_padding_side;
		}
		return banner_padding_side_desktop;
	}

	/**
	 * Returns the search wrapper orig
	 * width depending on screen size.
	 */
	function wpc_get_search_wrapper_orig_width() {
		if ( $(window).width() < small_breakpoint ) {
			return search_wrapper_orig_width;
		}
		return search_wrapper_orig_width_desktop;
	}

	/**
	 * Setup the banner search.
	 */
	function wpc_init_banner_search() {

		wpc_check_banner_search_styles();
		wpc_setup_banner_search_actions();

	}

	/**
	 * Setup the banner search styles.
	 */
	function wpc_check_banner_search_styles() {

		/*
		 * Set up the search wrapper.
		 *
		 * Need this for the animate that happens
		 * when search is open when page loads,
		 * e.g. on search results page.
		 */
		if ( $banner.hasClass( 'search-open' ) ) {
			$search_wrapper.css({ 'width': wpc_get_open_banner_search_width() });
		} else {
			$search_wrapper.css({ 'width': wpc_get_search_wrapper_orig_width() });
		}
	}

	/**
	 * Setup the banner search actions.
	 */
	function wpc_setup_banner_search_actions() {

		// Close search if ESC key.
		if ( $banner.hasClass( 'search-open' ) ) {
			$( document ).bind( 'keyup', wpc_banner_search_keypress_handler );
		}
	}

	/**
	 * Open the banner search.
	 */
	function wpc_open_banner_search() {

		// Start the transition.
		$banner.addClass( 'search-open-transition' ).removeClass( 'search-close' );

		// Fade in the search wrapper background.
		/*$search_wrapper_bg.animate({
			opacity: 1
		}, { duration: 800, queue: false });*/

		// Animate the search wrapper.
		$search_wrapper.animate({
			width: wpc_get_open_banner_search_width()
		}, { duration: 800, queue: false, complete: function() {

			// Add the open and remove the transition class.
			$banner.addClass( 'search-open' ).removeClass( 'search-open-transition' );

		}});

		// Give focus to search input.
		$banner.find( '.search-field' ).focus();

		// Close search if ESC key.
		$( document ).bind( 'keyup', wpc_banner_search_keypress_handler );
	}

	/**
	 * Close the banner search.
	 */
	function wpc_close_banner_search() {

		// Start the transition.
		$banner.addClass( 'search-close-transition search-close' ).removeClass( 'search-open' );

		// Fade out the search wrapper background.
		$search_wrapper_bg.animate({
			opacity: 0
		}, { duration: 800, queue: false,
		complete: function() {
			$search_wrapper_bg.css({'opacity':'1'});
		}});

		// Animate the search wrapper.
		$search_wrapper.animate({
			width: wpc_get_search_wrapper_orig_width()
		}, { duration: 800, queue: false,
		step: function( now, fx ) {
			var data = fx.elem.id + " " + fx.prop + ": " + now;
			console.log(data);
			console.log(fx);
			//$( "body" ).append( "<div>" + data + "</div>" );
		},
		complete: function() {

			// Remove the transition class.
			$banner.removeClass( 'search-close-transition search-close' );

		}});

		// Remove ESC bind.
		$( document ).unbind( 'keyup', wpc_banner_search_keypress_handler );

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
})( jQuery );