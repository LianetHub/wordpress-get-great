<?php

/**
 * The template for the blog posts index (Blog)
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<?php
$blog_page_id = get_option('page_for_posts');

if ($blog_page_id) {
    $blog_page_content = get_post_field('post_content', $blog_page_id);

    echo apply_filters('the_content', $blog_page_content);
}
?>




<?php get_footer(); ?>