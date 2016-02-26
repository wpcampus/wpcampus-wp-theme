<?php

// Include filters
require_once( STYLESHEETPATH . '/includes/filters.php' );

// Include data functionality
require_once( STYLESHEETPATH . '/includes/data.php' );

// Include university functionality
require_once( STYLESHEETPATH . '/includes/universities.php' );

// Include shortcodes
require_once( STYLESHEETPATH . '/includes/shortcodes.php' );

// Setup the API
add_action( 'rest_api_init', function () {
    global $wpcampus_api_data;

    // Load the class
    require_once( STYLESHEETPATH . '/includes/class-api-data.php' );

    // Initialize our class
    $wpcampus_api_data = new WPCampus_API_Data();

    // Register our routes
    $wpcampus_api_data->register_routes();

} );

//! Setup styles and scripts
add_action( 'wp_enqueue_scripts', function () {
	$wpcampus_version = '0.58';

    // Get the directory
    $wpcampus_dir = trailingslashit( get_stylesheet_directory_uri() );

    // Load Fonts
    wp_enqueue_style( 'wpcampus-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:600,400,300' );

    // Enqueue the base styles
    wp_enqueue_style( 'wpcampus', $wpcampus_dir . 'css/styles.min.css', array( 'wpcampus-fonts' ), $wpcampus_version, 'all' );

    // Enqueue modernizr - goes in header
    wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js' );

    // Enqueue the main script file - goes in footer
    wp_enqueue_script( 'wpcampus', $wpcampus_dir . 'js/wpcampus.min.js', array( 'jquery', 'modernizr' ), $wpcampus_version, true );

    // Enqueue the data scripts
    if ( is_page( 'data' ) ) {

        // Register Google Charts script
        wp_register_script( 'google-charts', 'https://www.google.com/jsapi', array('jquery' ) );

        // Register Chartist script
        wp_register_script( 'chartist', 'https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js' );
		
        // Enqueue Chartist styles
        wp_enqueue_style( 'chartist', $wpcampus_dir . 'css/chartist.min.css', array(), $wpcampus_version, 'all' );

        // Enqueue our data script
		// Set a var so that we can automatically use the non-minified script on staging, but the minified script on prod
		$min = stristr( $_SERVER['HTTP_HOST'], '.staging' ) ? '' : '.min';
        wp_enqueue_script( 'wpcampus-data', $wpcampus_dir . 'js/wpcampus-data' . $min . '.js', array('jquery', 'google-charts', 'chartist'), $wpcampus_version, false );

    }

    // Enqueue the events styles
    if ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
        wp_enqueue_style( 'wpcampus-events', $wpcampus_dir . 'css/tribe-events.min.css', array( 'wpcampus' ), $wpcampus_version, 'all' );
    }

}, 10 );

// Add the AddThis script to the footer
add_action( 'wp_footer', function() {
    ?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55c7ed90ac8a8479" async="async"></script><?php
});

//! Load favicons
add_action( 'wp_head', 'wpcampus_add_favicons' );
add_action( 'admin_head', 'wpcampus_add_favicons' );
add_action( 'login_head', 'wpcampus_add_favicons' );
function wpcampus_add_favicons() {

    // Set the images folder
    $favicons_folder = get_stylesheet_directory_uri() . '/images/favicons/';

    // Print the default icons
    ?><link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/>
    <link rel="apple-touch-icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/><?php

    // Set the image sizes
    $image_sizes = array( 57, 72, 76, 114, 120, 144, 152 );

    foreach( $image_sizes as $size ) {
        ?><link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png"/><?php
    }

}

