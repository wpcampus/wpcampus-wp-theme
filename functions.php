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
	wpcampus_print_online_speakers_callout();
}

/**
 * Print the "Apply to host 2018" callout.
 */
function wpcampus_print_apply_host_2018_callout() {

	?>
	<div class="panel" style="text-align:center;">
		<h2 style="line-height:1.3;">Apply to host WPCampus 2018</h2>
		<p>WPCampus is looking for the host for our 2018 conference. If you wish to invest in higher education, and bring web professionals from all over the world to your campus, we’d love to learn more about you and your institution. <strong>The hosting application has been extended and will close FRIDAY, NOVEMBER 3, 2017.</strong></p>
		<a class="button expand" style="text-decoration:underline;" href="/conferences/apply-to-host/"><strong>Apply to host the WPCampus 2018 conference</strong></a>
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
 *
 * - Load the textdomain.
 * - Register the navigation menus.
 */
function wpcampus_setup_theme() {

	// Load the textdomain.
	load_theme_textdomain( 'wpcampus', get_stylesheet_directory() . '/languages' );

	// Register the nav menus.
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'wpcampus' ),
		'footer'    => __( 'Footer Menu', 'wpcampus' ),
	));

	// Add HTML5 support.
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	));

	add_theme_support( 'woocommerce' );

	if ( is_archive() ) {

		// Add article meta after header.
		add_action( 'wpcampus_after_article_header', 'wpcampus_print_article_meta', 5 );
	}
}
add_action( 'after_setup_theme', 'wpcampus_setup_theme' );

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
 * Setup styles and scripts.
 */
