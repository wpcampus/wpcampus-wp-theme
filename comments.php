<?php
/**
 * The template for displaying comments.
 */

if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
	return;
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>
<div id="comments" class="comments-area">
	<?php

	if ( have_comments() ) :

		?>
		<h2 class="comments-title">
			<?php

			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'wpcampus' ), get_the_title() );
			} else {
				printf(
					/* translators: 1: number of comments, 2: post title */
					_nx(
						'%1$s Reply to &ldquo;%2$s&rdquo;',
						'%1$s Replies to &ldquo;%2$s&rdquo;',
						$comments_number,
						'comments title',
						'wpcampus'
					),
					number_format_i18n( $comments_number ),
					get_the_title()
				);
			}

			?>
		</h2>
		<ol class="comment-list">
			<?php

			wp_list_comments( array(
				'avatar_size'   => 60,
				'style'         => 'ol',
				'short_ping'    => true,
				'reply_text'    => __( 'Reply', 'wpcampus' ),
				'walker'        => new WPCampus_Walker_Comment(),
				'format'        => 'html5',
			));

			?>
		</ol>
		<?php

		the_comments_pagination( array(
			'prev_text' => '<span class="for-screen-reader">' . __( 'Previous', 'wpcampus' ) . '</span>',
			'next_text' => '<span class="for-screen-reader">' . __( 'Next', 'wpcampus' ) . '</span>',
		));

	endif;

	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() ) :

		?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'wpcampus' ); ?></p>
		<?php

	endif;

	comment_form();

	?>
</div>
