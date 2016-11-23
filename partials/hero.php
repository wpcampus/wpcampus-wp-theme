<?php

// Get site information.
$theme_dir = trailingslashit( get_template_directory_uri() );
$is_front_page = is_front_page();

// Get the counts.
$members = 580;
$institutions = 324;

// Build hero classes.
$hero_classes = array();

if ( $is_front_page ) {
	$hero_classes[] = 'home';
}

?>
<div id="wpc-hero"<?php echo ! empty( $hero_classes ) ? ' class="' . implode( ' ', $hero_classes ) . '"' : ''; ?>>
	<div class="inside from-left">
		<?php

		if ( $is_front_page ) :

			?>
			<div class="wpc-home-hero-text">
				<div class="line members"><?php printf( _n( '%1$s%2$s%3$s Member', '%1$s%2$s%3$s Members', $members, 'wpcampus' ), '<span class="digit">', number_format( $members ), '</span>' ); ?></div>
				<div class="line institutions"><?php printf( _n( '%1$s%2$s%3$s Institution', '%1$s%2$s%3$s Institutions', $institutions, 'wpcampus' ), '<span class="digit">', number_format( $institutions ), '</span>' ); ?></div>
				<div class="line org"><span class="digit">1</span> WPCampus</div>
				<div class="tagline"><?php printf( __( 'Where %s Meets Higher Education', 'wpcampus' ), 'WordPress' ); ?></div>
			</div>
			<?php

		else :

			?>
			<h1><?php

				// Print title.
				if ( is_404() ) {
					_e( 'Page Not Found', 'wpcampus' );
				} else {
					echo apply_filters( 'wpcampus_page_title', get_the_title() );
				}

			?></h1>
			<?php

		endif;

		?>
	</div><!-- .inside -->
	<?php wpc_theme_print_eduwapuu(); ?>
</div><!-- #wpc-hero -->