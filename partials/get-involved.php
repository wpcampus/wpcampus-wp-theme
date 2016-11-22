<?php

// Get some site information.
$blog_url = get_bloginfo( 'url' );
$theme_dir = trailingslashit( get_template_directory_uri() );

?><div id="wpc-get-involved">
	<div class="social">
		<span class="message"><?php _e( 'Get Involved', 'wpcampus' ); ?>:</span>
		<ul class="icons">
			<li><a class="slack" href="<?php echo $blog_url; ?>get-involved/"><img src="<?php echo $theme_dir; ?>assets/images/slack-black.svg" alt="<?php printf( __( 'Join %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Slack' ); ?>" /></a></li>
			<li><a class="twitter" href="https://twitter.com/wpcampusorg"><img src="<?php echo $theme_dir; ?>assets/images/twitter-black.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Twitter' ); ?>" /></a></li>
			<li><a class="facebook" href="https://www.facebook.com/wpcampus"><img src="<?php echo $theme_dir; ?>assets/images/facebook-black.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'Facebook' ); ?>" /></a></li>
			<li><a class="youtube" href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $theme_dir; ?>assets/images/youtube-black.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'YouTube' ); ?>" /></a></li>
			<li><a class="github" href="https://github.com/wpcampus/"><img src="<?php echo $theme_dir; ?>assets/images/github-black.svg" alt="<?php printf( __( 'Follow %1$s on %2$s', 'wpcampus' ), 'WPCampus', 'GitHub' ); ?>" /></a></li>
		</ul>
	</div><!-- .social -->
	<div class="mailing">Sign up for our mailing list</div><!-- .mailing -->
</div><!-- #wpc-get-involved -->