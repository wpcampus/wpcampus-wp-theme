<?php

// Hide the breadcrumbs.
add_filter( 'wpcampus_print_breadcrumbs', function( $print ){ return false; });

// Remove the Mailchimp signup.
remove_action( 'wpc_add_after_content', 'wpcampus_add_mailchimp_to_content' );

function wpcampus_before_proposal_page_title() {

	if ( ! function_exists( 'wpcampus_speakers' ) ) :
		?><p>This page requires the WPCampus Speakers plugin.</p><?php
		return;
	endif;

	if ( current_user_can( 'review_wpc_proposals' ) ) :

		$notice_message = null;

		if ( ! empty( $_GET['assign'] ) && 'success' == $_GET['assign'] ) :
			$notice_message = '<strong>Your proposal assignment was submitted.</strong>';
		elseif ( ! empty( $_GET['rating'] ) && 'success' == $_GET['rating'] ) :
			$notice_message = '<strong>Your rating was submitted.</strong>';
		endif;

		if ( ! empty( $notice_message ) ) :
			?>
			<div class="panel dark-blue bigger" style="margin-bottom:3rem;"><?php echo $notice_message; ?></div>
			<?php
		endif;
	endif;

	$proposal_id = get_the_ID();

	?>
	<div class="proposal-title">
		<div class="proposal-page-title"><?php printf( __( '%s Proposal', 'wpcampus' ), 'WPCampus' ); ?></div>
		<div class="proposal-status">
			<?php

			$proposal_status = wpcampus_speakers()->get_proposal_status( $proposal_id );

			switch ( $proposal_status ) :
				case 'confirmed':
					?>
					<span style="color:green;"><?php _e( 'Proposal confirmed', 'wpcampus' ); ?></span>
					<?php
					break;

				case 'declined':
				case 'no':

					?>
					<span style="color:#900;">
						<?php

						if ( 'no' == $proposal_status ) {
							_e( 'This proposal was not selected.', 'wpcampus' );
						} else {
							_e( 'Proposal declined', 'wpcampus' );
						}

						?>
					</span>
					<?php
					break;

				case 'selected':
					?>
					<span style="color:#74298d;"><em><?php _e( 'Proposal selected, not confirmed', 'wpcampus' ); ?></em></span>
					<?php
					break;

				case 'backup':
					?>
					<span><em><?php _e( 'Proposal selected as a backup', 'wpcampus' ); ?></em></span>
					<?php
					break;

				case 'maybe':
					?>
					<span><em><?php _e( 'Proposal selected as a "maybe"', 'wpcampus' ); ?></em></span>
					<?php
					break;

				default:
					/*?>
					<span style="color:#1159bd;"><em><?php _e( 'Proposal not reviewed', 'wpcampus' ); ?></em></span>
					<?php*/
					break;
			endswitch;

			?>
		</div>
	</div>
	<?php
}
add_action( 'wpcampus_before_page_title', 'wpcampus_before_proposal_page_title' );