// Add login styles
add_action( 'login_head', function() {

    ?><style type="text/css">
    #login h1 a {
        display: block;
        background: url( "<?php echo get_stylesheet_directory_uri(); ?>/images/wpcampus-black.svg" ) center bottom no-repeat;
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

//! Hide Query Monitor if admin bar isn't showing
add_filter( 'qm/process', function( $show_qm, $is_admin_bar_showing ) {
    return $is_admin_bar_showing;
}, 10, 2 );

// Get the post type archive title
function wpcampus_get_post_type_archive_title( $post_type = '' ) {

    // Make sure we have a post type
    if ( ! $post_type ) {
        $post_type = get_query_var( 'post_type' );
    }

    // Get post type archive title
    if ( $post_type ) {

        // Make sure its not an array
        if ( is_array( $post_type ) ) {
            $post_type = reset( $post_type );
        }

        // Get the post type data
        if ( $post_type_obj = get_post_type_object( $post_type ) ) {

            // Get the title
            $title = apply_filters( 'post_type_archive_title', $post_type_obj->labels->name, $post_type );

            // Return the title
            return apply_filters( 'wpcampus_post_type_archive_title', $title, $post_type );

        }

    }

    return null;
}

// Get breadcrumbs
function wpcampus_get_breadcrumbs_html() {

	// Build array of breadcrumbs
	$breadcrumbs = array();

    // Not for front page
    if ( is_front_page() ) {
        return false;
    }

    // Get post type
    $post_type = get_query_var( 'post_type' );

    // Make sure its not an array
    if ( is_array( $post_type ) ) {
        $post_type = reset( $post_type );
    }

    // Add home
    $breadcrumbs[] = array(
        'url'   => get_bloginfo( 'url' ),
        'label' => 'Home',
    );

    // Add archive(s)
    if ( is_archive() ) {

        // Add the archive breadcrumb
        if ( is_post_type_archive() ) {

            // Get the info
            $post_type_archive_link = get_post_type_archive_link( $post_type );
            $post_type_archive_title = wpcampus_get_post_type_archive_title( $post_type );

            // Add the breadcrumb
            if ( $post_type_archive_link && $post_type_archive_title ) {
                $breadcrumbs[] = array( 'url' => $post_type_archive_link, 'label' => $post_type_archive_title );
            }

        }

    } else {

        // Add links to archive
        if ( is_singular() ) {

            // Get the information
            $post_type_archive_link = get_post_type_archive_link( $post_type );
            $post_type_archive_title = wpcampus_get_post_type_archive_title( $post_type );

            if ( $post_type_archive_link ) {
                $breadcrumbs[] = array( 'url' => $post_type_archive_link, 'label' => $post_type_archive_title );
            }

        }

        // Print info for the current post
        if ( ( $post = get_queried_object() ) && is_a( $post, 'WP_Post' ) ) {

            // Get ancestors
            $post_ancestors = isset( $post ) ? get_post_ancestors( $post->ID ) : array();

            // Add the ancestors
            foreach ( $post_ancestors as $post_ancestor_id ) {

                // Add ancestor
                $breadcrumbs[] = array( 'ID' => $post_ancestor_id, 'url' => get_permalink( $post_ancestor_id ), 'label' => get_the_title( $post_ancestor_id ), );

            }

            // Add current page - if not home page
            if ( isset( $post ) ) {
                $breadcrumbs[ 'current' ] = array( 'ID' => $post->ID, 'url' => get_permalink( $post ), 'label' => get_the_title( $post->ID ), );
            }

        }

    }

	// Build breadcrumbs HTML
	$breadcrumbs_html = null;

	foreach( $breadcrumbs as $crumb_key => $crumb ) {

		// Make sure we have what we need
		if ( empty( $crumb[ 'label' ] ) ) {
			continue;
		}

		// If no string crumb key, set as ancestor
		if ( ! $crumb_key || is_numeric( $crumb_key ) ) {
			$crumb_key = 'ancestor';
		}

		// Setup classes
		$crumb_classes = array( $crumb_key );

		// Add if current
		if ( isset( $crumb[ 'current' ] ) && $crumb[ 'current' ] ) {
			$crumb_classes[] = 'current';
		}

		$breadcrumbs_html .= '<li role="menuitem"' . ( ! empty( $crumb_classes ) ? ' class="' . implode( ' ', $crumb_classes ) . '"' : null ) . '>';

		// Add URL and label
		if ( ! empty( $crumb[ 'url' ] ) ) {
			$breadcrumbs_html .= '<a href="' . $crumb[ 'url' ] . '"' . ( ! empty( $crumb[ 'title' ] ) ? ' title="' . $crumb[ 'title' ] . '"' : null ) . '>' . $crumb[ 'label' ] . '</a>';
		} else {
			$breadcrumbs_html .= $crumb[ 'label' ];
		}

		$breadcrumbs_html .= '</li>';

	}

    // Wrap them in nav
	$breadcrumbs_html = '<div class="breadcrumbs-wrapper"><nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">' . $breadcrumbs_html . '</nav></div>';

	//  We change up the variable so it doesn't interfere with global variable
	return $breadcrumbs_html;

}

// Register our CPTs and taxonomies
add_action( 'init', function() {

    // Register private WPCampus interest CPT
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
        'menu_icon'             => 'dashicons-star-filled',
        'show_in_admin_bar'     => false,
        'capability_type'       => 'wpcampus_interest',
        'hierarchical'          => false,
        'supports'              => array( 'title', 'editor', 'custom-fields' ),
        'has_archive'           => false,
        'rewrite'               => false,
        //'query_var'             => false,
        'can_export'            => false,
    ) );

    // Register the universities CPT
    register_post_type( 'universities', array(
        'labels'                => array(
            'name'              => 'Universities',
            'singular_name'     => 'University',
            'add_new'           => 'Add New',
            'add_new_item'      => 'Add New University',
            'edit_item'         => 'Edit University',
            'new_item'          => 'New University',
            'all_items'         => 'All Universities',
            'view_item'         => 'View University',
            'search_items'      => 'Search Universities',
            'not_found'         => 'No universities found',
            'not_found_in_trash'=> 'No universities found in trash',
            'parent_item_colon' => 'Parent University',
        ),
        'public'                => false,
        'hierarchical'          => false,
        'supports'              => array( 'title', 'editor' ),
        'has_archive'           => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_icon'             => 'dashicons-welcome-learn-more',
        'show_in_nav_menus'     => false,
        'show_in_admin_bar'     => true,
        'publicly_queryable'    => false,
        'exclude_from_search'   => true,
        'capabilities'          => array(
            'edit_post'         => 'edit_university',
            'edit_posts'        => 'edit_universities',
            'edit_others_posts' => 'edit_others_universities',
            'edit_private_posts'=> 'edit_private_universities',
            'edit_published_posts' => 'edit_published_universities',
            'read'              => 'read_university',
            'read_post'         => 'read_university',
            'read_private_posts'=> 'read_private_universities',
            'delete_post'       => 'delete_university',
            'delete_posts'      => 'delete_universities',
            'delete_private_posts' => 'delete_private_universities',
            'delete_published_posts' => 'delete_published_universities',
            'delete_others_posts' => 'delete_others_universities',
            'publish_posts'     => 'publish_universities',
            'create_posts'      => 'edit_universities'
        ),
        'rewrite'               => false,
        'can_export'            => true,
    ) );

    // Add university categories taxonomy
    register_taxonomy( 'university_cats', 'universities', array(
        'labels' => array(
            'name'          => 'Categories',
            'singular_name' => 'Category',
            'search_items'  => 'Search Categories',
            'all_items'     => 'All Categories',
            'parent_item'   => 'Parent Category',
            'parent_item_colon' => 'Parent Category:',
            'edit_item'     => 'Edit Category',
            'update_item'   => 'Update Category',
            'add_new_item'  => 'Add New Category',
            'new_item_name' => 'New Category Name',
            'menu_name'     => 'Categories',
        ),
        'public'            => false,
        'show_ui'           => true,
        'show_in_nav_menus' => false,
        'show_tagcloud'     => false,
        'show_in_quick_edit'=> true,
        'show_admin_column' => true,
        'hierarchical'      => true,
        'rewrite'           => false,
        'capabilities'      => array(
            'manage_terms'  => 'manage_univ_categories',
            'edit_terms'    => 'manage_univ_categories',
            'delete_terms'  => 'manage_univ_categories',
            'assign_terms'  => 'edit_universities',
        )
    ));

});

