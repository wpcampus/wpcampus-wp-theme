<?php

/**
 * Our data API class.
 */
class WPCampus_API_Data {

	/**
	 * Register our API routes.
	 */
	public function register_routes( $routes ) {

		// Get WPCampus data.
		register_rest_route( 'wpcampus/data', '/set/(?P<set>[a-z\_\-]+)', array(
			'methods'   => WP_REST_Server::READABLE,
			'callback'  => array( $this, 'get_data_set' ),
			'permission_callback' => function () {
				return true;
			},
		));

		return $routes;
	}

	// Respond with particular data.
	function get_data_set( WP_REST_Request $request ) {

		// Build the response.
		$response = null;

		switch ( $request['set'] ) {

			case 'no-of-interested':
				$response = wpcampus_get_interested_count();
				break;

			case 'affiliation':
				$response = array(
					'work_in_higher_ed'         => wpcampus_get_work_in_higher_ed_count(),
					'work_for_company'          => wpcampus_get_work_for_company_count(),
					'work_outside_higher_ed'    => wpcampus_get_work_outside_higher_ed_count(),
				);
				break;

			case 'attend-preference':
				$response = array(
					'attend_in_person'      => wpcampus_get_attend_in_person_count(),
					'attend_live_stream'    => wpcampus_get_attend_live_stream_count(),
				);
				break;

			case 'attend-has-location':
				$response = wpcampus_get_interested_has_location_count();
				break;

			case 'attend-country':
				$response = wpcampus_get_interest_by_country();
				break;

			case 'best-time-of-year':
				$response = wpcampus_get_interest_best_time_of_year();
				break;

			case 'sessions':
				$response = wpcampus_get_interest_sessions();
				break;

			case 'universities':
				$response = wpcampus_get_interest_universities();
				break;

			case 'vote-on-new-name':
				$response = wpcampus_get_vote_on_new_name();
				break;

		}

		// If no response, return an error.
		if ( ! $response ) {
			return new WP_Error( 'wpcampus', 'This data set is either invalid or does not contain information.', array( 'status' => 404 ) );
		} else {

			// Return a response object.
			return new WP_REST_Response( $response );

		}
	}
}