function wpcampus_proposal_before_article_content() {
	global $post, $wpc_session_entry, $preferred_session_str;

	$is_review = wpcampus_speakers()->proposal_status_is_review();

	if ( current_user_can( 'edit_proposal' ) ) :

		$edit_link = get_edit_post_link( $post->ID );

		?>
		<a class="button proposal-edit-button" href="<?php echo $edit_link; ?>" target="_blank"><?php _e( 'Edit this proposal', 'wpcampus-speakers' ); ?></a>
		<?php
	endif;

	// Get the entry.
	$entry_id = function_exists( 'wpcampus_speakers' ) ? wpcampus_speakers()->get_proposal_gf_entry_id( get_the_ID() ) : 0;
	$wpc_session_entry = $entry_id > 0 ? GFAPI::get_entry( $entry_id ) : array();
	if ( is_wp_error( $wpc_session_entry ) ) {
		$wpc_session_entry = array();
	}

	$information = array();

	$event = wp_get_object_terms( $post->ID, 'proposal_event', array( 'fields' => 'names' ) );
	if ( empty( $event ) ) {
		$information[] = '<strong>Event:</strong> <em>' . __( 'This proposal has not been assigned to an event', 'wpcampus' ) . '</em>';
	} else {
		$information[] = '<strong>Event:</strong> ' . implode( ', ', $event );
	}

	$subjects = wp_get_object_terms( $post->ID, 'subjects', array( 'fields' => 'names' ) );
	if ( empty( $subjects ) ) {
		$information[] = '<strong>Subjects:</strong> <em>' . __( 'There are no subjects', 'wpcampus' ) . '</em>';
	} else {
		$information[] = '<strong>Subjects:</strong> ' . implode( ', ', $subjects );
	}

	$session_technical = wp_get_object_terms( $post->ID, 'session_technical', array( 'fields' => 'names' ) );
	if ( empty( $session_technical ) ) {
		$information[] = '<strong>Technical Levels:</strong> <em>' . __( 'There are no technical levels', 'wpcampus' ) . '</em>';
	} else {
		$information[] = '<strong>Technical Levels:</strong> ' . implode( ', ', $session_technical );
	}

	if ( ! empty( $information ) ) :
		?>
		<ul class="proposal-information">
			<li><?php echo implode( '</li><li>', $information ); ?></li>
		</ul>
		<?php
	endif;

	$format_header = 'Session Format(s)';

	$preferred_session_str = '<em>' . __( 'None', 'wpcampus' ) . '</em>';

	$preferred_session_formats = wp_get_object_terms( $post->ID, 'preferred_session_format', array( 'fields' => 'names' ) );
	if ( empty( $preferred_session_formats ) ) {
		$preferred_session_str = '<em>' . __( 'There are no preferred session formats.', 'wpcampus' ) . '</em>';
	} else {
		$preferred_session_str = implode( ', ', $preferred_session_formats );
	}

	if ( $is_review ) {
		$format_header = 'Preferred ' . $format_header;
		$preferred_session_str = '<strong>' . $preferred_session_str . '</strong>';
	} else {
		$preferred_session_str = '<em>Preferred Session Format(s): ' . $preferred_session_str . '</em>';
	}

	?>
	<hr>
	<h2><?php echo $format_header; ?></h2>
	<?php

	if ( ! $is_review ) :

		$session_formats = wp_get_object_terms( $post->ID, 'session_format', array( 'fields' => 'names' ) );
		if ( empty( $session_formats ) ) {
			$session_formats_str = '<em>' . __( 'There are no selected session formats.', 'wpcampus' ) . '</em>';
		} else {
			$session_formats_str = implode( ', ', $session_formats );
		}

		?>
		<p><strong>Selected Session Format(s):</strong> <?php echo $session_formats_str; ?></p>
		<?php

		echo $preferred_session_str;

	else:
		echo $preferred_session_str;
	endif;

	?>
	<h2>Session Description</h2>
	<?php


}
add_action( 'wpcampus_before_article_content', 'wpcampus_proposal_before_article_content' );

