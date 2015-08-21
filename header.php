<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php wp_title( '-', true, 'left' ); ?></title>

    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>

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