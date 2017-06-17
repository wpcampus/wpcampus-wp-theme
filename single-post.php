<?php

/**
 * Add the AddThis bar before the blog post.
 */
function wpcampus_blog_add_addthis() {

	?>
	<div class="addthis_sharing_toolbox"></div>
	<?php
}
add_action( 'wpcampus_before_article_content', 'wpcampus_blog_add_addthis' );

/**
 * Add contributor info after articles.
 */
function wpcampus_blog_add_contributor() {
	wpcampus_print_contributor();
}
add_action( 'wpcampus_after_article', 'wpcampus_blog_add_contributor' );

/**
 * Add disclaimer to end of blog posts.
 *
 * // @TODO
 * - Add message and link to "submit a topic".
 * - Add author description.
 */
function wpcampus_blog_add_disclaimer() {

	?>
	<hr />
	<p class="article-disclaimer">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque laoreet pellentesque sem eget rhoncus. Praesent commodo nulla vel urna commodo, non commodo nunc egestas. Etiam iaculis placerat lacus vitae pharetra. Aliquam metus turpis, placerat sed enim non, egestas varius nulla. Pellentesque finibus orci vel congue sodales. Ut laoreet quis ipsum porta aliquam. Aliquam non tempor massa, et bibendum quam. In ornare eros quis lorem gravida suscipit. Vivamus accumsan ligula ut erat convallis, vel faucibus purus iaculis. Praesent sodales ullamcorper nibh, rutrum porttitor lectus varius nec. Duis in fermentum metus. Phasellus vulputate sit amet tortor nec lobortis. Praesent id purus orci.</p>
	<?php
}
//add_action( 'wpcampus_after_article_content', 'wpcampus_blog_add_disclaimer' );

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