function wpcampus_enqueue_styles_scripts() {
	$wpcampus_version = '0.84';

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
	if ( is_page( 'conferences/apply-to-host' ) ) {
		wp_enqueue_style( 'wpcampus-host-application', $wpcampus_dir . 'assets/css/application.css', array(), $wpcampus_version, 'all' );
	}

	// Enqueue the sessions script.
	if ( is_page_template( 'template-sessions.php' ) ) {
		wp_enqueue_script( 'wpcampus-sessions', $wpcampus_dir . 'assets/js/wpcampus-sessions.js', array( 'jquery' ), $wpcampus_version, false );
		wp_localize_script( 'wpcampus-sessions', 'wpc_sessions', array(
			'load_error_msg' => '<p class="error-msg">' . __( 'Oops. Looks like something went wrong. Please refresh the page and try again.', 'wpcampus' ) . '</p><p>' . sprintf( __( 'If the problem persists, please %1$slet us know%2$s.', 'wpcampus' ), '<a href="/contact/">', '</a>' ) . '</p>',
		));
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

	foreach ( $image_sizes as $size ) :
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
 * Print the articles.
 *
 * @param array $args
 */
function wpcampus_print_articles( $args = array(), $query = null ) {
	global $wp_query;

	// Use default query if none was passed.
	if ( ! $query || ! is_a( $query, 'WP_Query' ) ) {
		$query = $wp_query;
	}

	do_action( 'wpcampus_before_articles' );

	?>
	<div class="wpcampus-articles">
		<?php

		while ( $query->have_posts() ) :
			$query->the_post();

			wpcampus_print_article( $args );

		endwhile;

		?>
	</div><!--.wpcampus-articles-->
	<?php

	do_action( 'wpcampus_after_articles' );

}

/**
 * Print the article.
 *
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
	$post_id = get_the_ID();
	$post_permalink = get_permalink( $post_id );
	$post_thumbnail_id = get_post_thumbnail_id( $post_id );

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

		// Get the featured image.
		$featured_image = $post_thumbnail_id > 0 ? wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' ) : '';
		if ( ! empty( $featured_image[0] ) ) :

			do_action( 'wpcampus_before_article_thumbnail' );

			?>
			<img class="article-thumbnail" src="<?php echo $featured_image[0]; ?>" />
			<?php

			do_action( 'wpcampus_after_article_thumbnail' );

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
		if ( post_type_supports( get_post_type(), 'comments' ) ) :

			// Get # of comments.
			$comments_number = get_comments_number();

			// Build comment classes.
			$comment_classes = array( 'article-meta', 'article-comments' );

			if ( $comments_number ) {
				$comment_classes[] = 'has-comments';
			}

			?>
			<span class="<?php echo implode( ' ', $comment_classes ); ?>"><a href="<?php echo $comments_link; ?>"><?php

			if ( ! $comments_number ) {
				echo __( 'Leave a comment', 'wpcampus' );
			} else {
				printf( _n( '%s comment', '%s comments', $comments_number, 'wpcampus' ), $comments_number );
			}

			?></a></span>
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

	echo sprintf( $time_string,
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
			$post_type_archive_link = get_post_type_archive_link( $post_type );
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
			$post_type_archive_link = get_post_type_archive_link( $post_type );
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

			// Add the ancestors.
			foreach ( $post_ancestors as $post_ancestor_id ) {

				// Add ancestor.
				$breadcrumbs[] = array(
					'ID'    => $post_ancestor_id,
					'url'   => get_permalink( $post_ancestor_id ),
					'label' => get_the_title( $post_ancestor_id ),
				);
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

	return $breadcrumbs;
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

		$breadcrumbs_html .= '<li role="menuitem"' . ( ! empty( $crumb_classes ) ? ' class="' . implode( ' ', $crumb_classes ) . '"' : null ) . '>';

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
		<nav class="breadcrumbs" role="menubar" aria-label="breadcrumbs">' . $breadcrumbs_html . '</nav>
	</div>';
	}

	return $breadcrumbs_html;
}

/**
 * Prints list of social media icons.
 *
 * @param   $color - string - color of icon, black is default.
 */
function wpcampus_print_social_media_icons( $color = 'black' ) {

	// Get the theme directory.
	$theme_dir = trailingslashit( get_template_directory_uri() );
	$images_dir = "{$theme_dir}assets/images/";

	// If color, prefix with dash.
	if ( $color ) {
		$color = "-{$color}";
	}

	?>
	<ul class="social-media-icons">
		<li><a class="slack" href="https://wpcampus.org/get-involved/"><img src="<?php echo $images_dir; ?>slack<?php echo $color; ?>.svg" alt="<?php printf( __( 'Join %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Slack' ); ?>" /></a></li>
		<li><a class="twitter" href="https://twitter.com/wpcampusorg"><img src="<?php echo $images_dir; ?>twitter<?php echo $color; ?>.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Twitter' ); ?>" /></a></li>
		<li><a class="facebook" href="https://www.facebook.com/wpcampus"><img src="<?php echo $images_dir; ?>facebook<?php echo $color; ?>.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Facebook' ); ?>" /></a></li>
		<li><a class="youtube" href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $images_dir; ?>youtube<?php echo $color; ?>.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'YouTube' ); ?>" /></a></li>
		<li><a class="github" href="https://github.com/wpcampus/"><img src="<?php echo $images_dir; ?>github<?php echo $color; ?>.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'GitHub' ); ?>" /></a></li>
	</ul>
	<?php
}

/**
 * Print the 404 page.
 */
function wpcampus_print_404() {

	do_action( 'wpcampus_before_404' );

	?>
	<p>Uh-oh. This page seems to be missing. Please check to make sure the link you requested was entered correctly.</p>
	<p>If you can't find what you're looking for in the menu, please <a href="/contact/">reach out to us</a> and let us know. We'd be happy to help.</p>
	<?php

	do_action( 'wpcampus_after_404' );

}

/**
 * Print a specific contributor's profile.
 */
function wpcampus_print_contributor( $user_id = 0 ) {

	// Make sure we have a user ID.
	if ( ! $user_id ) {
		$user_id = get_the_author_meta( 'ID' );
	}

	// Get display name
	$author_name = get_the_author_meta( 'display_name', $user_id );

	// Get thumbnail.
	$author_thumbnail = get_avatar_url( $user_id, array(
		'size' => '200',
	));

	// Get other fields.
	$author_desc = get_the_author_meta( 'description', $user_id );
	$author_website = get_the_author_meta( 'url', $user_id );
	$author_twitter = get_the_author_meta( 'twitter', $user_id );
	$author_company = get_the_author_meta( 'company', $user_id );
	$author_company_pos = get_the_author_meta( 'company_position', $user_id );

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
				<img class="author-thumbnail" src="<?php echo $author_thumbnail; ?>" />
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
				$author_twitter_handle = preg_replace( '/[^a-z0-9]/i', '', $author_twitter );
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
}

/**
 * Print podcast promo/links.
 */
function wpcampus_print_podcast_promo() {

	?>
	<div class="wpcampus-podcast-promo">
		<div class="panel">
			<p>The WPCampus Podcast is a monthly show where members of the community come together to discuss relevant topics, unique ways that WordPress is being used in higher education, share tutorials and walkthroughs, and more. <strong><em>If you'd like to be a guest on the show, or have a topic you'd like us to discuss, please <a href="/contact/">let us know</a>.</em></strong></p>
		</div>
		<div class="panel dark-blue center" style="margin-bottom:20px;">New episodes of <a href="/podcast/">The WPCampus Podcast</a> are released every month.</div>
		<div style="text-align: center">
			<ul class="button-group">
				<li><a href="https://itun.es/i6YF9HH" class="button">Listen on iTunes</a></li>
				<li><a href="https://play.google.com/music/listen?u=0#/ps/Imipnlywvba5v3lqu7y646dg6z4" class="button">Listen on Google Play</a></li>
				<li><a href="/feed/podcast" class="button">View RSS feed</a></li>
			</ul>
		</div>
	</div>
	<?php
}

/**
 * Print user registration promo.
 */
function wpcampus_print_user_reg_promo() {

	?>
	<div class="panel blue center" style="margin:2em 0 3em 0;">
		<p><strong><?php printf( __( 'Want to become a %s contributor?', 'wpcampus' ), 'WPCampus' ); ?></strong><br/><?php printf( __( 'Great! We\'d love to have your voice and insight. %1$sRegister as a %2$s user%3$s to get started.', 'wpcampus' ), '<a href="/user-registration/">', 'WPCampus', '</a>' ); ?></p>
	</div>
	<?php
}

/**
 * Is used in certain places to prepend
 * the post title with post type.
 *
 * @param   $post_title - the post title we're prepending.
 * @param   $post_id - the post ID.
 * @return  string - the new post title.
 */
function wpcampus_prepend_post_title( $post_title, $post_id ) {

	// Get the post type.
	$post_type = get_post_type( $post_id );

	switch ( $post_type ) {

		case 'podcast':
			return '<span class="fade type">' . __( 'Podcast:', 'wpcampus' ) . '</span> ' . $post_title;
		case 'post':
			return '<span class="fade type">' . __( 'Blog:', 'wpcampus' ) . '</span> ' . $post_title;
		case 'video':
			return '<span class="fade type">' . __( 'Video:', 'wpcampus' ) . '</span> ' . $post_title;
	}

	return $post_title;
}
