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

            <div class="body"><?php

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
                <div class="photos-hidden-message">
                    <p>Well, actually, you can't see the photos because your screen is rather small and I thought it best to focus on the content instead.</p>
                    <p>If you view this page on a larger screen, you'll be able to see a lovely photo grid, filled with images of beautiful college campuses.</p>
                </div>
                <div class="photos-visible-message">
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
                        <li><a href="http://www.champlain.edu/">Champlain College</a></li>
                        <li><a href="http://www.columbia.edu/">Columbia University</a></li>
                        <li><a href="https://wayne.edu/">Wayne State University</a></li>
                    </ol>
                </div>
                <h3>About Me</h3>
                <p>My name is Rachel Carden. I’m a web designer and developer for <a href="http://ua.edu/">The University of Alabama</a>. If you'd like to talk more about WordCampus, you can find me on Twitter <a href="https://twitter.com/bamadesigner">@bamadesigner</a>, send me an <a href="mailto:bamadesigner@gmail.com">email</a>, or visit me at <a href="http://bamadesigner.com/">http://bamadesigner.com</a>.</p>
                <h3>About My Proposal</h3>
                <p>For more details about my proposal, head over to Post Status and read <a href="https://poststatus.com/wordpress-higher-ed-conference-wordcampus/">A WordPress conference for higher education: coming to a campus near you?</a>. If you have any ideas, comments, or suggestions, I invite you to leave them in the comments.</p>
            </div>

        </div>
    </div>
</div> <!-- #wordcampus-interest --><?php

get_footer();