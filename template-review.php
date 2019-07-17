<?php

// Template Name: WPCampus: Review

if ( ! is_user_logged_in() || ! current_user_can( 'review_wpc_proposals' ) ) {
	auth_redirect();
	exit;
}

remove_action( 'wpc_add_after_content', 'wpcampus_add_mailchimp_to_content' );

function wpcampus_review_print_review() {

	if ( ! function_exists( 'wpcampus_speakers' ) ) {
		return;
	}

	/*?>
	<button class="button button-primary wpc-proposals-table-update wpc-proposals-table-update-all">Update all tables</button>
	<?php*/

	//wpcampus_speakers()->print_proposals_select_table();
	wpcampus_speakers()->print_proposals_review_table();

}
add_action( 'wpcampus_after_article_content', 'wpcampus_review_print_review' );

//get_header( 'minimal' );

get_template_part( 'index' );
