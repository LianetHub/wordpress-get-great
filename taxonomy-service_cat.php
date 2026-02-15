<?php

/**
 * The template for displaying specific service category pages (e.g., Branding, Stands)
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>
<?php
while (have_posts()) :
    the_post();
    the_content();
endwhile;
?>


<?php get_footer(); ?>