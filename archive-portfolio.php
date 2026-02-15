<?php

/**
 * The template for displaying the main Portfolio archive (list of all cases)
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<?php
$donor = get_page_by_path('portfolio-details');
$donor_id = $donor ? $donor->ID : null;

?>

<?php
if ($donor) {
    $content = apply_filters('the_content', $donor->post_content);
    echo $content;
}
?>



<?php get_footer(); ?>