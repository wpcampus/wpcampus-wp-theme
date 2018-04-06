(function( $ ) {
	'use strict';

	// When the document is ready...
	$(document).ready(function() {

		// Set the sessions container and let us know we're loading.
		const $wpc_sessions = $( '#wpcampus-sessions' ).addClass( 'loading' );

		// Get the sessions data.
		$.get( '/wp-json/wpcampus/data/events/sessions', function(events) {

			if ( events === undefined ) {
				return;
			}

			var events_str = [];

			// Sort events.
            $.each( events, function(index, event) {

				// Build list of sessions.
				var event_sessions_str = [];

				// Sort data
				$.each( event.sessions, function ( index, session ) {

					// Make sure we have a post title.
					if ( session.post_title === undefined || session.post_title == '' ) {
						return false;
					}

					// Start building the session's string.
					var session_string = session.post_title;

					// Add the permalink.
					if ( session.permalink !== undefined && session.permalink != '' ) {
						session_string = '<a href="' + session.permalink + '">' + session_string + '</a>';
					}

					// Add to the list.
					event_sessions_str.push(session_string);

				});

				// If we have sessions...
				if ( event_sessions_str.length > 0 ) {
					events_str.push('<h2 id="' + event.slug + '">' + event.title + '</h2><ol><li>' + event_sessions_str.join('</li><li>') + '</li></ol>')
				}
            });

            if ( events_str.length > 0 ) {

            	// Remove loading class and add sessions list.
            	$wpc_sessions.css({'min-height':$wpc_sessions.outerHeight()+'px'}).fadeTo(1000,0,function(){
            		$wpc_sessions.removeClass('loading').html( events_str.join('') ).fadeTo(1000,1);
            	});
            }
		})
		.fail( function () {
			$wpc_sessions.html( wpc_sessions.load_error_msg );
		})
	});
})(jQuery);