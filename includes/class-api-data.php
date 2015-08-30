<?php

// Our data API class
class WordCampus_API_Data {

    // Register our API routes
    public function register_routes( $routes ) {

        // Get WordCampus data
        register_rest_route( 'wordcampus/data', '/set/(?P<set>[a-z\_]+)', array(
            'methods'   => WP_REST_Server::READABLE,
            'callback'  => array( $this, 'get_data_set' ),
            'permission_callback' => function () {
                return true;
            }
        ) );

        return $routes;
    }

    // Respond with particular data
    function get_data_set( WP_REST_Request $request ) {

        // Build the response
        $response = null;

        switch( $request['set'] ) {

            case 'affiliation':
                $response = array(
                    'work_in_higher_ed' => wordcampus_get_work_in_higher_ed_count(),
                    'work_for_company' => wordcampus_get_work_for_company_count(),
                    'work_outside_higher_ed' => wordcampus_get_work_outside_higher_ed_count(),
                );
                break;

        }

        // If no response, return an error
        if ( ! $response ) {
            return new WP_Error( 'wordcampus', 'This data set is either invalid or does not contain information.', array( 'status' => 404 ) );
        } else {

            // Return a response object
            return new WP_REST_Response( $response );

        }

    }

}