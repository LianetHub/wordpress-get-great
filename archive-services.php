<?php

/**
 * The template for displaying the main Services archive (list of services)
 */
?>
<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<?php
$donor = get_page_by_path('uslugi-details');
if ($donor) {
    $content = apply_filters('the_content', $donor->post_content);
    echo $content;
}
?>

<?php get_footer(); ?>