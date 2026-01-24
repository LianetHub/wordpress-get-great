<?php

add_action('init', 'register_custom_entities');
function register_custom_entities()
{
    register_taxonomy('service_cat', 'services', [
        'labels' => [
            'name'              => 'Категории услуг',
            'singular_name'     => 'Категория услуги',
            'search_items'      => 'Искать категории услуг',
            'all_items'         => 'Все категории услуг',
            'parent_item'       => 'Родительская категория услуги',
            'parent_item_colon' => 'Родительская категория услуги:',
            'edit_item'         => 'Изменить категорию услуги',
            'update_item'       => 'Обновить категорию услуги',
            'add_new_item'      => 'Добавить новую категорию услуг',
            'new_item_name'     => 'Название новой категории услуг',
            'menu_name'         => 'Категории услуг',
            'back_to_items'     => '← Назад к категориям услуг',
        ],
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'uslugi', 'with_front' => false],
    ]);

    register_post_type('services', [
        'labels' => [
            'name'               => 'Услуги',
            'singular_name'      => 'Услуга',
            'add_new'            => 'Добавить услугу',
            'add_new_item'       => 'Добавить новую услугу',
            'edit_item'          => 'Редактировать услугу',
            'new_item'           => 'Новая услуга',
            'view_item'          => 'Посмотреть услугу',
            'search_items'       => 'Искать услуги',
            'not_found'          => 'Услуг не найдено',
            'not_found_in_trash' => 'В корзине услуг не найдено',
            'menu_name'          => 'Услуги',
        ],
        'public'             => true,
        'has_archive'        => 'uslugi',
        'menu_icon'          => 'dashicons-admin-tools',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'            => ['slug' => 'uslugi/%service_cat%', 'with_front' => false],
        'show_in_rest'       => true,
    ]);

    register_taxonomy('portfolio_cat', 'portfolio', [
        'labels' => [
            'name'              => 'Категории портфолио',
            'singular_name'     => 'Категория портфолио',
            'search_items'      => 'Искать категории портфолио',
            'all_items'         => 'Все категории портфолио',
            'parent_item'       => 'Родительская категория портфолио',
            'parent_item_colon' => 'Родительская категория портфолио:',
            'edit_item'         => 'Изменить категорию портфолио',
            'update_item'       => 'Обновить категорию портфолио',
            'add_new_item'      => 'Добавить новую категорию портфолио',
            'new_item_name'     => 'Название новой категории портфолио',
            'menu_name'         => 'Категории портфолио',
            'back_to_items'     => '← Назад к категориям портфолио',
        ],
        'hierarchical'      => true,
        'show_in_rest'      => true,
        'rewrite'           => ['slug' => 'portfolio', 'with_front' => false],
    ]);

    register_post_type('portfolio', [
        'labels' => [
            'name'               => 'Портфолио',
            'singular_name'      => 'Проект',
            'add_new'            => 'Добавить проект',
            'add_new_item'       => 'Добавить новую проект',
            'edit_item'          => 'Редактировать проект',
            'new_item'           => 'Новый проект',
            'view_item'          => 'Посмотреть проект',
            'search_items'       => 'Искать в портфолио',
            'not_found'          => 'Проектов не найдено',
            'not_found_in_trash' => 'В корзине проектов не найдено',
            'menu_name'          => 'Портфолио',
        ],
        'public'             => true,
        'has_archive'        => true,
        'menu_icon'          => 'dashicons-format-gallery',
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite'            => ['slug' => 'portfolio/%portfolio_cat%', 'with_front' => false],
        'show_in_rest'       => true,
    ]);
}

add_filter('post_type_link', 'custom_taxonomy_permalinks', 10, 2);
function custom_taxonomy_permalinks($post_link, $post)
{
    if ($post->post_type === 'services' && strpos($post_link, '%service_cat%') !== false) {
        $terms = get_the_terms($post->ID, 'service_cat');
        if (!empty($terms) && !is_wp_error($terms)) {
            return str_replace('%service_cat%', $terms[0]->slug, $post_link);
        } else {
            return str_replace('%service_cat%', 'general', $post_link);
        }
    }

    if ($post->post_type === 'portfolio' && strpos($post_link, '%portfolio_cat%') !== false) {
        $terms = get_the_terms($post->ID, 'portfolio_cat');
        if (!empty($terms) && !is_wp_error($terms)) {
            return str_replace('%portfolio_cat%', $terms[0]->slug, $post_link);
        } else {
            return str_replace('%portfolio_cat%', 'uncategorized', $post_link);
        }
    }

    return $post_link;
}

