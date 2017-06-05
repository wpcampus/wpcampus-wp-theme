<?php
	
$stylesheet_dir = get_stylesheet_directory_uri();
$images_dir = "{$stylesheet_dir}/assets/images/";

?>
            </div> <!-- .columns -->
        </div> <!-- .row -->
    </div> <!-- #wpcampus-main -->

    <div id="wpcampus-footer">
        <div class="row">
            <div class="small-12 columns">
                <div class="addthis_sharing_toolbox"></div>
                <a class="wpc-logo"  href="https://wpcampus.org/"><img src="<?php echo $images_dir; ?>wpcampus-logo-tagline.svg" alt="WPCampus: Where WordPress Meets Higher Education" /></a>
                <ul class="wpc-footer-menu" role="navigation">
                    <li><a href="https://wpcampus.org/code-of-conduct/">Code of Conduct</a></li>
                    <li><a href="https://wpcampus.org/contact/">Contact Us</a></li>
                </ul>
                <p><strong>WPCampus is a community of networking, resources, and events for those using WordPress in the world of higher education.</strong><br />If you are not already a member of the WPCampus community, we'd love for you to <a href="https://wpcampus.org/get-involved/">get involved</a>.<br />
                <span class="github-message">This site is powered by <a href="https://wordpress.org/">WordPress</a>. You can view, and contribute to, the theme on <a href="https://github.com/wpcampus/wpcampus-wp-theme">GitHub</a>.</span></p>
                <p class="icons">
                    <a class="twitter" href="https://twitter.com/wpcampusorg"><img src="<?php echo $images_dir; ?>twitter-black.svg" alt="Follow WPCampus on Twitter" /></a>
                    <a class="facebook" href="https://www.facebook.com/wpcampus"><img src="<?php echo $images_dir; ?>facebook-black.svg" alt="Follow WPCampus on Twitter" /></a>
                    <a class="youtube" href="https://www.youtube.com/wpcampusorg"><img src="<?php echo $images_dir; ?>youtube-black.svg" alt="Follow WPCampus on YouTube" /></a>
                    <a class="github" href="https://github.com/wpcampus/"><img src="<?php echo $images_dir; ?>github-black.svg" alt="Follow WPCampus on GitHub" /></a>
                </p>
                <p class="copyright">&copy; <?php echo date( 'Y' ); ?> WPCampus</p>
            </div>
        </div>
    </div> <!-- #wpcampus-footer -->

    <?php wp_footer(); ?>

    </body>
</html>