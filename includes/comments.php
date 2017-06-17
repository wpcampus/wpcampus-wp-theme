<?php

/**
 * Core walker class used to extend
 * and customize the Walker_Comment class.
 *
 * @see Walker
 */
class WPCampus_Walker_Comment extends Walker_Comment {

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * @since 3.6.0
	 * @access protected
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {

		$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

		?>
		<<?php echo $tag; ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-meta">
				<?php

				if ( 0 != $args['avatar_size'] ) {
					echo get_avatar( $comment, $args['avatar_size'] );
				}

				?>
				<div class="comment-meta-text">
					<span class="comment-author"><?php
					printf( __( '%1$s %2$ssays:%3$s' ), '<span class="author-name">' . get_comment_author_link( $comment ) . '</span>', '<span class="author-says">', '</span>' );
					?></span>
					<div class="comment-time">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>"><time datetime="<?php comment_time( 'c' ); ?>"><?php
							printf( __( '%1$s at %2$s' ), get_comment_date( '', $comment ), get_comment_time() );
						?></time></a>
						<?php edit_comment_link( __( '[Edit]' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .comment-time -->
				</div>
				<?php

				if ( '0' == $comment->comment_approved ) :

					?>
					<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.' ); ?></p>
					<?php

				endif;

				?>
			</div><!-- .comment-meta -->

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
			<?php

			comment_reply_link( array_merge( $args, array(
				'add_below' => 'div-comment',
				'depth'     => $depth,
				'max_depth' => $args['max_depth'],
				'before'    => '<div class="reply">',
				'after'     => '</div>',
			)));

			?>
		</article><!-- .comment-body -->
		<?php
	}
}
