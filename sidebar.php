<?php

// Get current sidebar.
$sidebar_id = wpc_get_current_sidebar();

// Make sure we have a sidebar ID.
if ( ! $sidebar_id ) {
	return false;
}

// Make sure the sidebar is active.
if ( ! is_active_sidebar( $sidebar_id ) ) {
	return false;
}

// Build sidebar classes.
$sidebar_classes = array( 'wpc-sidebar', preg_replace( '/^wpc\-sidebar\-/i', '', $sidebar_id ) );

?>
<div class="<?php echo implode( ' ', $sidebar_classes ); ?>">
	<?php dynamic_sidebar( $sidebar_id ); ?>
</div><!-- .wpc-sidebar -->
