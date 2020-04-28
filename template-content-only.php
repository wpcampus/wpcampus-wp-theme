<?php

/**
 * Template Name: WPCampus: Content Only
 */

global $post;

// Hide the admin bar.
add_filter( 'show_admin_bar', '__return_false' );

function wpcampus_content_only_assets() {

	// Load the counter part to the iframe resizer.
	wp_enqueue_script( 'wpc-iframe-resizer', trailingslashit( get_stylesheet_directory_uri() ) . 'assets/js/iframeResizer.contentWindow.min.js', array(), null );

}
add_action( 'wp_enqueue_scripts', 'wpcampus_content_only_assets', 20 );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> style="margin:0!important;padding:0!important;">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '-', true, 'left' ); ?></title>
	<?php

	wp_head();

	wpcampus_add_document();

	?>
</head>
<body <?php body_class(); ?>>
<?php

function wpcampus_print_login_message( $post_id, $key ) {

	$message = get_post_meta( $post_id, $key, true );
	if ( empty( $message ) ) {
		return;
	}

	// Remove all but allowed tags.
	$message = strip_tags( $message, '<a><ul><ol><li><em><strong><div><span><button><h2><h3><h4><h5><h6><br>' );

	if ( empty( $message ) ) {
		return;
	}

	echo wpautop( $message );

}

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		$require_login     = get_post_meta( $post->ID, 'wpcampus_require_login', true );
		$is_user_logged_in = is_user_logged_in();

		if ( ! $is_user_logged_in && $require_login ) :

			wpcampus_print_login_message( $post->ID, 'wpcampus_require_login_message_pre' );

			?>
			<h2>Login to WPCampus</h2>
			<?php

			wpcampus_print_login_message( $post->ID, 'wpcampus_require_login_message' );

			wp_login_form();

			wpcampus_print_login_message( $post->ID, 'wpcampus_require_login_message_post' );

		else :

			if ( $is_user_logged_in && $require_login ) :

				$current_user = wp_get_current_user();

				$current_user_edit_url = get_edit_user_link( $current_user->ID );

				?>
                <p class="wpcampus-login-status">
                    <a class="button wpcampus-login-status__button wpcampus-login-status__button--logout" href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php printf( esc_attr__( 'Log out of your %s account', 'wpcampus' ), 'WPCampus' ); ?>"><?php _e( 'Logout', 'wpcampus' ); ?></a>
                    <span class="wpcampus-login-status__message"><?php printf( __( 'You are logged-in as %1$s%2$s%3$s.', 'wpcampus' ), '<strong>', $current_user->get( 'display_name' ), '</strong>' ); ?> <a href="<?php echo esc_url( $current_user_edit_url ); ?>" target="_blank">Edit your profile</a></span>
                </p>
			<?php
			endif;

			the_content();

		endif;
	endwhile;
endif;

wp_footer();

?>
</body>
</html>