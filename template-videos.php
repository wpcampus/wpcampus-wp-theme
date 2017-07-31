<?php

/**
 * Template Name: WPCampus Videos
 */

// Get the playlists.
$playlists = get_terms( 'playlist', array(
	'hide_empty' => true,
));

// Get the categories.
$categories = get_terms( 'category', array(
	'hide_empty' => true,
));

// Is there a selected playlist or type?
$selected_playlist = get_query_var( 'videos_playlist' );
$selected_type = get_query_var( 'videos_type' );

// Is there a selected category?
$selected_cat = ! empty( $_GET['c'] ) ? $_GET['c'] : '';
$selected_cat_url = ! empty( $selected_cat ) ? "?c={$selected_cat}" : '';

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
			<p><strong><?php _e( 'Filter videos:', 'wpcampus' ); ?></strong>
				<select onchange="window.location.href=this.value;">
					<option value="/videos/<?php echo $selected_cat_url; ?>"><?php _e( 'Show all events', 'wpcampus' ); ?></option>
					<option value="/videos/podcast/<?php echo $selected_cat_url; ?>"<?php selected( $selected_type && $selected_type == 'podcast' ) ?>><?php _e( 'Podcast', 'wpcampus' ); ?></option>
					<?php

					foreach ( $playlists as $playlist ) :
						?><option value="/videos/<?php echo $playlist->slug; ?>/<?php echo $selected_cat_url; ?>"<?php selected( $selected_playlist && $selected_playlist == $playlist->slug ) ?>><?php echo $playlist->name; ?></option><?php
					endforeach;

					?>
				</select>
				<select onchange="window.location.href=this.value;">
					<option value="/videos/<?php echo ! empty( $selected_type ) ? "{$selected_type}/" : ''; ?>"><?php _e( 'Show all categories', 'wpcampus' ); ?></option>
					<?php

					foreach ( $categories as $cat ) :
						?><option value="/videos/<?php echo ! empty( $selected_type ) ? "{$selected_type}/" : ''; ?>?c=<?php echo $cat->slug; ?>"<?php selected( $selected_cat && $selected_cat == $cat->slug ) ?>><?php echo $cat->name; ?></option><?php
					endforeach;

					?>
				</select>
			</p>
		</div>
		<?php

		// Get the list of videos.
		$videos = do_shortcode( '[wpc_videos orderby="title" order="asc" playlist="' . $selected_playlist . '" type="' . $selected_type . '" category="' . $selected_cat . '"]' );

		// Print the videos.
		if ( $videos ) :
			echo $videos;
		else :
			?><p><em><?php _e( 'There are no videos available.', 'wpcampus.' ); ?></em></p><?php
		endif;

		comments_template();

	endwhile;
endif;

get_footer();
