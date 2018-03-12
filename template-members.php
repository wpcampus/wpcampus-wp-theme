<?php

/**
 * Template Name: WPCampus: Members
 */

// Is the user logged in?
$is_user_logged_in = is_user_logged_in();

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();

		// Only show content if logged in.
		if ( $is_user_logged_in ) :

			// Add logout link.
			$logout_url = wp_logout_url( get_permalink() );
			?><p><a href="<?php echo $logout_url; ?>"><?php _e( 'Logout', 'wpcampus' ); ?></a></p><?php

			// Print content.
			wpcampus_print_article();

		else :

			?>
			<div class="panel blue center">
				<p><?php printf( __( 'Membership into the %1$s community is open to all who wish to be involved.<br />%2$sFill out our user registration%3$s to join the fun.', 'wpcampus' ), 'WPCampus', '<a href="/user-registration/"><strong>', '</strong></a>' ); ?></p>
			</div>
			<?php

			// Force login.
			wp_login_form( array(
				'remember'       => true,
				'form_id'        => 'login-form',
				'id_username'    => 'user-login',
				'id_password'    => 'user-pass',
				'id_remember'    => 'remember-me',
				'id_submit'      => 'wp-submit',
				'label_username' => __( 'Username', 'wpcampus' ),
				'label_password' => __( 'Password', 'wpcampus' ),
				'label_remember' => __( 'Remember Me', 'wpcampus' ),
				'label_log_in'   => __( 'Login', 'wpcampus' ),
				'value_username' => '',
				'value_remember' => false,
			));
		endif;
	endwhile;
endif;

get_footer();
