<?php

/**
 * Populate the user registration SMEs with subjects taxonomy.
 */
add_filter( 'gform_pre_render_14', 'wpcampus_populate_user_reg_subjects' );
add_filter( 'gform_pre_validation_14', 'wpcampus_populate_user_reg_subjects' );
add_filter( 'gform_pre_submission_filter_14', 'wpcampus_populate_user_reg_subjects' );
add_filter( 'gform_admin_pre_render_14', 'wpcampus_populate_user_reg_subjects' );
function wpcampus_populate_user_reg_subjects( $form ) {

	foreach ( $form['fields'] as &$field ) {

		// Only for the "Subject Matter Expert" form field
		if ( 'subjectexpert' != $field->adminLabel ) {
			continue;
		}

		// Get the subjects
		$subjects = get_terms( array(
			'taxonomy'      => 'subjects',
			'hide_empty'    => false,
			'orderby'       => 'name',
			'order'         => 'ASC',
			'fields'        => 'all',
		) );
		if ( ! empty( $subjects ) ) {

			// Add the subjects as choices
			$choices = array();

			foreach ( $subjects as $subject ) {
				$choices[] = array(
					'text'  => $subject->name,
					'value' => $subject->term_id,
				);
			}

			// Assign the new choices
			$field->choices = $choices;

		}

	}

	return $form;
}