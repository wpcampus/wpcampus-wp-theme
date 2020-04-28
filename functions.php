<?php

$includes_path = STYLESHEETPATH . '/includes/';

// Include filters.
require_once( $includes_path . 'filters.php' );

// Include data functionality.
require_once( $includes_path . 'data.php' );

// Include university functionality.
require_once( $includes_path . 'universities.php' );

// Include shortcodes.
require_once( $includes_path . 'shortcodes.php' );

/**
 * Decide which main callout to print.
 */
function wpcampus_print_main_callout() {
	if ( function_exists( 'wpcampus_print_network_callout' ) ) {
		wpcampus_print_network_callout();
	}
}

/**
 * Print the 2018 callout.
 */
function wpcampus_print_2018_callout() {
	?>
	<div class="panel" style="text-align:center;">
		<h2>WPCampus Online set for January 31, 2019</h2>
		<p>Join us January 31 for the third annual <a href="https://online.wpcampus.org/">WPCampus Online</a>, a full day of free, virtual sessions focused on WordPress, higher education, and accessibility. Join us January 7 or 10 for <a href="https://wpcampus.org/resources/speaker-training/">free speaker training</a>.</p>
		<a class="button expand" style="text-decoration:underline;" href="https://online.wpcampus.org/"><strong>Visit the WPCampus Online website</strong></a>
	</div>
	<?php
}

/**
 * Prints a main callout highlighting online.
 */
function wpcampus_print_watch_online_callout() {
	?>
	<div class="panel" style="text-align:center;">
		<a class="button bigger expand" style="font-size:1.5rem;text-decoration:underline;" href="https://online.wpcampus.org/watch/"><strong>Watch WPCampus Online</strong></a>
	</div>
	<?php
}

/**
 * Prints a main callout highlighting our events.
 */
function wpcampus_print_events_callout() {
	?>
	<div class="panel" style="text-align:center;">
		<p><strong>WPCampus currently hosts one in-person and one virtual conference each year.</strong><br/>We just wrapped <a href="https://online.wpcampus.org/">WPCampus Online 2018</a>. The session recordings are being uploaded. You can <a href="https://online.wpcampus.org/schedule/">view them on the schedule</a>. Our next event will be WPCampus 2018 (in-person). Dates and location to be announced soon.</p>
		<a class="button expand" style="text-decoration:underline;" href="/conferences/"><strong>Learn more about our conferences</strong></a>
	</div>
	<?php
}

/**
 * Print the "Apply to host" callout.
 */
function wpcampus_print_apply_host_callout() {
	?>
	<div class="panel" style="margin-top:0;text-align:center;">
		<h2 style="line-height:1.3;">Apply to host WPCampus 2019</h2>
		<p>WPCampus is looking for the host for our 2019 conference. If you’d be willing to help plan and host an event, we’d love to bring our community to your campus. It’s a great opportunity to invest in higher education and education technology. <strong>The application is open until Friday, February 15, 2019.</strong></p>
		<a class="button expand" style="text-decoration:underline;" href="/conferences/apply-to-host/"><strong>Apply to host the WPCampus 2019 conference</strong></a>
	</div>
	<?php
}

/**
 * Print the "WPC Online call for speakers" callout.
 */
function wpcampus_print_online_speakers_callout() {
	?>
	<div class="panel" style="text-align:center;">
		<h2 style="line-height:1.3;">Call for speakers for WPCampus Online</h2>
		<p>Our <strong><a href="https://online.wpcampus.org/call-for-speakers/">call for speakers</a></strong> is open for WPCampus Online 2018 and we'd love to hear from you. Share your stories and expertise from your living room! <strong>The call will close at 12 midnight PST on Friday, November 10, 2017.</strong></p>
		<a class="button expand" style="text-decoration:underline;" href="https://online.wpcampus.org/call-for-speakers/"><strong>Apply to speak at WPCampus Online</strong></a>
	</div>
	<?php
}

/**
 * Print the 2017 callout.
 */
