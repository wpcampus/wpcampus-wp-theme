<?php

/**
 * Template Name: WPCampus: Videos
 */

// Get the playlists.
$playlists = get_terms( 'playlist', array(
	'hide_empty' => true,
));

// Get the categories.
$categories = get_terms( 'category', array(
	'hide_empty' => true,
));

// Will hold the filters.
$filters = array();

// Is there a selected playlist?
$filters['playlist'] = ! empty( $_GET['e'] ) ? sanitize_text_field( $_GET['e'] ) : get_query_var( 'videos_playlist' );

// Is there a selected type?
if ( 'podcast' == $filters['playlist'] ) {

	/*
	 * If podcast was the selected playlist,
	 * then set for type and clear out the playlist.
	 */
	$filters['type'] = $filters['playlist'];
	unset( $filters['playlist'] );

} else {
	$filters['type'] = get_query_var( 'videos_type' );
}

// Is there a selected category?
$filters['category'] = ! empty( $_GET['c'] ) ? sanitize_text_field( $_GET['c'] ) : get_query_var( 'videos_category' );

// Is there a selected author?
$filters['author'] = ! empty( $_GET['a'] ) ? sanitize_text_field( $_GET['a'] ) : get_query_var( 'videos_author' );

// Are we searching?
$filters['search'] = ! empty( $_GET['search'] ) ? sanitize_text_field( $_GET['search'] ) : get_query_var( 'videos_search' );

// Remove empty filters.
$filters = array_filter( $filters );

get_header();

if ( ! have_posts() ) :
	wpcampus_print_404();
else :
	while ( have_posts() ) :
		the_post();

		wpcampus_print_article();

		// Print video filters.
		?>
		<div class="wpc-videos-filters">
			<form action="/videos/">
				<span class="form-label"><strong><?php _e( 'Filter videos:', 'wpcampus' ); ?></strong></span>
				<select name="e" class="filter filter-event" title="<?php esc_attr_e( 'Filter videos by event', 'wpcampus' ); ?>">
					<option value=""><?php _e( 'All events', 'wpcampus' ); ?></option>
					<option value="podcast"<?php selected( ! empty( $filters['type'] ) && 'podcast' == $filters['type'] ) ?>><?php printf( __( '%s Podcast', 'wpcampus' ), 'WPCampus' ); ?></option>
					<?php

					foreach ( $playlists as $playlist ) :
						?><option value="<?php echo $playlist->slug; ?>"<?php selected( ! empty( $filters['playlist'] ) && $filters['playlist'] == $playlist->slug ) ?>><?php echo $playlist->name; ?></option><?php
					endforeach;

					?>
				</select>
				<select name="c" class="filter filter-category" title="<?php esc_attr_e( 'Filter videos by category', 'wpcampus' ); ?>">
					<option value=""><?php _e( 'All categories', 'wpcampus' ); ?></option>
					<?php

					foreach ( $categories as $cat ) :
						?><option value="<?php echo $cat->slug; ?>"<?php selected( ! empty( $filters['category'] ) && $filters['category'] == $cat->slug ) ?>><?php echo $cat->name; ?></option><?php
					endforeach;

					?>
				</select>
				<?php

				// Filter by authors.
				if ( function_exists( 'wpcampus_media_videos' ) && method_exists( wpcampus_media_videos(), 'get_all_authors' ) ) :

					// Get authors.
					$authors = wpcampus_media_videos()->get_all_authors();
					if ( ! empty( $authors ) ) :

						?>
						<select name="a" class="filter filter-author" title="<?php esc_attr_e( 'Filter videos by author', 'wpcampus' ); ?>">
							<option value=""><?php _e( 'All authors', 'wpcampus' ); ?></option>
							<?php

							foreach ( $authors as $author ) :
								?><option value="<?php echo $author->user_login; ?>"<?php selected( ! empty( $filters['author'] ) && $filters['author'] == $author->user_login ); ?>><?php echo $author->display_name; ?></option><?php
							endforeach;

							?>
						</select>
						<?php
					endif;
				endif;

				?>
				<input type="search" class="search-videos" name="search" value="<?php echo ! empty( $filters['search'] ) ? esc_attr( $filters['search'] ) : ''; ?>" placeholder="<?php esc_attr_e( 'Search videos', 'wpcampus' ); ?>" title="<?php esc_attr_e( 'Search videos', '' ); ?>" />
				<input type="submit" class="update-videos" value="<?php esc_attr_e( 'Update', 'wpcampus' ); ?>" title="<?php esc_attr_e( 'Update videos', 'wpcampus' ); ?>" />
			</form>
			<?php

			// Print clear filters button.
			if ( ! empty( $filters ) ) :
				?><a class="button red expand clear" href="/videos/"><?php _e( 'Clear filters', 'wpcampus' ); ?></a><?php
			endif;

			?>
		</div>
		<?php

		// Create shortcode arguments.
		$shortcode_args = '';
		foreach ( $filters as $filter_key => $filter_value ) {
			$shortcode_args .= " {$filter_key}=\"{$filter_value}\"";
		}

		// Print the list of videos.
		echo do_shortcode( "[wpc_videos{$shortcode_args}]" );

		comments_template();

	endwhile;
endif;

get_footer();
