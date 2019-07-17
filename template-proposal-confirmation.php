<?php

/**
 * Template Name: WPCampus: Proposal Confirmation
 */

global $wpc_proposal, $wpc_profile;

// Get proposal and profile information.
$proposal_id = ! empty( $_GET['proposal'] ) ? (int) $_GET['proposal'] : 0;
$profile_id = ! empty( $_GET['profile'] ) ? (int) $_GET['profile'] : 0;

$wpc_proposal = ! $proposal_id || ! function_exists( 'wpcampus_speakers' ) ? null : wpcampus_speakers()->get_proposals( array(
	'p' => $proposal_id,
	'get_profiles' => true,
));

$wpc_profile = null;
if ( ! empty( $wpc_proposal->speakers ) ) {
	foreach ( $wpc_proposal->speakers as $speaker ) {
		if ( $speaker->ID == $profile_id ) {
			$wpc_profile = $speaker;
			break;
		}
	}
}

// Print success messages.
add_action( 'the_content', function( $content ) {
	if ( ! empty( $_GET['speaker-confirm'] ) && 'success' == $_GET['speaker-confirm'] ) {
		$content = '<div style="text-align:center;"><p><strong>Hooray! Thank you, thank you, thank you!</strong></p>
			<p>We\'re so thrilled that you\'ll be joining us for WPCampus 2019. We\'ll be in touch soon with more information. In the meantime, kick back and relax and bask in your awesomeness.</p>
			<p><em>*However, please wait to share your awesomeness until we announce the schedule.</em></p>
			<img src="https://media.giphy.com/media/26gsjCZpPolPr3sBy/source.gif">
		</div>';
	}
	return $content;
});

get_template_part( 'index' );