function wpcampus_print_2017_callout() {
	?>
	<div class="panel" style="text-align:center;">
		<h2>WPCampus 2017 Conference on July 14-15</h2>
		<p><a href="https://2017.wpcampus.org/" style="color:inherit;">WPCampus 2017</a> will take place July 14-15 on the campus of Canisius College in Buffalo, New York. <strong>Ticket sales have closed</strong> but, if you can't join us in person, all sessions will be live-streamed and made available online after the event. Gather with other WordPress users on your campus and create your own WPCampus experience!</p>
		<a class="button expand" href="https://2017.wpcampus.org/">Visit the WPCampus 2017 website</a>
	</div>
	<?php
}

/**
 * Print the ed survey callout.
 */
function wpcampus_print_ed_survey_callout() {
	?>
	<div class="panel" style="text-align:center;">
		<h2>The "WordPress in Education" Survey</h2>
		<p>After an overwhelming response to our 2016 survey, WPCampus is back this year to dig a little deeper on key topics that schools and campuses care about most when it comes to WordPress and website development. We’d love to include your feedback in our results this year. The larger the data set, the more we all benefit. <strong>The survey will close on June 23rd, 2017.</strong></p>
		<a class="button expand" href="https://2017.wpcampus.org/announcements/wordpress-in-education-survey/">Take the "WordPress in Education" survey</a>
	</div>
	<?php
}

/**
 * Setup the theme:
 * - Load the textdomain.
 * - Register the navigation menus.
 */
function wpcampus_setup_theme() {

	// Load the textdomain.
	load_theme_textdomain( 'wpcampus', get_stylesheet_directory() . '/languages' );

	// Enable network components.
	if ( function_exists( 'wpcampus_network_enable' ) ) {
		wpcampus_network_enable( array( 'banner', 'notifications', 'coc', 'footer' ) );
	}

	// Register the nav menus.
	register_nav_menus(
		array(
			'primary' => __( 'Primary Menu', 'wpcampus' ),
		)
	);

	// Add HTML5 support.
	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	add_theme_support( 'post-thumbnails' );

	if ( is_archive() ) {

		// Add article meta after header.
		add_action( 'wpcampus_after_article_header', 'wpcampus_print_article_meta', 5 );
	}
}

add_action( 'after_setup_theme', 'wpcampus_setup_theme', 1 );

/**
 * Load files depending on page,
 * After WP object is set up.
 */
function wpcampus_load_files() {

	// Include comments.
	if ( is_singular() ) {
		require_once( STYLESHEETPATH . '/includes/comments.php' );
	}
}

add_action( 'wp', 'wpcampus_load_files' );

/**
 * Register the category taxonomy
 * to the podcast.
 */
function wpcampus_add_category_to_podcast() {
	register_taxonomy_for_object_type( 'category', 'podcast' );
}

add_action( 'wp_loaded', 'wpcampus_add_category_to_podcast' );

/**
 * Make sure the Open Sans
 * font weights we need are added.
 */
function wpcampus_load_open_sans_weights( $weights ) {
	return array_merge( $weights, array( 300, 400, 600 ) );
}

add_filter( 'wpcampus_open_sans_font_weights', 'wpcampus_load_open_sans_weights' );

/**
 * Setup styles and scripts.
 */
