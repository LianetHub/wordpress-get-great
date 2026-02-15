<?php

/**
 * The template for displaying specific service portfolio pages 
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<?php require_once(TEMPLATE_PATH . '_cases-grid.php'); ?>

<?php
$donor = get_page_by_path('portfolio-details');
if ($donor) {
    echo '<div class="portfolio-global-content">';
    echo apply_filters('the_content', $donor->post_content);
    echo '</div>';
}
?>



<?php get_footer(); ?>