<?php

/**
 * Template Name: WPCampus: Library
 */

// Setup sessions.
wpcampus_network_enable( 'sessions' );
add_action( 'wpcampus_after_article_content', 'wpcampus_print_sessions' );

get_template_part( 'index' );