function wpcampus_enqueue_styles_scripts() {
	$wpcampus_version = '2.5';

	// Get the directory.
	$wpcampus_dir = trailingslashit( get_stylesheet_directory_uri() );

	// Enqueue the base styles.
	// wpc-fonts-open-sans is registered in the network plugin.
	wp_enqueue_style( 'wpcampus', $wpcampus_dir . 'assets/css/styles.min.css', array( 'wpc-fonts-open-sans' ), $wpcampus_version, 'all' );

	// Enqueue modernizr - goes in header.
	wp_enqueue_script( 'modernizr', 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js' );

	// Enqueue the main script file - goes in footer.
	wp_enqueue_script( 'wpcampus', $wpcampus_dir . 'assets/js/wpcampus.min.js', array( 'jquery', 'modernizr', 'wpc-network-toggle-menu' ), $wpcampus_version, true );

	// Enqueue the application styles.
	if ( is_page( 'conferences/apply-to-host' ) ) {
		wp_enqueue_style( 'wpcampus-host-application', $wpcampus_dir . 'assets/css/application.css', array(), $wpcampus_version, 'all' );
	}

	// Enqueue the data scripts.
	if ( is_page( 'data' ) ) {

		// Register Google Charts script.
		wp_register_script( 'google-charts', 'https://www.google.com/jsapi', array( 'jquery' ) );

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
		wp_enqueue_script( 'wpcampus-data', $wpcampus_dir . 'assets/js/wpcampus-data' . $min . '.js', array( 'jquery', 'google-charts', 'chartist' ), $wpcampus_version, false );

	}

	// Enqueue the events styles.
	if ( is_post_type_archive( 'tribe_events' ) || is_singular( 'tribe_events' ) ) {
		wp_enqueue_style( 'wpcampus-events', $wpcampus_dir . 'assets/css/tribe-events.min.css', array( 'wpcampus' ), $wpcampus_version, 'all' );
	}
}

add_action( 'wp_enqueue_scripts', 'wpcampus_enqueue_styles_scripts', 11 );

/**
 * Load favicons.
 */
function wpcampus_add_favicons() {

	// Set the images folder.
	$favicons_folder = get_template_directory_uri() . '/assets/images/favicons/';

	?>
	<link rel="shortcut icon" href="<?php echo $favicons_folder; ?>wpcampus-favicon-60.png"/>
	<?php

	// Set the Apple image sizes.
	$apple_image_sizes = array( 57, 60, 72, 76, 114, 120, 144, 152, 180 );
	foreach ( $apple_image_sizes as $size ) :
		?>
		<link rel="apple-touch-icon" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png">
	<?php
	endforeach;

	// Set the Android image sizes.
	$android_image_sizes = array( 16, 32, 96, 192 );
	foreach ( $android_image_sizes as $size ) :

		?>
		<link rel="icon" type="image/png" sizes="<?php echo "{$size}x{$size}"; ?>" href="<?php echo $favicons_folder; ?>wpcampus-favicon-<?php echo $size; ?>.png">
	<?php

	endforeach;

	?>
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="<?php echo $favicons_folder; ?>wpcampus-favicon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<?php
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
 * Print the articles.
 * @param array $args
 */
function wpcampus_print_articles( $args = array(), $show_pagination = true, $query = null ) {
	global $wp_query;

	// Use default query if none was passed.
	if ( ! $query || ! is_a( $query, 'WP_Query' ) ) {
		$query = $wp_query;
	}

	$pagination = ! $show_pagination ? null : paginate_links(
		array(
			//'base'  => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'  => '?paged=%#%',
			'current' => max( 1, get_query_var( 'paged' ) ),
			'total'   => $query->max_num_pages,
		)
	);

	if ( ! empty( $pagination ) ) {
		$pagination = '<nav class="wpc-pagination">' . $pagination . '</nav>';
	}

	echo $pagination;

	do_action( 'wpcampus_before_articles' );

	$article_css = array( 'wpcampus-articles' );

	$post_types = get_query_var( 'post_type' );
	if ( ! empty( $post_types ) ) {

		if ( ! is_array( $post_types ) ) {
			$post_types = explode( ',', $post_types );
		}

		foreach ( $post_types as $post_type ) {
			$article_css[] = "post-{$post_type}";
		}
	}

	?>
	<div class="<?php echo implode( ' ', $article_css ); ?>">
		<?php

		while ( $query->have_posts() ) :
			$query->the_post();

			wpcampus_print_article( $args );

		endwhile;

		?>
	</div><!--.wpcampus-articles-->
	<?php

	do_action( 'wpcampus_after_articles' );

	echo $pagination;
}

/**
 * Print the article.
 * @param array $args
 */
function wpcampus_print_article( $args = array() ) {

	// Define the defaults.
	$defaults = array(
		'header'        => false,
		'link_to_post'  => true,
		'print_content' => true,
	);

	// Merge incoming with defaults.
	$args = wp_parse_args( $args, $defaults );

	// Get post information.
	$post_id        = get_the_ID();
	$post_permalink = get_permalink( $post_id );

	do_action( 'wpcampus_before_article' );

	?>
<article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
	<?php

	// Should we add a header?
	if ( ! empty( $args['header'] ) ) :

		do_action( 'wpcampus_before_article_header' );

		?>
		<<?php echo $args['header']; ?> class="article-title"><?php

		if ( $args['link_to_post'] ) {
			?><a href="<?php echo $post_permalink; ?>"><?php the_title(); ?></a><?php
		} else {
			the_title();
		}

		?></<?php echo $args['header']; ?>>
		<?php

		do_action( 'wpcampus_after_article_header' );

	endif;

	if ( $args['print_content'] ) {

		do_action( 'wpcampus_before_article_content' );

		the_content();

		do_action( 'wpcampus_after_article_content' );

	} else {

		do_action( 'wpcampus_before_article_excerpt' );

		the_excerpt();

		do_action( 'wpcampus_after_article_excerpt' );

	}

	?>
	</article>
	<?php

	do_action( 'wpcampus_after_article' );

}

/**
 * Print article meta.
 */
function wpcampus_print_article_meta() {

	// Get categories.
	$categories = get_the_category_list( ', ' );

	// Get permalink.
	$comments_link = get_permalink() . '#comments';

	?>
	<div class="article-meta-wrapper">
		<span class="article-meta article-time"><?php wpcampus_print_article_time(); ?></span>
		<?php

		// Print authors.
		$authors = wpcampus_get_article_authors();
		if ( ! empty( $authors ) ) :
			?><span class="article-meta article-author"><?php echo $authors; ?></span><?php
		endif;

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( post_type_supports( get_post_type(), 'comments' ) && comments_open() ) :

			// Get # of comments.
			$comments_number = get_comments_number();

			// Build comment classes.
			$comment_classes = array( 'article-meta', 'article-comments' );

			if ( $comments_number ) {
				$comment_classes[] = 'has-comments';
			}

			?>
			<span class="<?php echo implode( ' ', $comment_classes ); ?>">
				<a href="<?php echo $comments_link; ?>"><?php

					if ( ! $comments_number ) {
						echo __( 'Leave a comment', 'wpcampus' );
					} else {
						printf( _n( '%s comment', '%s comments', $comments_number, 'wpcampus' ), $comments_number );
					}

					?></a>
			</span>
		<?php

		endif;

		if ( $categories ) :
			?>
			<span class="article-meta article-categories"><?php echo $categories; ?></span>
		<?php
		endif;

		?>
	</div>
	<?php

}

/**
 * Get the article author(s).
 */
function wpcampus_get_article_authors( $post_id = 0 ) {

	if ( function_exists( 'my_multi_author' ) && method_exists( my_multi_author(), 'get_the_authors_list' ) ) {
		return my_multi_author()->get_the_authors_list( $post_id );
	}

	return '<a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a>';
}

/**
 * Print the article time.
 */
function wpcampus_print_article_time() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	echo sprintf(
		$time_string,
		get_the_date( DATE_W3C ),
		get_the_date()
	);
}

/**
 * Print breadcrumbs.
 */
function wpcampus_print_breadcrumbs() {
	echo wpcampus_get_breadcrumbs_html();
}

/**
 * Get breadcrumbs list.
 */
function wpcampus_get_breadcrumbs() {

	// Build array of breadcrumbs.
	$breadcrumbs = array();

	// Not for front page or 404.
	if ( is_front_page() || is_404() ) {
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
			$post_type_archive_link  = get_post_type_archive_link( $post_type );
			$post_type_archive_title = wpcampus_get_post_type_archive_title( $post_type );

			// Add the breadcrumb.
			if ( $post_type_archive_link && $post_type_archive_title ) {
				$breadcrumbs[] = array( 'url' => $post_type_archive_link, 'label' => $post_type_archive_title );
			}
		} elseif ( is_author() ) {

			// Add crumb to contributors page.
			$breadcrumbs[] = array(
				'url'   => '/contributors/',
				'label' => __( 'Contributors', 'wpcampus' ),
			);

			// Add crumb to current contributor's page.
			$author = get_queried_object();
			if ( ! empty( $author->ID ) ) {
				$breadcrumbs['current'] = array(
					'url'   => get_author_posts_url( $author->ID ),
					'label' => get_the_author_meta( 'display_name', $author->ID ),
				);
			}
		} else {

			$breadcrumbs[] = array(
				'url'   => '/blog/',
				'label' => __( 'Blog', 'wpcampus' ),
			);
		}
	} else {

		/*
		 * Add links to main blog
		 * or to post type archive.
		 */
		if ( is_singular( 'post' ) ) {
			$breadcrumbs[] = array(
				'url'   => '/blog/',
				'label' => __( 'Blog', 'wpcampus' ),
			);
		} elseif ( is_singular() ) {

			// Get the information.
			$post_type_archive_link  = get_post_type_archive_link( $post_type );
			$post_type_archive_title = wpcampus_get_post_type_archive_title( $post_type );

			if ( $post_type_archive_link ) {
				$breadcrumbs[] = array(
					'url'   => $post_type_archive_link,
					'label' => $post_type_archive_title,
				);
			}
		}

		// Print info for the current post.
		$post = get_queried_object();
		if ( $post && is_a( $post, 'WP_Post' ) ) {

			// Get ancestors.
			$post_ancestors = isset( $post ) ? get_post_ancestors( $post->ID ) : array();

			$post_ancestor_crumbs = [];

			// Add the ancestors.
			foreach ( $post_ancestors as $post_ancestor_id ) {

				// Add ancestor.
				$post_ancestor_crumbs[] = array(
					'ID'    => $post_ancestor_id,
					'url'   => get_permalink( $post_ancestor_id ),
					'label' => get_the_title( $post_ancestor_id ),
				);
			}

			if ( ! empty( $post_ancestor_crumbs ) ) {
				$post_ancestor_crumbs = array_reverse( $post_ancestor_crumbs );
				$breadcrumbs          = array_merge( $breadcrumbs, $post_ancestor_crumbs );
			}

			// Add current page - if not singular post.
			if ( isset( $post ) && ! is_singular( array( 'post', 'podcast', 'video' ) ) ) {
				$breadcrumbs['current'] = array(
					'ID'    => $post->ID,
					'url'   => get_permalink( $post ),
					'label' => get_the_title( $post->ID ),
				);
			}
		}
	}

	return apply_filters( 'wpcampus_breadcrumbs', $breadcrumbs );
}

