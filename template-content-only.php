<?php

/**
 * Template Name: WPCampus: Content Only
 */

global $post;

// Hide the admin bar.
add_filter( 'show_admin_bar', '__return_false' );

function wpcampus_add_to_login_form_top( $content, $args ) {
	global $post;
	if ( ! is_singular() || empty( $post->ID ) ) {
		return $content;
	}
	$title = get_post_meta( $post->ID, 'wpcampus_require_login_form_title', true );
	if ( ! empty( $title ) ) {
		return strip_tags( $title, '<h2><h3><h4><h5><h6>' );
	}
	return $content;
}
add_filter( 'login_form_top', 'wpcampus_add_to_login_form_top', 1, 2 );

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatibhttps://wpcampus.org/twenty-eighteen-speaker-application/le" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php wp_title( '-', true, 'left' ); ?></title>
		<?php wp_head(); ?>
		<script>
			document.domain='wpcampus.org';
		</script>
	</head>
	<body <?php body_class(); ?>>
		<?php

		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();

				$require_login = get_post_meta( $post->ID, 'wpcampus_require_login', true );
				$is_user_logged_in = is_user_logged_in();

				if ( ! $is_user_logged_in && $require_login ) :

					// Display login message.
					$message = get_post_meta( $post->ID, 'wpcampus_require_login_message', true );
					if ( ! empty( $message ) ) {

						// Remove all but allowed tags.
						$message = strip_tags( $message, '<a><ul><ol><li><em><strong><div><span><button><h2><h3><h4><h5><h6>' );

						echo ! empty( $message ) ? wpautop( $message ) : '';

					}

					wp_login_form();

				else :

					if ( $is_user_logged_in && $require_login ) :
						?>
						<p><a class="button" href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php printf( esc_attr__( 'Log out of your %s account', 'wpcampus' ), 'WPCampus' ); ?>"><?php _e( 'Logout', 'wpcampus' ); ?></a></p>
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
