<?php

// Include filters.
require_once( STYLESHEETPATH . '/includes/filters.php' );

// Include data functionality.
require_once( STYLESHEETPATH . '/includes/data.php' );

// Include university functionality.
require_once( STYLESHEETPATH . '/includes/universities.php' );

// Include shortcodes.
require_once( STYLESHEETPATH . '/includes/shortcodes.php' );

/**
 * Setup the API.
 */
function wpcampus_setup_api() {
	global $wpcampus_api_data;

	// Load the class.
	require_once( STYLESHEETPATH . '/includes/class-api-data.php' );

	// Initialize our class.
	$wpcampus_api_data = new WPCampus_API_Data();

	// Register our routes.
	$wpcampus_api_data->register_routes();

}
add_action( 'rest_api_init', 'wpcampus_setup_api' );

/**
 * Setup the theme:
 *
 * - Load the textdomain.
 * - Register the navigation menus.
 */
function wpcampus_setup_theme() {

	// Load the textdomain.
	load_theme_textdomain( 'wpcampus', get_stylesheet_directory() . '/languages' );

	// Register the nav menus.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'wpcampus' ),
	));
}
add_action( 'after_setup_theme', 'wpcampus_setup_theme' );

/**
 * Setup styles and scripts.
 */
function wpcampus_enqueue_styles_scripts() {
	$wpcampus_version = '0.58';

	// Get the directory.
	$wpcampus_dir = trailingslashit( get_stylesheet_directory_uri() );

	// Load fonts.
	wp_enqueue_style( 'wpcampus-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:600,400,300' );

	// Enqueue the base styles.
	wp_enqueue_style( 'wpcampus', $wpcampus_dir . 'assets/css/styles.min.css', array( 'wpcampus-fonts' ), $wpcampus_version, 'all' );

	// Enqueue modernizr - goes in header.
	wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js' );

	// Enqueue the main script file - goes in footer.
	wp_enqueue_script( 'wpcampus', $wpcampus_dir . 'assets/js/wpcampus.min.js', array( 'jquery', 'modernizr' ), $wpcampus_version, true );

	// Enqueue the application styles.
	if ( is_page( 'apply-to-host' ) ) {
		wp_enqueue_style( 'wpcampus-host-application', $wpcampus_dir . 'assets/css/application.css', array(), $wpcampus_version, 'all' );
	}

	// Enqueue the data scripts.
	if ( is_page( 'data' ) ) {

		// Register Google Charts script.
		wp_register_script( 'google-charts', 'https://www.google.com/jsapi', array('jquery' ) );

		// Register Chartist script.
		wp_register_script( 'chartist', 'https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js' );

		// Enqueue Chartist styles.
		wp_enqueue_style( 'chartist', $wpcampus_dir . 'assets/css/chartist.min.css', array(), $wpcampus_version, 'all' );

		/*
		 * Enqueue our data script.
		 *
		 * Set a var so that we can automatically
		 * use the non-minified script on staging,
		 * but the minified script on prod.
		 */
		$min = stristr( $_SERVER['HTTP_HOST'], '.staging' ) ? '' : '.min';
		wp_enqueue_script( 'wpcampus-data', $wpcampus_dir . 'assets/js/wpcampus-data' . $min . '.js', array('jquery', 'google-charts', 'chartist'), $wpcampus_version, false );

	}

	// Enqueue the events styles.
	if ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
		wp_enqueue_style( 'wpcampus-events', $wpcampus_dir . 'assets/css/tribe-events.min.css', array( 'wpcampus' ), $wpcampus_version, 'all' );
	}
}
add_action( 'wp_enqueue_scripts', 'wpcampus_enqueue_styles_scripts' );

/**
 * Add the AddThis script to the footer.
 */
function wpcampus_add_addthis() {
	?>
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55c7ed90ac8a8479" async="async"></script>
	<?php
}
add_action( 'wp_footer', 'wpcampus_add_addthis' );

/**
 * Load favicons.
 */
function wpcampus_add_favicons() {

    // Set the images folder.
    $favicons_folder = get_stylesheet_directory_uri() . '/assets/images/favicons/';

    // Print the default icons.
    ?>
    <link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/>
    <link rel="apple-touch-icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/><?php

    // Set the image sizes.
    $image_sizes = array( 57, 72, 76, 114, 120, 144, 152 );

    foreach( $image_sizes as $size ) :
        ?>
	    <link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png"/>
	    <?php
    endforeach;
}
add_action( 'wp_head', 'wpcampus_add_favicons' );
add_action( 'admin_head', 'wpcampus_add_favicons' );
add_action( 'login_head', 'wpcampus_add_favicons' );

/**
 * Get the post type archive title.
 */