/**
 * Get breadcrumbs markup.
 */
function wpcampus_get_breadcrumbs_html() {

	// Get the breadcrumbs.
	$breadcrumbs = wpcampus_get_breadcrumbs();

	// Make sure we have crumbs.
	if ( empty( $breadcrumbs ) ) {
		return '';
	}

	// Build breadcrumbs HTML.
	$breadcrumbs_html = null;

	foreach ( $breadcrumbs as $crumb_key => $crumb ) {

		// Make sure we have what we need.
		if ( empty( $crumb['label'] ) ) {
			continue;
		}

		// If no string crumb key, set as ancestor.
		if ( ! $crumb_key || is_numeric( $crumb_key ) ) {
			$crumb_key = 'ancestor';
		}

		// Setup classes.
		$crumb_classes = array( $crumb_key );

		// Add if current.
		if ( isset( $crumb['current'] ) && $crumb['current'] ) {
			$crumb_classes[] = 'current';
		}

		$breadcrumbs_html .= '<li' . ( ! empty( $crumb_classes ) ? ' class="' . implode( ' ', $crumb_classes ) . '"' : null ) . '>';

		// Add URL and label.
		if ( ! empty( $crumb['url'] ) ) {
			$breadcrumbs_html .= '<a href="' . $crumb['url'] . '"' . ( ! empty( $crumb['title'] ) ? ' title="' . $crumb['title'] . '"' : null ) . '>' . $crumb['label'] . '</a>';
		} else {
			$breadcrumbs_html .= $crumb['label'];
		}

		$breadcrumbs_html .= '</li>';
	}

	// Wrap them in nav.
	if ( ! empty( $breadcrumbs_html ) ) {
		$breadcrumbs_html = '<div class="breadcrumbs-wrapper">
		<nav class="breadcrumbs" aria-label="breadcrumbs"><ul>' . $breadcrumbs_html . '</ul></nav>
	</div>';
	}

	return $breadcrumbs_html;
}

