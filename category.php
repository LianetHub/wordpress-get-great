<?php

/**
 * The template for the blog category (Blog Category)
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>
<?php require_once(TEMPLATE_PATH . '_blog.php'); ?>

<?php
$blog_page_id = get_option('page_for_posts');

if ($blog_page_id) {
    $blog_page_content = get_post_field('post_content', $blog_page_id);
    if (!empty($blog_page_content)) {
        echo '<div class="category-global-content">';
        echo apply_filters('the_content', $blog_page_content);
        echo '</div>';
    }
}
?>

<?php get_footer(); ?>