function wpcampus_get_post_type_archive_title( $post_type = '' ) {

    // Make sure we have a post type.
    if ( ! $post_type ) {
        $post_type = get_query_var( 'post_type' );
    }

    // Get post type archive title.
    if ( $post_type ) {

        // Make sure its not an array.
        if ( is_array( $post_type ) ) {
            $post_type = reset( $post_type );
        }

        // Get the post type data.
        if ( $post_type_obj = get_post_type_object( $post_type ) ) {

            // Get the title.
            $title = apply_filters( 'post_type_archive_title', $post_type_obj->labels->name, $post_type );

            // Return the title.
            return apply_filters( 'wpcampus_post_type_archive_title', $title, $post_type );
        }
    }
    return null;
}

/**
 * Get breadcrumbs markup.
 */
function wpcampus_get_breadcrumbs_html() {

	// Build array of breadcrumbs.
	$breadcrumbs = array();

    // Not for front page.
    if ( is_front_page() ) {
        return false;
    }

    // Get post type.
    $post_type = get_query_var( 'post_type' );

    // Make sure its not an array.
    if ( is_array( $post_type ) ) {
        $post_type = reset( $post_type );
    }

    // Add home.
    $breadcrumbs[] = array(
        'url'   => get_bloginfo( 'url' ),
        'label' => 'Home',
    );

    // Add archive(s).
    if ( is_archive() ) {

        // Add the archive breadcrumb.
        if ( is_post_type_archive() ) {

            // Get the info.
            $post_type_archive_link = get_post_type_archive_link( $post_type );
            $post_type_archive_title = wpcampus_get_post_type_archive_title( $post_type );

            // Add the breadcrumb.
            if ( $post_type_archive_link && $post_type_archive_title ) {
                $breadcrumbs[] = array( 'url' => $post_type_archive_link, 'label' => $post_type_archive_title );
            }
        }
    } else {

        // Add links to archive.
        if ( is_singular() ) {

            // Get the information
            $post_type_archive_link = get_post_type_archive_link( $post_type );
            $post_type_archive_title = wpcampus_get_post_type_archive_title( $post_type );

            if ( $post_type_archive_link ) {
                $breadcrumbs[] = array( 'url' => $post_type_archive_link, 'label' => $post_type_archive_title );
            }
        }

        // Print info for the current post.
        if ( ( $post = get_queried_object() ) && is_a( $post, 'WP_Post' ) ) {

            // Get ancestors.
            $post_ancestors = isset( $post ) ? get_post_ancestors( $post->ID ) : array();

            // Add the ancestors.
            foreach ( $post_ancestors as $post_ancestor_id ) {

                // Add ancestor.
                $breadcrumbs[] = array( 'ID' => $post_ancestor_id, 'url' => get_permalink( $post_ancestor_id ), 'label' => get_the_title( $post_ancestor_id ), );

            }

            // Add current page - if not home page.
            if ( isset( $post ) ) {
                $breadcrumbs[ 'current' ] = array( 'ID' => $post->ID, 'url' => get_permalink( $post ), 'label' => get_the_title( $post->ID ), );
            }
        }
    }

	// Build breadcrumbs HTML.
	$breadcrumbs_html = null;

	foreach( $breadcrumbs as $crumb_key => $crumb ) {

		// Make sure we have what we need.
		if ( empty( $crumb[ 'label' ] ) ) {
			continue;
		}

		// If no string crumb key, set as ancestor.
		if ( ! $crumb_key || is_numeric( $crumb_key ) ) {
			$crumb_key = 'ancestor';
		}

		// Setup classes.
		$crumb_classes = array( $crumb_key );

		// Add if current.
		if ( isset( $crumb[ 'current' ] ) && $crumb[ 'current' ] ) {
			$crumb_classes[] = 'current';
		}

		$breadcrumbs_html .= '<li role="menuitem"' . ( ! empty( $crumb_classes ) ? ' class="' . implode( ' ', $crumb_classes ) . '"' : null ) . '>';

		// Add URL and label.
		if ( ! empty( $crumb[ 'url' ] ) ) {
			$breadcrumbs_html .= '<a href="' . $crumb[ 'url' ] . '"' . ( ! empty( $crumb[ 'title' ] ) ? ' title="' . $crumb[ 'title' ] . '"' : null ) . '>' . $crumb[ 'label' ] . '</a>';
		} else {
			$breadcrumbs_html .= $crumb[ 'label' ];
		}

		$breadcrumbs_html .= '</li>';
	}

    // Wrap them in nav.
	$breadcrumbs_html = '<div class="breadcrumbs-wrapper"><nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">' . $breadcrumbs_html . '</nav></div>';

	//  We change up the variable so it doesn't interfere with global variable.
	return $breadcrumbs_html;
}