/**
 * Print the 404 page.
 */
function wpcampus_print_404() {

	do_action( 'wpcampus_before_404' );

	?>
	<p>Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.</p><p>If you can't find what you're looking for in the menu, please <a href="/contact/">reach out to us</a> and let us know. We'd be happy to help.</p>
	<?php

	do_action( 'wpcampus_after_404' );

}

/**
 * Print a specific contributor's profile.
 */
function wpcampus_print_contributor( $user_id = 0, $display = true ) {

	// Make sure we have a user ID.
	if ( ! $user_id && is_singular() ) {
		$user_id = get_the_author_meta( 'ID' );
	}

	if ( empty( $user_id ) ) {
		return '';
	}

	// Get display name
	$author_name = get_the_author_meta( 'display_name', $user_id );

	// Get thumbnail.
	$author_thumbnail = get_avatar_url(
		$user_id,
		array(
			'size' => '200',
		)
	);

	// Get other fields.
	$author_desc        = get_the_author_meta( 'description', $user_id );
	$author_website     = get_the_author_meta( 'url', $user_id );
	$author_twitter     = get_the_author_meta( 'twitter', $user_id );
	$author_company     = get_the_author_meta( 'company', $user_id );
	$author_company_pos = get_the_author_meta( 'company_position', $user_id );

	if ( ! $display ) {
		ob_start();
	}

	?>
	<div class="wpcampus-contributor<?php echo $author_thumbnail ? ' has-thumbnail' : ''; ?>">
		<div class="inside">
			<h2 class="contributor-name"><?php

				if ( ! is_author() ) :
					?>
					<a href="<?php echo esc_url( get_author_posts_url( $user_id ) ); ?>"><?php echo $author_name; ?></a>
				<?php
				else :
					echo $author_name;
				endif;

				?></h2>
			<?php

			// Display author thumbnail.
			if ( ! empty( $author_thumbnail ) ) :
				?>
				<img class="author-thumbnail" src="<?php echo $author_thumbnail; ?>" alt=""/>
			<?php
			endif;

			// Build meta.
			$contributor_meta = array();

			// Add company.
			if ( $author_company ) {
				if ( $author_company_pos ) {
					$contributor_meta['company'] = "{$author_company_pos}, {$author_company}";
				} else {
					$contributor_meta['company'] = $author_company;
				}
			} elseif ( $author_company_pos ) {
				$contributor_meta['company'] = $author_company_pos;
			}

			// Add Twitter.
			if ( $author_twitter ) {

				// Sanitize Twitter handle.
				$author_twitter_handle       = preg_replace( '/[^a-z0-9\_]/i', '', $author_twitter );
				$contributor_meta['twitter'] = '<a href="' . esc_url( 'https://twitter.com/' . $author_twitter_handle ) . '">@' . $author_twitter_handle . '</a>';
			}

			// Add website.
			if ( $author_website ) {
				$contributor_meta['website'] = '<a href="' . esc_url( $author_website ) . '">' . $author_website . '</a>';
			}

			// Display meta
			if ( ! empty( $contributor_meta ) ) :
				?>
				<div class="contributor-meta-wrapper">
					<?php

					foreach ( $contributor_meta as $meta ) :
						?><span class="contributor-meta"><?php echo $meta; ?></span><?php
					endforeach;

					?>
				</div>
			<?php
			endif;

			// Display author bio.
			if ( ! empty( $author_desc ) ) :
				?>
				<p class="contributor-desc"><?php echo $author_desc; ?></p>
			<?php
			endif;

			?>
		</div>
	</div>
	<?php

	if ( ! $display ) {
		return ob_get_clean();
	}
}

