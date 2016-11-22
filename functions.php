<?php

// Include filters.
require_once( STYLESHEETPATH . '/includes/filters.php' );

// Include data functionality.
require_once( STYLESHEETPATH . '/includes/data.php' );

// Include university functionality.
require_once( STYLESHEETPATH . '/includes/universities.php' );

// Include shortcodes.
require_once( STYLESHEETPATH . '/includes/shortcodes.php' );

// Setup the API.
add_action( 'rest_api_init', function () {
    global $wpcampus_api_data;

    // Load the class
    require_once( STYLESHEETPATH . '/includes/class-api-data.php' );

    // Initialize our class
    $wpcampus_api_data = new WPCampus_API_Data();

    // Register our routes
    $wpcampus_api_data->register_routes();

} );

// Add theme supports.
add_theme_support( 'title-tag' );

// Register menu locations.
function wpc_theme_register_menus() {
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpcampus' ),
		'footer' => __( 'Footer Menu', 'wpcampus' ),
	));
}
add_action( 'init', 'wpc_theme_register_menus' );

// Setup styles and scripts.
add_action( 'wp_enqueue_scripts', function () {
	$wpcampus_version = '0.58';

    // Get the directory
    $wpcampus_dir = trailingslashit( get_template_directory_uri() );

    // Load Fonts
    wp_enqueue_style( 'wpcampus-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:600,400,300' );

    // Enqueue the base styles
    wp_enqueue_style( 'wpcampus', $wpcampus_dir . 'assets/css/styles.min.css', array( 'wpcampus-fonts' ), $wpcampus_version, 'all' );

    // Enqueue modernizr - goes in header
    wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js' );

    // Enqueue the main script file - goes in footer
    wp_enqueue_script( 'wpcampus', $wpcampus_dir . 'assets/js/wpcampus.min.js', array( 'jquery', 'modernizr' ), $wpcampus_version, true );

	// Enqueue eduwapuu on the home page.
	if ( is_front_page() ) {
		wp_enqueue_script( 'eduwapuu', $wpcampus_dir . 'assets/js/eduwapuu.min.js', array( 'jquery' ), $wpcampus_version, true );
	}

    // Enqueue the data scripts
    if ( is_page( 'data' ) ) {

        // Register Google Charts script
        wp_register_script( 'google-charts', 'https://www.google.com/jsapi', array('jquery' ) );

        // Register Chartist script
        wp_register_script( 'chartist', 'https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js' );
		
        // Enqueue Chartist styles
        wp_enqueue_style( 'chartist', $wpcampus_dir . 'assets/css/chartist.min.css', array(), $wpcampus_version, 'all' );

        /*
         * Enqueue our data script.
         *
         * Set a var so that we can automatically use the non-minified
         * script on staging but the minified script on prod.
         */
		$min = stristr( $_SERVER['HTTP_HOST'], '.staging' ) ? '' : '.min';
        wp_enqueue_script( 'wpcampus-data', $wpcampus_dir . 'assets/js/wpcampus-data' . $min . '.js', array( 'jquery', 'google-charts', 'chartist' ), $wpcampus_version, false );

    }

    // Enqueue the events styles
    if ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
        wp_enqueue_style( 'wpcampus-events', $wpcampus_dir . 'assets/css/tribe-events.min.css', array( 'wpcampus' ), $wpcampus_version, 'all' );
    }

}, 10 );

// Load favicons
add_action( 'wp_head', 'wpc_theme_add_favicons' );
add_action( 'admin_head', 'wpc_theme_add_favicons' );
add_action( 'login_head', 'wpc_theme_add_favicons' );
function wpc_theme_add_favicons() {

    // Set the images folder
    $favicons_folder = trailingslashit( get_template_directory_uri() ) . 'assets/images/favicons/';

    // Print the default icons
    ?><link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png" />
    <link rel="apple-touch-icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png" /><?php

    // Set the image sizes
    $image_sizes = array( 57, 72, 76, 114, 120, 144, 152 );

    foreach( $image_sizes as $size ) {
        ?><link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png" /><?php
    }

}

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

/**
 * Print the eduwapuu.
 */
