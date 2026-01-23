<?php

/**
 * The template for displaying the main Services archive (list of services)
 */
?>
<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<?php

$portfolio_page_id = 320;

if ($portfolio_page_id) {
    $content = get_post_field('post_content', $portfolio_page_id);
    echo apply_filters('the_content', $content);
}
?>


<?php get_footer(); ?>