/**
 * Print podcast links.
 */
function wpcampus_print_podcast_links() {
	?>
	<div class="wpcampus-podcast-links">
		<ul class="button-group">
			<li><a href="https://open.spotify.com/show/0ULgPfGeMdkZYoRxkOJcMq?si=5_VGrpbnTd2CJIAx8yPWcQ" class="button" title="Listen on Spotify">Spotify</a></li>
			<li><a href="https://itun.es/i6YF9HH" class="button" title="Listen on iTunes">iTunes</a></li>
			<li><a href="https://play.google.com/music/listen?u=0#/ps/Imipnlywvba5v3lqu7y646dg6z4" class="button" title="Listen on Google Play">Google Play</a></li>
			<li><a href="/feed/podcast" class="button">RSS feed</a></li>
		</ul>
	</div>
	<?php
}

/**
 * Print podcast promo.
 */
function wpcampus_print_podcast_promo() {

	?>
	<div class="wpcampus-podcast-promo">
		<div class="panel">
			<p>The WPCampus Podcast is a recurring show where members of the community come together to discuss relevant topics, unique ways that WordPress is being used in higher education, share tutorials and walkthroughs, and more. <strong><em>If you'd like to be a guest on the show, or have a topic you'd like us to discuss, please <a href="/contact/">let us know</a>.</em></strong></p>
		</div>
		<?php

		/*<div class="panel dark-blue center" style="margin-bottom:20px;">New episodes of <a href="/podcast/">The WPCampus Podcast</a> are released every month.</div>*/

		wpcampus_print_podcast_links();

		?>
	</div>
	<?php
}

