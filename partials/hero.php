<?php

// Get site information.
$theme_dir = trailingslashit( get_template_directory_uri() );

// Get the counts.
$members = 580;
$institutions = 324;

?>
<div id="wpc-hero">
	<div class="inside from-left">
		<div class="wpc-hero-text">
			<div class="line members"><?php printf( _n( '%1$s%2$s%3$s Member', '%1$s%2$s%3$s Members', $members, 'wpcampus' ), '<span class="digit">', number_format( $members ), '</span>' ); ?></div>
			<div class="line institutions"><?php printf( _n( '%1$s%2$s%3$s Institution', '%1$s%2$s%3$s Institutions', $institutions, 'wpcampus' ), '<span class="digit">', number_format( $institutions ), '</span>' ); ?></div>
			<div class="line org"><span class="digit">1</span> WPCampus</div>
			<div class="tagline"><?php printf( __( 'Where %s Meets Higher Education', 'wpcampus' ), 'WordPress' ); ?></div>
		</div>
	</div><!-- .inside -->
	<?php wpc_theme_print_eduwapuu(); ?>
</div><!-- #wpc-hero -->