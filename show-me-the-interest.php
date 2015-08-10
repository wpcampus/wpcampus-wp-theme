<?php

// Template Name: Show Me The Interest

// Add the AddThis script
add_action( 'wp_footer', function() {
    ?><script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-55c7ed90ac8a8479" async="async"></script><?php
});

get_header();

?><div id="wordcampus-show-me-the-interest-page">

    <div id="wordcampus-header">
        <div class="container">
            <a href="<?php echo get_bloginfo('url'); ?>">
                <h1 class="wordcampus-word">WordCampus:</h1>
                <img class="wordcampus-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/wordcampus.svg" />
            </a>
            <h2>Using WordPress In The World of Higher Education</h2>
        </div>
    </div>

    <div id="wordcampus-main">
        <div class="container">

            <div class="body">

                <div class="addthis_sharing_toolbox"></div><?php

                if ( have_posts() ) {
                    while ( have_posts() ) {
                        the_post();

                        the_content();

                    }

                }

            ?></div>

            <div class="footer">
                <div class="addthis_sharing_toolbox"></div>
                <h3>About The Photos</h3>
                <p>The photos included on this page were given, with permission, by wonderful individuals in the higher ed community who wanted to help me show off the beauty of college campuses. Their presence does not imply that the pictured institutions are associated with this (possible) event but I definitely would not complain if they wanted to <a href="https://twitter.com/bamadesigner">reach out to me</a> to show their support or get involved.</p>
                <p>With that said, I wanted to list which universities are included in the photo grid. I'd love to add more photos, specifically of universities that are using WordPress, so <a href="https://twitter.com/bamadesigner">let me know</a> if you'd like me to add a photo of your beautiful campus (and if you use WordPress) and I'll see what I can do.</p>
                <p><em>Starting from the top left and going from left to right:</em></p>
                <ol class="univ-for-photos">
                    <li><a href="http://www.umw.edu/">University of Mary Washington</a></li>
                    <li><a href="http://www.bu.edu/">Boston University</a></li>
                    <li><a href="http://www.virginia.edu/">University of Virginia</a></li>
                    <li><a href="http://www.syr.edu/">Syracuse University</a></li>
                    <li><a href="http://ua.edu">The University of Alabama</a></li>
                    <li><a href="http://www.ufl.edu/">The University of Florida</a></li>
                    <li><a href="http://www.bu.edu/">Boston University</a></li>
                    <li><a href="http://www.umw.edu/">University of Mary Washington</a></li>
                    <li><a href="http://www.muw.edu/">Mississippi University for Women</a></li>
                    <li><a href="http://www.bu.edu/">Boston University</a></li>
                    <li><a href="http://www.fiu.edu/">Florida International University</a></li>
                    <li><a href="http://www.umw.edu/">University of Mary Washington</a></li>
                    <li><a href="http://www.hsu.edu/">Henderson State University</a></li>
                    <li><a href="http://ua.edu">The University of Alabama</a></li>
                    <li><a href="http://www.columbia.edu/">Columbia University</a></li>
                    <li><a href="http://www.syr.edu/">Syracuse University</a></li>
                </ol>
            </div>

        </div>
    </div>
</div> <!-- #wordcampus-interest --><?php

get_footer();