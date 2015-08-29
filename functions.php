<?php

//! Setup styles and scripts
add_action( 'wp_enqueue_scripts', function () {

    // Get the directory
    $wordcampus_dir = trailingslashit( get_stylesheet_directory_uri() );

    // Load Fonts
    wp_enqueue_style( 'wordcampus-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:600,400,300' );

    // Enqueue the base styles
    wp_enqueue_style( 'wordcampus', $wordcampus_dir . 'css/styles.min.css', array( 'wordcampus-fonts' ), false );

    // Enqueue modernizr - goes in header
    wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js' );

}, 10 );

// Add the AddThis script to the footer
add_action( 'wp_footer', function() {
    ?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55c7ed90ac8a8479" async="async"></script><?php
});

//! Load favicons
add_action( 'wp_head', 'wordcampus_add_favicons' );
add_action( 'admin_head', 'wordcampus_add_favicons' );
add_action( 'login_head', 'wordcampus_add_favicons' );
function wordcampus_add_favicons() {

    // Set the images folder
    $favicons_folder = get_stylesheet_directory_uri() . '/images/favicons/';

    // Print the default icons
    ?><link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wordcampus-favicon-60.png"/>
    <link rel="apple-touch-icon" href="<?php echo $favicons_folder; ?>wordcampus-favicon-60.png"/><?php

    // Set the image sizes
    $image_sizes = array( 57, 72, 76, 114, 120, 144, 152 );

    foreach( $image_sizes as $size ) {
        ?><link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wordcampus-favicon-<?php echo $size; ?>.png"/><?php
    }

}

// Add login styles
add_action( 'login_head', function() {

    ?><style type="text/css">
    #login h1 a {
        display: block;
        background: url( "<?php echo get_stylesheet_directory_uri(); ?>/images/wordcampus-black.svg" ) center bottom no-repeat;
        background-size: 100% auto;
        width: 90%;
        height: 50px;
    }
    .login form {
        padding-bottom: 35px;
    }
    .login form .forgetmenot {
        float: none;
    }
    #login form p.submit {
        display: block;
        clear: both;
        margin: 20px 0 0 0;
    }
    .login form .button {
        display: block;
        background: #555;
        float: none;
        width: 100%;
        height: auto !important;
        border: 0;
        color: #fff;
        cursor: pointer;
        padding: 12px 0 12px 0 !important;
        font-size: 1.1em;
        line-height: 1em !important;
        text-transform: uppercase;
    }
    .login form .button:hover {
        background: #222;
    }
    </style><?php

});

//! Filter login logo URL
add_filter( 'login_headerurl', function( $login_header_url ) {
    return get_bloginfo( 'url' );
});

//! Hide Query Monitor if admin bar isn't showing
add_filter( 'qm/process', function( $show_qm, $is_admin_bar_showing ) {
    return $is_admin_bar_showing;
});

// Register our interest CPT
add_action( 'init', function() {

    // Register private WordCampus interest CPT
    register_post_type( 'wpcampus_interest', array(
        'labels'             => array(
            'name'               => 'Interest',
        ),
        'public'                => false,
        'publicly_queryable'    => false,
        'exclude_from_search'   => true,
        'show_ui'               => true,
        'show_in_nav_menus'     => false,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'show_in_admin_bar'     => false,
        'capability_type'       => 'wpcampus_interest',
        'hierarchical'          => false,
        'supports'              => array( 'title', 'editor', 'custom-fields' ),
        'has_archive'           => false,
        'rewrite'               => false,
        //'query_var'             => false,
        'can_export'            => false,
    ) );

});

// Convert interest form entries to CPT upon submission
add_action( 'gform_after_submission_1', function( $entry, $form ) {

    // Convert this entry to a post
    wordcampus_convert_entry_to_post( $entry, $form );

}, 10, 2 );

// Manually convert interest form entries to CPT
add_action( 'admin_init', function() {

    // @TODO create an admin button for this?
    return;

    // ID for interest form
    $form_id = 1;

    // What entry should we start on?
    $entry_offset = 0;

    // How many entries?
    $entry_count = 50;

    // Get interest entries
    if ( $entries = GFAPI::get_entries( $form_id, array( 'status' => 'active' ), array(), array( 'offset' => $entry_offset, 'page_size' => $entry_count ) ) ) {

        // Get form data
        $form = GFAPI::get_form( $form_id );

        // Process each entry
        foreach( $entries as $entry ) {

            // Convert this entry to a post
            wordcampus_convert_entry_to_post( $entry, $form );

        }

    }

});

