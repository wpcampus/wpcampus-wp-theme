<?php

// Template Name: Show Me The Interest

get_header();

?><div class="row">
    <div class="small-12 columns"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras risus urna, ullamcorper in ullamcorper in, dapibus vel leo. Nam diam odio, aliquam quis accumsan a, viverra non sem. Pellentesque non fringilla sapien.</p></div>
    <div class="small-12 columns">
        <?php echo do_shortcode( '[gravityform id="1" title="false" description="false" ajax="true"]' ); ?>
    </div>
</div><?php

get_footer();