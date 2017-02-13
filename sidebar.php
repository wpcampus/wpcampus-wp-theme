<?php

// Get current sidebar.
$sidebar_id = wpc_get_current_sidebar();

if ( ! $sidebar_id ) {
	return false;
}

// Build sidebar classes.
$sidebar_classes = array( 'wpc-sidebar', preg_replace( '/^wpc\-sidebar\-/i', '', $sidebar_id ) );

?>
<div class="<?php echo implode( ' ', $sidebar_classes ); ?>">
	<?php dynamic_sidebar( $sidebar_id ); ?>
</div><!-- .wpc-sidebar -->