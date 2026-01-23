<?php

/**
 * Template for the main landing page (Home)
 */
?>

<?php get_header(); ?>

<div class="homepage-header">
    <?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_clients-marquee.php'); ?>
</div>

<?php
while (have_posts()) :
    the_post();
    the_content();
endwhile;
?>



<?php get_footer(); ?>