add_filter('nav_menu_link_attributes', 'fix_custom_menu_links', 10, 2);
function fix_custom_menu_links($atts, $item)
{
    if (isset($atts['href']) && strpos($atts['href'], '%service_cat%') !== false) {
        $terms = get_the_terms($item->object_id, 'service_cat');
        if (!empty($terms) && !is_wp_error($terms)) {
            $atts['href'] = str_replace('%service_cat%', $terms[0]->slug, $atts['href']);
        } else {
            $atts['href'] = str_replace('%service_cat%/', '', $atts['href']);
        }
    }

    if (isset($atts['href']) && strpos($atts['href'], '%portfolio_cat%') !== false) {
        $terms = get_the_terms($item->object_id, 'portfolio_cat');
        if (!empty($terms) && !is_wp_error($terms)) {
            $atts['href'] = str_replace('%portfolio_cat%', $terms[0]->slug, $atts['href']);
        } else {
            $atts['href'] = str_replace('%portfolio_cat%/', '', $atts['href']);
        }
    }

    return $atts;
}

add_filter('post_type_archive_link', 'fix_cpt_archive_links', 10, 2);
function fix_cpt_archive_links($link, $post_type)
{
    if ($post_type === 'services') {
        return str_replace('%service_cat%/', '', $link);
    }

    if ($post_type === 'portfolio') {
        return str_replace('%portfolio_cat%/', '', $link);
    }

    return $link;
}

add_action('init', 'register_custom_archive_rules');
function register_custom_archive_rules()
{
    add_rewrite_rule(
        '^uslugi/?$',
        'index.php?post_type=services',
        'top'
    );

    add_rewrite_rule(
        '^portfolio/?$',
        'index.php?post_type=portfolio',
        'top'
    );
}

add_action('init', 'modify_blog_settings');
function modify_blog_settings()
{
    global $wp_rewrite;
    $wp_rewrite->extra_permastructs['category']['struct'] = 'blog/%category%';

    add_rewrite_rule(
        '^blog/([^/]+)/([^/]+)/?$',
        'index.php?name=$matches[2]',
        'top'
    );
}

add_filter('post_link', 'custom_blog_post_link', 10, 2);
function custom_blog_post_link($post_link, $post)
{
    if ($post->post_type === 'post') {
        $categories = get_the_category($post->ID);
        if (!empty($categories)) {
            $category_slug = $categories[0]->slug;
            return home_url("blog/{$category_slug}/{$post->post_name}/");
        }
    }
    return $post_link;
}

add_action('init', 'customize_standard_taxonomy_labels');
function customize_standard_taxonomy_labels()
{
    global $wp_taxonomies;
    if (isset($wp_taxonomies['category'])) {
        $labels = &$wp_taxonomies['category']->labels;
        $labels->name = 'Категории статей';
        $labels->singular_name = 'Категория статей';
        $labels->add_new_item = 'Добавить новую категорию статей';
        $labels->edit_item = 'Изменить категорию статей';
        $labels->new_item_name = 'Название новой категории статей';
        $labels->search_items = 'Искать категории статей';
        $labels->all_items = 'Все категории статей';
        $labels->menu_name = 'Категории статей';
    }
    if (taxonomy_exists('post_tag')) {
        register_taxonomy('post_tag', array());
    }
}

add_filter('get_the_archive_title', 'custom_archive_title');
function custom_archive_title($title)
{
    if (is_home()) {
        $title = 'Полезные статьи';
    } elseif (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }

    return $title;
}


add_action('admin_bar_menu', 'add_edit_services_donor_link', 999);
function add_edit_services_donor_link($wp_admin_bar)
{
    if (!is_admin() && is_post_type_archive('services')) {
        $donor_page = get_page_by_path('uslugi-details');

        if ($donor_page) {
            $wp_admin_bar->add_node([
                'id'    => 'edit',
                'title' => 'Редактировать контент услуг',
                'href'  => get_edit_post_link($donor_page->ID),
                'meta'  => [
                    'class' => 'ab-item',
                ],
            ]);
        }
    }
}

add_action('template_redirect', 'redirect_donor_page_to_archive');
function redirect_donor_page_to_archive()
{
    if (is_single('uslugi-details') || is_page('uslugi-details')) {
        wp_redirect(get_post_type_archive_link('services'), 301);
        exit;
    }
}

add_filter('pre_get_posts', 'exclude_donor_from_search');
function exclude_donor_from_search($query)
{
    if (!is_admin() && $query->is_main_query() && $query->is_search()) {
        $donor = get_page_by_path('uslugi-details');
        if ($donor) {
            $query->set('post__not_in', [$donor->ID]);
        }
    }
    return $query;
}
