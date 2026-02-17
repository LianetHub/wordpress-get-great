<?php

/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package get_great
 */



add_filter('block_categories_all', 'custom_block_category', 10, 2);
function custom_block_category($categories, $post)
{
    return array_merge(
        [
            [
                'slug'  => 'pp-category',
                'title' => __('Блоки в Статье Get Great', 'txtdomain'),
                'icon'  => 'star-filled',
            ],
        ],
        $categories
    );
}

add_action('acf/init', function () {
    if (function_exists('acf_register_block_type')) {

        acf_register_block_type([
            'name'            => 'rec',
            'title'           => __('Статья по теме', 'txtdomain'),
            'category'        => 'pp-category',
            'icon'            => 'admin-links',
            'render_template' => 'templates/blog-blocks/rec-article.php',
            'mode'            => 'edit',
        ]);

        acf_register_block_type([
            'name'            => 'blockquote',
            'title'           => __('Цитата с автором', 'txtdomain'),
            'category'        => 'pp-category',
            'icon'            => 'format-quote',
            'render_template' => 'templates/blog-blocks/blockquote-article.php',
            'mode'            => 'edit',
        ]);

        acf_register_block_type([
            'name'            => 'items-article',
            'title'           => __('Иконки с текстом', 'txtdomain'),
            'category'        => 'pp-category',
            'icon'            => 'grid-view',
            'render_template' => 'templates/blog-blocks/items-article.php',
            'mode'            => 'edit',
        ]);

        acf_register_block_type([
            'name'            => 'accordion-article',
            'title'           => __('Аккордион', 'txtdomain'),
            'category'        => 'pp-category',
            'icon'            => 'list-view',
            'render_template' => 'templates/blog-blocks/accordion-article.php',
            'mode'            => 'edit',
        ]);

        acf_register_block_type([
            'name'            => 'slider-article',
            'title'           => __('Слайдер', 'txtdomain'),
            'category'        => 'pp-category',
            'icon'            => 'images-alt2',
            'render_template' => 'templates/blog-blocks/slider-article.php',
            'mode'            => 'edit',

        ]);
    }
});