// Convert interest form entries to CPT upon submission
add_action( 'gform_after_submission_1', function( $entry, $form ) {

    // Convert this entry to a post
    wpcampus_convert_entry_to_post( $entry, $form );

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
            wpcampus_convert_entry_to_post( $entry, $form );

        }

    }

});

// Process specific form entry to convert to CPT
// Can pass entry or form object or entry or form ID
function wpcampus_convert_entry_to_post( $entry, $form ) {

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
    $entry_post = wpcampus_get_entry_post( $entry_id );

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
                if ( $traveling_lat_long = wpcampus_get_lat_long( $traveling_string ) ) {

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
function wpcampus_get_lat_long( $address ) {

    // Get Geocode data
    if ( $geocode = wpcampus_get_geocode( $address ) ) {

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
function wpcampus_get_geocode( $address ) {

    // Make sure we have an address
    if ( ! trim( $address ) ) {
        return false;
    }

    // Build maps query - needs Google API Server Key
    $maps_api_key = get_option( 'wpcampus_google_maps_api_key' );
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
function wpcampus_get_entry_post( $entry_id ) {
    global $wpdb;
    return $wpdb->get_row( "SELECT posts.*, meta.meta_value AS gf_entry_id FROM {$wpdb->posts} posts INNER JOIN {$wpdb->postmeta} meta ON meta.post_id = posts.ID AND meta.meta_key = 'gf_entry_id' AND meta.meta_value = '{$entry_id}' WHERE posts.post_type ='wpcampus_interest'" );
}