(function( $ ) {
	'use strict';

	// When the document is ready...
	$(document).ready(function() {

		// Set the sessions container and let us know we're loading.
		var $wpc_sessions = $( '#wpcampus-sessions' ).addClass( 'loading' );

		// Get the sessions data.
		$.get( '/wp-json/wpcampus/data/events/sessions', function ( sessions ) {

			// Build list of sessions.
			var sessions_str = [];

			// Sort data
			$.each( sessions, function ( index, value ) {

				// Make sure we have a post title.
				if (value.post_title === undefined || value.post_title == '') {
					return false;
				}

				// Start building the session's string.
				var session_string = value.post_title;

				// Add the permalink.
				if (value.permalink !== undefined && value.permalink != '') {
					session_string = '<a href="' + value.permalink + '">' + session_string + '</a>';
				}

				// Add event
				if (value.event !== undefined && value.event != '') {
					session_string += ' <span class="event">(' + value.event + ')</span>';
				}

				// Add to the list.
				sessions_str.push(session_string);

			});

			// If we have sessions...
			if (sessions_str.length > 0) {

				// Create sessions object.
				var $wpc_sessions_list = $('<div id="wpcampus-sessions-list"><ol><li>' + sessions_str.join('</li><li>') + '</li></ol></div>').hide();

				// Remove loading class and add sessions list.
				$wpc_sessions.removeClass('loading').html($wpc_sessions_list);

				// Fade in the list.
				$wpc_sessions_list.fadeIn(1000);
			}
		})
		.fail( function () {
			$wpc_sessions.html( wpc_sessions.load_error_msg );
		})
	});
})( jQuery );