function wpc_theme_print_eduwapuu() {

	?>
	<div class="eduwapuu-wrapper">
		<a href="#">
			<svg class="eduwapuu" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 200 234" style="enable-background:new 0 0 200 234;" xml:space="preserve">
				<style type="text/css">
					.st0{fill:#FFFFFF;}
					.st1{fill:#FFD200;}
					.st2{fill:#FF8800;}
					.st3{fill:#3C3C3C;}
					.st4{fill:#00709C;}
				</style>
				<g>
					<path class="st0" d="M89.7,234c-6.5,0-13.1-1.3-19.6-3.9c-5.3-2.1-10.5-5.1-14.5-8.4c-3.3-2.7-6.7-6.6-7.7-8.5
			c-2.1-3.9-2.6-5.4-3.1-7.9c-0.9-4.6,0.5-11.5,3.3-14.3c2.2-2.2,4.5-4.3,7.7-5.1c1.3-0.3,2.6-0.5,4-0.5c3.4,0,7.1,1.1,10.4,3
			c3.9,2.3,7.2,5.7,9.8,10c1.1,1.9,2.8,3.4,4.8,4.4c2.2,1.1,4.9,1.6,8,1.6c0.1,0,0.3,0,0.4,0c10.3-0.2,22.2-5.8,31.4-14.4
			c-2.6,2.3-3.6,4.1-4.3,4.1l-0.2,0c-3.1,3.1-8,6.1-13.5,6.1c-4.3,0-8.3-2-10.9-5.5c-0.3-0.4-0.5-0.7-0.8-1.1
			c-5.1-0.4-10.1-1.6-15-3.3c-4.3-1.5-8.4-3.5-12.2-6c-1.9,2.6-5,4-8.5,4c-1.2,0-2.4-0.2-3.7-0.5c-5.7-1.4-12.6-5.9-18.8-12.4
			c-6-6.2-10.2-13-11.2-18.1c-0.9-4.5-0.3-8.9,1.8-12.4L0.4,85.7c-0.7-1.7-0.5-3.6,0.7-5c0.2-0.2,0.3-0.4,0.5-0.5
			c-0.2-1.2,0-2.5,0.7-3.5c0.9-1.3,2.3-2.1,3.9-2.1c0,0,0,0,2.9,0.1c0.1-0.6,0.4-2.1,0.7-2.6c0.9-1.3,2.3-2,3.9-2
			c0.5,0,1,0.1,1.5,0.3l10.9,3.7c0.5,0.2,10,3.4,20.4,9.3c-0.5-2.5,0.4-4.2,2.3-6.1c1.1-1.1,2.6-1.6,4-2.2c0.8-0.3,1.8-0.8,5.7-3.5
			c0.8-0.6,1.7-1,2.7-1.2c0.2-0.4,0.4-0.7,0.6-1.1c1.5-2.4,3.2-4.7,5.1-6.8c-0.3-0.6-0.5-1.2-0.6-1.8c-0.1-0.8-0.2-1.6-0.3-2.4
			c-4.2-3.3-26.1-20.4-28-22c-3-2.7-3.3-6.4-2.3-8.8c0.6-1.4,4.2-3.4,5.6-3.7l99.5-23.6C141.3,0,141.6,0,142,0c1.7,0,3.3,0.9,4.1,2.4
			c0.3,0.5,0.6,1.1,0.9,1.6c0.3,0,0.5,0,0.8,0c1.9,0,3.6,0.5,5.1,1.5c1.3,0.8,2.5,2,3.5,3.5c1.9,2.7,3.1,6.1,3.9,8.8
			c1.4,4.4,2.3,8.8,2.3,9.1c0.2,0.7,1.5,2.9,2.1,3.9l0,0c0.8,1.3,1.5,2.5,2.1,3.8c2,4.1,4.3,9.5,6.8,15.6c0.3,0,0.8,0,0.8,0
			c2.7-0.1,5.5-0.2,8.3-0.2c3.8,0,6.9,0.1,9.9,0.4c4.1,0.4,7.1,3.8,7.1,7.9c0,3.5-1.1,6.7-3.1,9.7c-2,2.8-4.8,5.3-8.5,7.3
			c-1.4,0.8-2.8,1.4-4.4,2c1.8,5.3,3.2,9.7,4,12.9c1,3.8,0.9,6.9-0.3,9.4c-1.1,2.4-3,4-4.7,5.2c0.4,1.5,0.8,3.3,0.8,3.3
			c0.5,2.1,1,4.2,1.5,6.3c1.2,4.9,2.3,9.5,3.3,14c1.2,5.5,2.2,10.4,3,15.2c1,5.6,1.6,10.5,2.1,15c0.5,5.3,0.7,9.6,0.6,13.6
			c-0.1,2.7-1.6,5.2-4,6.5c-4.6,2.7-20.7,11.5-37.8,15.5l-0.4,0.7c-5.4,8.9-13.2,17.1-22.3,23.7c-9.2,6.6-19.5,11.4-29.9,13.8
			C96.6,233.6,93.2,234,89.7,234z"/>
					<g>
						<path d="M195.2,59.5c0-2.4-1.8-4.5-4.3-4.7c-2.8-0.3-5.8-0.4-9.4-0.4c-2.7,0-5.5,0.1-8.1,0.2c-1,0-1.9,0.1-2.9,0.1
				c-2.8-6.9-5.3-12.8-7.4-17.2c-0.6-1.2-1.2-2.3-2-3.5c-1-1.6-2.2-3.6-2.4-4.8c0-0.2-0.9-4.3-2.2-8.7C154.7,14.8,152.2,9,147,9
				c-0.6,0-1.4,0.1-2.3,0.5c-0.8-1.4-1.5-2.5-2.1-3.6c-0.3-0.5-0.8-0.8-1.4-0.8c-0.1,0-0.2,0-0.4,0L43.1,28.3
				c-0.5,0.1-0.9,0.5-1.1,0.9c-0.4,1.1-0.6,3.4,1.4,5.2c1.8,1.6,27,21.2,28,22c0.1,0.1,0.3,0.2,0.5,0.3c0,1.2,0,2.3,0.2,3.4
				c0.2,1,0.7,1.9,1.5,2.6c-2.4,2.5-4.5,5.2-6.3,8.1c-0.5,0.7-0.9,1.2-1.3,2.2c0,0-0.1,0-0.1,0c-1,0-1.9,0.3-2.7,0.9
				c-4,2.7-7.8,4.6-9,4.9c-1,0.2-1.8,0.7-2.5,1.3c-1.4,1.4-1.8,3.4-1.1,5.2c0.2,0.5,0.5,1,0.9,1.4c0.4,0.4,0.8,0.8,1.3,1.1
				c0.8,0.6,2.3,1.2,4.5,1.5c-1.1,0.8-2.1,1.8-3,2.8c-0.1,0.1-0.2,0.3-0.4,0.5c-12.5-8.9-26.9-13.8-27.5-14l-10.7-3.6
				c-0.2-0.1-0.3-0.1-0.5-0.1c-0.5,0-1,0.2-1.3,0.7c-0.4,0.6-0.4,1.4,0.1,1.9l1,1.2c-1.2-0.1-1.9-0.1-2-0.1c0,0-5.1-0.1-5.1-0.1
				c-0.5,0-1,0.3-1.3,0.7c-0.3,0.5-0.3,1-0.1,1.5L7.6,83l-0.8-0.2c-0.1,0-0.3-0.1-0.4-0.1c-0.5,0-0.9,0.2-1.2,0.6
				c-0.4,0.5-0.5,1.1-0.2,1.7L32,144.7c-2.4,3-3.2,7-2.3,11.3c1.9,9.2,16.3,25,27.3,27.6c1,0.3,2,0.4,3,0.4c2.7,0,4.9-1.1,6.2-3.1
				c0.4-0.7,0.8-1.4,1-2.3c8.7,6.3,19.2,10,29.9,10.7c0.3,0.8,0.7,1.6,1.2,2.2c2,2.7,5,4.2,8.3,4.2c4.7,0,9.2-2.9,11.8-5.9l1.4-0.1
				c1.6-0.1,6.8-0.4,11.5-1.2c0,0.2,0.1,0.4,0.2,0.6c-9.8,12.1-25,20.3-38,20.5c-0.2,0-0.3,0-0.5,0c-7.1,0-12.4-2.5-15.3-7.4
				c-5-8.3-12.2-11.3-17.2-11.3c-1.1,0-2.2,0.1-3.2,0.4c-4.9,1.3-8,5.4-8.2,11.1c-0.2,4.7,3.2,10.2,9.2,15.1
				c6.7,5.5,18.6,11.4,31.6,11.4c3.2,0,6.3-0.4,9.2-1c20.1-4.7,39-18.4,49.5-35.5l1.1-1.8c16.8-3.6,32.9-12.5,37.5-15.1
				c1.4-0.8,2.3-2.3,2.4-3.9c0.1-3.8,0-7.9-0.5-12.9c-0.4-4.4-1.1-9.2-2-14.6c-0.8-4.7-1.8-9.5-2.9-14.8c-1-4.4-2-8.9-3.2-13.7
				c-0.5-2.1-1-4.1-1.5-6.2c0,0-1.1-4.3-1.3-5.2c0.4-0.2,0.8-0.5,1.2-0.8c0,0,0.3-0.2,0.3-0.2c3.3-2.4,5.7-4.8,4-11.3
				c-0.9-3.6-2.6-8.9-4.8-15.4c2.4-0.7,4.7-1.7,6.7-2.8C191.7,70.1,195.2,65.1,195.2,59.5z M149,54c-0.6,0-1.2,0-1.9,0
				c-0.4-0.7-1-1.4-1.7-1.8c-0.7-0.4-1.4-0.9-2.2-1.3c0.1-0.3,0.3-0.5,0.4-0.8c0.9-2.5,0.1-5.6-2.5-10.1c1.7-0.5,3.3-1,4.8-1.4
				L146,39c1.2,5.3,2.4,10.3,3.6,14.9C149.4,54,149.2,54,149,54z"/>
						<path class="st1" d="M95.6,88.7c-1.8,1.6-2.9,3-3.7,4.4c-6.2,1.8-11.3,3.9-15.5,5.8c-0.5-3-1.4-5.3-2.4-7.1
				c4.4-0.6,13.3-4.3,17.5-10c3.2,1.7,6.8,2.6,10.6,2.7c-0.1,0-0.2,0.1-0.2,0.1c0,0,0.1,0,0.1-0.1C99.6,85.6,97.4,87.1,95.6,88.7z"/>
						<path class="st1" d="M84.6,176.6l-1.1-1.5c-2.2-3-4.7-5-6.4-5.3c-0.1,0-0.3,0-0.4,0c-0.4,0-0.8,0.1-1.1,0.3l-1.7,1l-12.3-7.5
				c1.4,2.7,2.5,5,3,6.2c0.1,0.3,0.3,0.6,0.4,1c8.7,8,20,13.1,32.6,13.8c-0.1-1.9,0-3.8,0.1-5.4c0-0.8,0.1-1.5,0.1-2.1
				c0-0.8,0-1.6,0-2.4L84.6,176.6z"/>
						<path class="st2" d="M136.3,190.6c-10.4,13.7-27.6,23.6-42.9,23.8c-9.1,0.1-16.1-3.3-19.9-9.7c-4.3-7.2-10.8-9.9-15.1-8.8
				c-2.9,0.7-4.5,3.1-4.6,6.7c-0.1,3.1,2.7,7.3,7.4,11.2c8.6,7,23.2,12.6,36.7,9.4c19.3-4.6,36.9-17.6,46.5-33.4
				C141.7,190.3,139,190.5,136.3,190.6z"/>
						<path id="Fill-6_1_" sketch:type="MSShapeGroup" class="st1" d="M118.1,163.9c-1.5-5.8-11.2-24.6-18.7-15.7
				c-3.9,4.6-0.6,12.7,0.4,17.8c0.8,3.7,1.1,7.2,1.1,11c0,3.2-1,8.7,1.1,11.5c3.5,4.7,10.7,1,13.3-2.8
				C119.5,179.7,119.8,170.6,118.1,163.9"/>
						<path id="Fill-8_1_" sketch:type="MSShapeGroup" class="st1" d="M35.7,147.6c-1.5,1.9-2,4.5-1.4,7.4c1.5,7.4,14.8,21.8,23.7,24
				c0.7,0.2,1.3,0.2,1.8,0.2c1.4,0,1.9-0.5,2.2-1c1.1-1.7,0.5-5.3-0.4-7.3c-2.5-5.7-10.3-20.5-14.3-23.6c-2-1.5-4.2-2.3-6.2-2.3
				C39,145.1,37.1,146,35.7,147.6"/>
						<path class="st3" d="M174.2,107.8c-3.8,3.5-16.2,14.9-21.4,19.1c-5.5,5-10.7,8.3-15.3,10.3c-1.4,22.8-1.8,43.8-1.8,50.8
				c0.1,0,0.1,0,0.2,0c19.5,0,42.9-13,48.8-16.4C185.4,155.5,179.5,127.8,174.2,107.8z"/>
						<path class="st1" d="M120.2,160.3c0.5,1.2,0.8,2.2,1,2.8c1.5,5.9,1.7,14.8-1.7,21.8c3.8-0.2,9.3-0.7,13.2-1.6
				c0.1-7.1,0.4-20.3,1.1-35.2C129.3,149.7,123.6,153.8,120.2,160.3z"/>
						<path class="st0" d="M91.1,98.9c-0.2-0.6-0.3-1.4-0.3-2.2c-17.9,5.6-26.4,12.7-26.4,12.7C53.8,92.8,24.9,83,24.9,83l4.3,5.1
				c-7.6-4.7-16.3-4.9-16.3-4.9l1.6,3.4c9.1,2.8,25.8,9.9,45,27.8l4.1-3.1l5.8,5c4.7-2.8,14.5-8.1,26.7-12.5
				C93.6,102.8,91.8,101.1,91.1,98.9z"/>
						<path class="st1" d="M104.8,88.6l-1.2-1.4c-2.2,1.1-4.2,2.4-6,3.9c-2.9,2.5-4.2,5-3.5,6.9c0.6,2,3.2,3.5,6.4,3.9
				c2.4,0.2,6.1-0.6,9.9-1.4c0.3-0.1,0.6-0.1,0.9-0.2C108.3,92.9,104.9,88.7,104.8,88.6z"/>
						<path class="st3" d="M173.2,104.5c0,0-4.8-23.4-10.5-27c-8.9-5.7-20.8,7.9-20.8,7.9s-7-2.5-17.4-1.9c-8.2,0.4-17.7,2.6-17.7,2.6
				s16.7,20,11,49.8c0,0,14,5.9,32.9-11.2C156.8,119.6,173.2,104.5,173.2,104.5z"/>
						<path id="Fill-7_1_" sketch:type="MSShapeGroup" class="st2" d="M165.7,59.4c-6.9,0-14.3-1.1-21.1-0.5c4.3,7,15.7,13,23.6,14
				c7.1,0.9,22.3-4.2,22.3-13.4C182.3,58.7,173.9,59.4,165.7,59.4"/>
						<path id="Fill-11_1_" sketch:type="MSShapeGroup" class="st2" d="M55.3,83.4c-0.1,0-0.2,0.1-0.2,0.1c0,0,0.1,0.2,0.4,0.4
				c0.6,0.4,3.1,1.6,9.9-0.2c-0.2-1.6-0.1-3.5,0.6-5.8C62.1,80.5,57.6,82.9,55.3,83.4"/>
						<path class="st1" d="M62.4,101.8c0.9-0.4,1.8-1,2.6-1.8c1.7-1.7,2.5-3.9,2-6c-0.3-1.3-1-2.3-1.9-2.6c-0.1-0.1-0.4-0.1-0.6-0.1
				c-1.6,0-4.6,1.5-6.6,3.8c-0.3,0.4-0.8,1-1.1,1.7C58.9,98.3,60.7,100,62.4,101.8z"/>
						<path class="st3" d="M68.7,90.1c0.7,0.9,1.3,2,1.5,3.2c0.6,3.1-0.4,6.4-2.9,8.9c-0.8,0.8-1.7,1.5-2.7,2c0.2,0.3,0.4,0.5,0.6,0.8
				c1.8-1.2,4.6-2.9,8.2-4.7C72.6,94,69.9,91.1,68.7,90.1z"/>
						<path class="st4" d="M124.3,140C124.3,140,124.3,140,124.3,140c-4.6,0-7.3-1.2-7.6-1.3c-0.4-0.2-0.7-0.4-1-0.7c0,0,0,0,0,0
				c-5.9-5.7-10-25.9-11.3-33.2c-0.6,0.1-1.2,0.1-1.7,0.2c-16,4.9-28.8,12.3-31.6,14L87.6,173l9.9-1.5c-0.2-1.6-0.4-3.2-0.8-4.8
				c-0.2-0.8-0.4-1.8-0.7-2.8c-1.4-5.3-3.3-12.7,0.9-17.7c2.4-2.9,5-3.5,6.8-3.5c6.3,0,11.7,7.7,14.8,13.9c4-6.8,9.8-10,14.2-11.5
				l1.2-0.4c0.1-2.1,0.2-4.3,0.4-6.4C130.4,139.6,127,140,124.3,140z"/>
						<path class="st0" d="M93.4,129.4c1.2,4,4.5,6.7,8.3,7.3L93,125.1C92.8,126.5,92.9,128,93.4,129.4z"/>
						<path class="st0" d="M104.5,120.9c0,0-0.5,0.2-1.1,0.4l6.8,9.7l0-3.1c-0.8-2.2-1.5-4.5-2.2-6.8c-0.6-0.6-1.1-1.1-1.4-1.8
				c-0.2-0.6,0-1.3,0.4-1.8c-0.1-0.3-0.2-0.6-0.2-1c-2-0.7-4.2-0.8-6.4-0.2c-3.5,1-6.1,3.7-7,7c0.2-0.1,0.5-0.1,0.6-0.2
				c1-0.3,2.6-0.9,2.6-0.9c0.5-0.2,0.8,0.6,0.3,0.8c0,0-0.5,0.2-1.1,0.4l6.9,9.8l0.2-7.2l-2.8-3.8c-0.5,0.1-1.1,0.2-1.1,0.2
				c-0.5,0.1-0.7-0.7-0.2-0.8c0,0,1.7-0.4,2.7-0.7c1-0.3,2.6-0.9,2.6-0.9C104.7,119.9,105,120.7,104.5,120.9z"/>
						<path class="st0" d="M103.8,127.3l-0.4,9.6c1,0,2-0.1,3-0.4c1.2-0.3,2.2-0.9,3.2-1.6c0,0-0.1-0.1-0.1-0.1L103.8,127.3z"/>
						<path class="st0" d="M106.8,138.1c2.5-0.7,4.5-2.2,6-4c-0.1-0.2-0.2-0.4-0.3-0.5c-1.4,1.9-3.5,3.3-5.9,4
				c-6.1,1.8-12.6-1.7-14.4-7.8c-1.8-6.1,1.7-12.6,7.9-14.4c2.2-0.6,4.4-0.6,6.4,0c0-0.2-0.1-0.4-0.1-0.6c-2.1-0.5-4.3-0.5-6.4,0.1
				c-6.4,1.9-10.1,8.7-8.2,15.1C93.6,136.3,100.4,140,106.8,138.1z"/>
						<path class="st3" d="M92.7,57c2.3-0.1,31.4-13.5,46-7.9c0,0,4.1-0.9-10.5-18.8c0,0-25.2-6.4-42.2,4.6c0,0-10.8,15.9-9.1,24.4
				C84.4,52.9,90.4,57,92.7,57z"/>
						<path class="st1" d="M179,92.9c-1-4.1-3-10.1-5.4-16.9c-1.2,0.2-2.4,0.3-3.5,0.3c0,0,0,0,0,0c-0.8,0-1.5-0.1-2.2-0.2
				c-0.7-0.1-1.4-0.3-2.2-0.4c1.9,1.7,4.5,5.6,7.6,15.7c1,3.3,1.8,6.4,2.3,8.7c0.3-0.2,0.7-0.4,1-0.6C179.1,97.5,180,97,179,92.9z"/>
						<path class="st3" d="M161.1,44.5c-0.8-1.8-1.6-3.5-2.3-5c-0.6-1.3-1.5-2.8-2.4-4.3c-2.9-0.6-4.9,1.2-5.9,2.2
				c0.4,1.7,1.2,5.3,2.3,9.8C156.1,44,159.7,44.2,161.1,44.5z"/>
						<g>
							<path class="st1" d="M150.3,36.5c0,0.2,0.1,0.5,0.2,0.8c0.9-1,3-2.8,5.9-2.2c-1-1.7-2-3.6-2.3-5.2c0,0-3.9-19.6-8.2-15.8
					c0,0,5.4,8.3,5.7,15.1C151.6,29.3,149.3,32.4,150.3,36.5z"/>
							<path class="st1" d="M161.1,44.5c-1.5-0.3-5-0.5-8.3,2.7c0.6,2.6,1.3,5.5,2.1,8.5c0.9,0,1.8,0.1,2.6,0.1c2.8,0.2,5.5,0.3,8.1,0.3
					c0.1,0,0.2,0,0.4,0C164.4,52,162.7,48,161.1,44.5z"/>
						</g>
						<g>
							<path class="st4" d="M56.6,116.1C36.9,97.8,20,91.4,12,89.2l24.4,53.9c1.4-0.7,3-1.1,4.7-1.1c2.8,0,5.6,1,8.2,3
					c2.6,2,6.2,7.6,9.3,13.1l12.9,7.9L56.6,116.1z"/>
							<path class="st4" d="M67.6,119.1l-4.2-3.7l-3,2.2l14.7,49.2c0.8-0.2,1.6-0.3,2.5-0.2c2.2,0.3,4.3,1.9,5.9,3.6L67.6,119.1z"/>
						</g>
						<path class="st0" d="M111.1,130.4l-0.1,3.2c0.4-0.4,0.7-0.8,1-1.3C111.7,131.7,111.4,131.1,111.1,130.4z"/>
						<path class="st1" d="M141.9,60.5c-0.6-0.9-0.6-2.1-0.1-3.1c0.3-0.5,0.7-0.9,1.1-1.2c-3.9-2.4-8.1-4.2-12.6-5.3c-0.1,0-0.1,0-0.2,0
				c-10.8,0-24.9,5.1-31.7,7.6c-3.7,1.3-4.7,1.7-5.6,1.7l-0.1,0c-1,0-1.9-0.2-2.9-0.5c-1.2-0.3-2.6-0.7-4.1-0.7c0,0,0,0,0,0
				c-5.7,4-10.6,8.6-14.2,14.4c-1,1.5-1.7,3-2.2,4.4c0,0.3,0,0.6-0.1,0.9c-0.5,1.6-0.6,3.2-0.5,4.5c0,0.3,0,0.5,0,0.8
				c0,0.2,0.1,0.3,0.1,0.5c0.7,2.2,2.2,3.6,3.4,4.1c1.9,0.8,14-3.4,17.5-9.7c0.2-0.4,0.5-0.6,0.9-0.7c0.4-0.1,0.8,0,1.2,0.2
				c8.3,5.1,17.6,2.8,25.6,0.2c0.8-0.3,1.6,0.2,1.9,1c0.1,0.4,0.1,0.9-0.1,1.2c0.4,0,0.8,0,1.3,0c1.3-0.2,2.7-0.3,4-0.4
				c1.1-0.1,2.2-0.1,3.3-0.1c6.1,0,10.8,0.9,13.3,1.6c2.8-2.8,9.4-8.6,16.4-8.8C151.2,70.1,145,65.7,141.9,60.5z"/>
						<ellipse class="left-eye" cx="113" cy="64" rx="3" ry="3" />
						<ellipse class="right-eye" cx="78" cy="72" rx="3" ry="3" />
						<path d="M94.7,73.8c-2.5,1.9-2.7,1.7-5.4,1.3c-2.7-0.3-3.4-2.6-1-4.4c1.3-1,3.4-1.7,6.4-2C97.7,68.5,97.3,71.8,94.7,73.8z"/>
					</g>
				</g>
			</svg>
		</a>
	</div><!-- #eduwapuu-wrapper -->
	<?php
}
