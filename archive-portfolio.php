<?php

/**
 * The template for displaying the main Portfolio archive (list of all cases)
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<?php

$portfolio_page_id = 317;

if ($portfolio_page_id) {
    $content = get_post_field('post_content', $portfolio_page_id);
    echo apply_filters('the_content', $content);
}
?>


<?php get_footer(); ?>