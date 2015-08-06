<?php

// Template Name: Show Me The Interest

get_header();

?><div id="wordcampus-show-me-the-interest">
    <div class="row">
        <div class="small-12 columns">
            <h1>We Need A Header</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras risus urna, ullamcorper in ullamcorper in, dapibus vel leo. Nam diam odio, aliquam quis accumsan a, viverra non sem. Pellentesque non fringilla sapien.</p>
            <h2 class="form_header">Interested in WordCampus?</h2>
            <?php echo do_shortcode( '[gravityform id="1" title="false" description="false" ajax="true"]' ); ?>
        </div>
    </div>
</div> <!-- #wordcampus-interest --><?php

get_footer();