/**
 * Print user registration promo.
 */
function wpcampus_print_user_reg_promo() {

	?>
	<div class="panel blue center" style="margin:2em 0 3em 0;">
		<p>
			<strong><?php printf( __( 'Want to become a %s contributor?', 'wpcampus' ), 'WPCampus' ); ?></strong><br/><?php printf( __( 'Great! You can become a contributor by speaking at %1$sone of our events%2$s, being a guest %3$son our podcast%4$s, or by submitting a guest blog post. We\'d love to have your voice and insight. %5$sRegister as a user%6$s to get started.', 'wpcampus' ), '<a href="/conferences/">', '</a>', '<a href="/podcast/">', '</a>', '<a href="/user-registration/">', '</a>' ); ?>
		</p>
	</div>
	<?php
}

/**
 * Is used in certain places to prepend
 * the post title with post type.
 * @param   $post_title - the post title we're prepending.
 * @param   $post_id    - the post ID.
 * @return  string - the new post title.
 */
function wpcampus_prepend_post_title( $post_title, $post_id ) {

	// Get the post type.
	$post_type = get_post_type( $post_id );

	switch ( $post_type ) {

		case 'opportunity':
			if ( ! is_post_type_archive( $post_type ) ) {
				return '<span class="fade type">' . __( 'Get Involved:', 'wpcampus' ) . '</span> ' . $post_title;
			}
			break;

		case 'podcast':
			if ( ! is_post_type_archive( $post_type ) ) {
				return '<span class="fade type">' . __( 'Podcast:', 'wpcampus' ) . '</span> ' . $post_title;
			}
			break;

		case 'post':
			return '<span class="fade type">' . __( 'Blog:', 'wpcampus' ) . '</span> ' . $post_title;

		case 'proposal':
			if ( ! is_page( 'library' ) ) {
				return '<span class="fade type">' . __( 'Session:', 'wpcampus' ) . '</span> ' . $post_title;
			}
			break;

		case 'resource':
			if ( ! is_post_type_archive( $post_type ) ) {
				return '<span class="fade type">' . __( 'Resource:', 'wpcampus' ) . '</span> ' . $post_title;
			}
			break;

		case 'video':
			if ( ! is_post_type_archive( $post_type ) ) {
				return '<span class="fade type">' . __( 'Video:', 'wpcampus' ) . '</span> ' . $post_title;
			}
			break;
	}

	return $post_title;
}

function wpcampus_print_contributors() {

	$users = new WP_User_Query(
		array(
			'number'              => - 1,
			'orderby'             => 'name',
			'order'               => 'ASC',
			'has_published_posts' => array( 'post', 'podcast', 'video' ),
		)
	);

	// Print user registration promo.
	wpcampus_print_user_reg_promo();

	if ( empty( $users->results ) ) :
		?>
		<p><?php _e( 'There are no contributors.', 'wpcampus' ); ?></p>
	<?php
	else :

		do_action( 'wpcampus_before_contributors' );

		?>
		<div class="wpcampus-contributors">
			<?php

			foreach ( $users->results as $user ) :
				wpcampus_print_contributor( $user->ID );
			endforeach;

			?>
		</div><!--.wpcampus-contributors-->
		<?php

		do_action( 'wpcampus_after_contributors' );

	endif;
}