// Process specific form entry to convert to CPT
// Can pass entry or form object or entry or form ID
function wordcampus_convert_entry_to_post( $entry, $form ) {

    // If ID, get the entry
    if ( is_numeric( $entry ) && $entry > 0 ) {
        $entry = GFAPI::get_entry( $entry );
    }

    // If ID, get the form
    if ( is_numeric( $form ) && $form > 0 ) {
        $form = GFAPI::get_form( $form );
    }

    // Make sure we have some info
    if ( ! $entry || ! $form ) {
        return false;
    }

    // Set the entry id
    $entry_id = $entry['id'];

    // First, check to see if the entry has already been processed
    $entry_post = wordcampus_get_entry_post( $entry_id );

    // If this entry has already been processed, then skip
    if ( $entry_post && isset( $entry_post->ID ) ) {
        return false;
    }

    // Fields to store in post meta
    // Names will be used dynamically when processing fields below
    $fields_to_store = array(
        'name',
        'involvement',
        'sessions',
        'event_time',
        'email',
        'status',
        'employer',
        'attend_preference',
        'traveling_city',
        'traveling_state',
        'traveling_country',
        'traveling_latitude',
        'traveling_longitude',
        'slack_invite',
        'slack_email'
    );

    // Process one field at a time
    foreach( $form[ 'fields']  as $field ) {

        // Set the admin label
        $admin_label = strtolower( preg_replace( '/\s/i', '_', $field[ 'adminLabel' ] ) );

        // Only process if one of our fields
        // We need to process traveling_from but not store it in post meta which is why it's not in the array
        if ( ! in_array( $admin_label, array_merge( $fields_to_store, array( 'traveling_from' ) ) ) ) {
            continue;
        }

        // Process fields according to admin label
        switch( $admin_label ) {

            case 'name':

                // Get name parts
                $first_name = null;
                $last_name = null;

                // Process each name part
                foreach( $field->inputs as $input ) {
                    $name_label = strtolower( $input['label'] );
                    switch( $name_label ) {
                        case 'first':
                        case 'last':
                            ${$name_label.'_name'} = rgar( $entry, $input['id'] );
                            break;
                    }
                }

                // Build name to use when creating post
                $name = trim( "{$first_name} {$last_name}" );

                break;

            case 'involvement':
            case 'sessions':
            case 'event_time':

                // Get all the input data and place in array
                ${$admin_label} = array();
                foreach( $field->inputs as $input ) {

                    if ( $this_data = rgar( $entry, $input['id'] ) ) {
                        ${$admin_label}[] = $this_data;
                    }

                }

                break;

            case 'traveling_from':

                // Get all the input data and place in array
                ${$admin_label} = array();
                foreach( $field->inputs as $input ) {

                    // Create the data index
                    $input_label = strtolower( preg_replace( '/\s/i', '_', preg_replace( '/\s\/\s/i', '_', $input['label'] ) ) );

                    // Change to simply state
                    if ( 'state_province' == $input_label ) {
                        $input_label = 'state';
                    }

                    // Store data
                    if ( $this_data = rgar( $entry, $input['id'] ) ) {
                        ${"traveling_{$input_label}"} = $this_data;
                    }

                    // Store all traveling data in an array
                    ${$admin_label}[$input_label] = $this_data;

                }

                // Create string of traveling data
                $traveling_string = preg_replace( '/[\s]{2,}/i', ' ', implode( ' ', ${$admin_label} ) );

                // Get latitude and longitude
                if ( $traveling_lat_long = wordcampus_get_lat_long( $traveling_string ) ) {

                    // Store data (will be stored in post meta later)
                    $traveling_latitude = isset( $traveling_lat_long->lat ) ? $traveling_lat_long->lat : false;
                    $traveling_longitude = isset( $traveling_lat_long->lng ) ? $traveling_lat_long->lng : false;

                }

                break;

            // Get everyone else
            default:

                // Get field value
                ${$admin_label} = rgar( $entry, $field->id );

                break;

        }

    }

    // Create entry post title
    $post_title = "Entry #{$entry_id}";

    // Add name
    if ( ! empty( $name ) ) {
        $post_title .= " - {$name}";
    }

    // Create entry
    if ( $new_entry_post_id = wp_insert_post( array(
        'post_type' => 'wpcampus_interest',
        'post_status' => 'publish',
        'post_title' => $post_title,
        'post_content' => '',
    ) ) ) {

        // Store entry ID in post
        update_post_meta( $new_entry_post_id, 'gf_entry_id', $entry_id );

        // Store post ID in the entry
        GFAPI::update_entry_property( $entry_id, 'post_id', $new_entry_post_id );

        // Store fields
        foreach( $fields_to_store as $field_name ) {
            update_post_meta( $new_entry_post_id, $field_name, ${$field_name} );
        }

        return true;

    }

    return false;

}

// Takes the address and returns location lat and long from Google
function wordcampus_get_lat_long( $address ) {

    // Get Geocode data
    if ( $geocode = wordcampus_get_geocode( $address ) ) {

        // Get the geometry
        if ( $geometry = isset( $geocode->geometry ) ? $geocode->geometry : false ) {

            // Get the location
            if ( $location = isset( $geometry->location ) ? $geometry->location : false ) {

                return $location;

            }

        }

    }

    return false;

}

// Takes the address and returns geocode data from Google
function wordcampus_get_geocode( $address ) {

    // Make sure we have an address
    if ( ! trim( $address ) ) {
        return false;
    }

    // Build maps query
    $maps_api_key = get_option( 'wordcampus_google_maps_api_key' );
    $query = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode( $address ) . "&key=" . $maps_api_key;

    // If data is returned...
    if ( ( $response = wp_remote_get( $query ) )
        && ( $data = wp_remote_retrieve_body( $response ) ) ) {

        // Decode the data
        $data = json_decode( $data );

        // Get the first result
        if ( $result = isset( $data->results ) && is_array($data->results ) ? array_shift( $data->results ) : false ) {

            return $result;

        }

    }

    return false;

}

// Get post created from entry
function wordcampus_get_entry_post( $entry_id ) {
    global $wpdb;
    return $wpdb->get_row( "SELECT posts.*, meta.meta_value AS gf_entry_id FROM {$wpdb->posts} posts INNER JOIN {$wpdb->postmeta} meta ON meta.post_id = posts.ID AND meta.meta_key = 'gf_entry_id' AND meta.meta_value = '{$entry_id}' WHERE posts.post_type ='wpcampus_interest'" );
}