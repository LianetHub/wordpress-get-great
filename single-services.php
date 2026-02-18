<?php

/**
 * The template for displaying a single service detail page
 */
?>

<?php get_header(); ?>


<?php require_once(TEMPLATE_PATH . '_promo-services.php'); ?>
<?php
while (have_posts()) :
    the_post();
    the_content();
endwhile;
?>

<?php get_footer(); ?>