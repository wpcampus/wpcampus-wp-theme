<?php

get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();

        if ( ! is_front_page() ) {
            ?><h1><?php the_title(); ?></h1><?php
        }

        the_content();

    }

}

get_footer();