function wpcampus_proposal_after_article_content() {
	global $post, $wpc_session_entry, $preferred_session_str;

	if ( ! function_exists( 'wpcampus_speakers' ) ) {
		return;
	}

	?>
	<h2>Session Information</h2>
	<?php

	if ( empty( $wpc_session_entry[20] ) ) :
		?>
		<p><em><?php _e( 'There is no more information for this session.', 'wpcampus' ); ?></em></p>
		<?php
	else :
		echo wpautop( $wpc_session_entry[20] );
	endif;

	?>
	<h2>Session Audience</h2>
	<?php

	if ( empty( $wpc_session_entry[16] ) ) :
		?>
		<p><em><?php _e( 'There is not a defined audience for this session.', 'wpcampus' ); ?></em></p>
		<?php
	else :
		echo wpautop( $wpc_session_entry[16] );
	endif;

	?>
	<h2>Speaker Experience</h2>
	<?php

	if ( empty( $wpc_session_entry[26] ) ) :
		?>
		<p><em><?php _e( 'They did not provide any speaker experience.', 'wpcampus' ); ?></em></p>
		<?php
	else :
		echo wpautop( $wpc_session_entry[26] );
	endif;

	?>
	<h2>Other Information</h2>
	<?php

	if ( empty( $wpc_session_entry[19] ) ) :
		?>
		<p><em><?php _e( 'They did not provide any other information.', 'wpcampus' ); ?></em></p>
		<?php
	else :
		echo wpautop( $wpc_session_entry[19] );
	endif;

	?>
	<h2>Need Special Accommodations</h2>
	<?php

	if ( empty( $wpc_session_entry[30] ) ) :
		?>
		<p><em><?php _e( 'They do not need any special accomodations.', 'wpcampus' ); ?></em></p>
		<?php
	else :
		echo wpautop( $wpc_session_entry[30] );
	endif;

	$is_review = wpcampus_speakers()->proposal_status_is_review();
	$is_selection = wpcampus_speakers()->proposal_status_is_selection();
	$display_speakers = wpcampus_speakers()->proposal_selection_display_speakers();

	?>
	<hr>
	<h2>Speakers</h2>
	<?php

	if ( ! $is_review && $display_speakers ) :

		// Who filled out the form?
		$speaker_form_user_id = ! empty( $wpc_session_entry[66] ) ? $wpc_session_entry[66] : 0;

		$speakers = wpcampus_speakers()->get_proposal_speakers( $post->ID );

		foreach( $speakers as $speaker ) :

			// This speaker filled out the form.
			$is_entry_author = ( $speaker->wordpress_user == $speaker_form_user_id );

			?>
			<h3><?php echo $speaker->display_name; ?></h3>
			<?php

			echo wpautop( $speaker->post_content );

			$speaker_info = array();

			if ( ! empty( $speaker->email ) ) {
				$speaker_info[] = '<strong>Email:</strong> <a href="mailto:' . $speaker->email . '">' . $speaker->email . '</a>';
			}

			if ( ! empty( $speaker->website ) ) {
				$speaker_info[] = '<strong>Website:</strong> <a href="' . $speaker->website . '" target="_blank">' . $speaker->website . '</a>';
			}

			if ( ! empty( $speaker->company ) ) {
				$speaker_info[] = '<strong>Company:</strong> ' . $speaker->company;
			}

			if ( ! empty( $speaker->company_website ) ) {
				$speaker_info[] = '<strong>Company Website:</strong> <a href="' . $speaker->company_website . '" target="_blank">' . $speaker->company_website . '</a>';
			}

			if ( ! empty( $speaker->company_position ) ) {
				$speaker_info[] = '<strong>Job Title:</strong> ' . $speaker->company_position;
			}

			if ( ! empty( $speaker->twitter ) ) {
				$speaker->twitter = preg_replace( '/[^a-z0-9\_]/i', '', $speaker->twitter );
				$speaker_info[] = '<strong>Twitter:</strong> <a href="https://twitter.com/' . $speaker->twitter . '" target="_blank">@' . $speaker->twitter . '</a>';
			}

			if ( ! empty( $speaker->linkedin ) ) {
				$speaker_info[] = '<strong>LinkedIn:</strong> <a href="' . $speaker->linkedin . '" target="_blank">' . $speaker->linkedin . '</a>';
			}

			if ( ! empty( $wpc_session_entry[ $is_entry_author ? 14 : 35 ] ) ) {
				$speaker_info[] = '<strong>Traveling From:</strong> ' . $wpc_session_entry[ $is_entry_author ? 14 : 35 ];
			}

			if ( ! empty( $wpc_session_entry[ $is_entry_author ? 13 : 40 ] ) ) {
				$speaker_info[] = '<strong>Employment Status:</strong> ' . $wpc_session_entry[ $is_entry_author ? 13 : 40 ];
			}

			if ( ! empty( $wpc_session_entry[ $is_entry_author ? 7 : 42 ] ) ) {
				$speaker_info[] = '<strong>Higher Ed Status:</strong> ' . $wpc_session_entry[ $is_entry_author ? 7 : 42 ];
			}

			if ( ! empty( $wpc_session_entry[ $is_entry_author ? 11 : 43 ] ) ) {
				$speaker_info[] = '<strong>Where Worked in Higher Ed:</strong> ' . $wpc_session_entry[ $is_entry_author ? 11 : 43 ];
			}

			if ( ! empty( $speaker_info ) ) :
				?>
				<ul class="speaker-information">
					<li><?php echo implode( '</li><li>', $speaker_info ); ?></li>
				</ul>
				<?php
			endif;

		endforeach;

	else :

		if ( $display_speakers ) {
			$message = 'We only show the speakers during the selection process.';
		} else {
			$selection_status = wpcampus_speakers()->get_proposal_selection_status();
			$message = sprintf( 'We don\'t show the speakers during the %s process.', $selection_status );
		}

		?>
		<p><em><?php echo $message; ?></em></p>
		<?php
	endif;

	if ( current_user_can( 'review_wpc_proposals' ) ) :

		$user_rating = (int) wpcampus_speakers()->get_proposal_user_rating( $post->ID );
		$avg_rating = ! $is_review ? wpcampus_speakers()->get_proposal_avg_rating( $post->ID ) : '-';

		?>
		<hr>

		<h2>Average Rating: <strong><?php echo $avg_rating; ?></strong></h2>
		<h2 style="margin-top:0;">Your Rating: <?php echo $user_rating > 0 ? $user_rating : '-'; ?></h2>
		<?php

		if ( $is_review ) :
			?>
			<p><em>We don't show the average rating during the review process.</em></p>
			<?php
		endif;

		?>
		<hr>

		<h2>Review Proposal</h2>
		<p>Please rate this session on a scale of 1-5.</p>
		<p>1 being the least relevant and low rated.<br>5 meaning you think this session is relevant and should be held at the event.</p>
		<form class="session-rating" action="" method="post">
			<label for="session-rating"><strong>Your rating:</strong></label>
			<input id="session-rating" type="number" name="wpc_session_rating" min="1" max="5" value="<?php echo $user_rating > 0 ? $user_rating : ''; ?>">
			<input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
			<?php wp_nonce_field( 'wpc_process_session_rating', 'wpc_process_session_rating_nonce' ); ?>
			<input type="submit" value="Submit your rating">
		</form>
		<?php
	endif;

	if ( $is_selection && current_user_can( 'assign_wpc_proposals' ) ) :

		?>
		<h2>Assign Proposal</h2>
		<form class="session-assign" action="" method="post">
			<?php

			$proposal_status_choices = wpcampus_speakers()->get_proposal_status_choices();
			if ( ! empty( $proposal_status_choices ) ) :

				$selected_status = get_post_meta( $post->ID, 'proposal_status', true );

				if ( ! $selected_status ) {
					$selected_status = 'submitted';
				}

				?>
				<h3>Assign Review Status</h3>
				<fieldset>
					<legend>Review status:</legend>
					<?php

					foreach( $proposal_status_choices as $choice_key => $choice_label ) :
						?>
						<label><input type="radio" name="proposal_status" value="<?php echo $choice_key; ?>"<?php checked( $selected_status == $choice_key ); ?>> <?php echo $choice_label; ?></label>
						<?php
					endforeach;

					?>
				</fieldset>
				<?php
			endif;

			$formats = get_terms( 'session_format', array( 'hide_empty' => false ) );
			if ( ! empty( $formats ) ) :

				$selected_session_format = get_post_meta( $post->ID, 'selected_session_format', true );

				?>
				<h3>Assign Session Format</h3>
				<?php echo $preferred_session_str; ?><br>
				<label for="session-format"><strong>Selected session format:</strong></label>
				<select id="session-format" name="selected_session_format">
					<option value="">Select a format</option>
					<?php

					foreach ( $formats as $format ) :
						?>
						<option value="<?php echo $format->term_id; ?>"<?php selected( $selected_session_format == $format->term_id ); ?>><?php echo $format->name; ?></option>
						<?php
					endforeach;

					?>
				</select>
				<?php
			endif;

			$proposal_feedback = get_post_meta( $post->ID, 'proposal_feedback', true );

			?>
			<h3>Submit Feedback</h3>
			<p>Submit feedback for the speaker.</p>
			<textarea id="proposal-feedback" name="proposal_feedback" rows="4" title="Submit feedback for speaker"><?php echo trim( esc_textarea( $proposal_feedback ) ); ?></textarea>
			<input type="hidden" name="post_id" value="<?php echo $post->ID; ?>">
			<?php wp_nonce_field( 'wpc_process_session_assign', 'wpc_process_session_assign_nonce' ); ?>
			<input type="submit" value="Submit your assignment">
		</form>
		<?php
	endif;
}
add_action( 'wpcampus_after_article_content', 'wpcampus_proposal_after_article_content' );

get_header();

if ( ! have_posts() ) :
	wpcampus_print_404();
else :
	while ( have_posts() ) :
		the_post();

		wpcampus_print_article();

		comments_template();

	endwhile;
endif;

get_footer();
