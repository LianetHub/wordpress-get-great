<?php

require_once('includes/admin-custom.php');
require_once('includes/acf-custom.php');

// =========================================================================
// 1. CONSTANTS
// =========================================================================

define('TEMPLATE_PATH', dirname(__FILE__) . '/templates/');

// =========================================================================
// 2. ENQUEUE STYLES AND SCRIPTS
// =========================================================================

add_theme_support('title-tag');

// Enqueue theme styles (CSS)
function theme_enqueue_styles()
{
	wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/libs/swiper-bundle.min.css');
	wp_enqueue_style('fancybox', get_template_directory_uri() . '/assets/css/libs/fancybox.css');
	wp_enqueue_style('reset', get_template_directory_uri() . '/assets/css/reset.min.css');
	wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.min.css');
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


// Enqueue theme scripts (JS)
function theme_enqueue_scripts()
{
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/libs/jquery-3.7.1.min.js', array(), null, true);
	wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/js/libs/swiper-bundle.min.js', array(), null, true);
	wp_enqueue_script('fancybox-js', get_template_directory_uri() . '/assets/js/libs/fancybox.umd.js', array(), null, true);
	wp_enqueue_script('app-js', get_template_directory_uri() . '/assets/js/app.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


// =========================================================================
// 3. THEME SUPPORT AND UTILITIES
// =========================================================================


function load_env_configs($path)
{
	if (!file_exists($path)) return;

	$lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach ($lines as $line) {
		if (strpos(trim($line), '#') === 0) continue;
		list($name, $value) = explode('=', $line, 2);
		$_ENV[trim($name)] = trim($value);
	}
}

load_env_configs(ABSPATH . '.env');

// Allow SVG file uploads
function allow_svg_uploads($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');


// Register navigation menus
add_action('after_setup_theme', 'theme_register_nav_menu');

function theme_register_nav_menu()
{
	register_nav_menus([
		'primary_menu' => 'Главное меню (в шапке)',
		'footer_menu'  => 'Меню в подвале (политики)'
	]);
}

add_filter('wp_get_nav_menu_items', 'append_dynamic_menu_items', 10, 3);
function append_dynamic_menu_items($items, $menu, $args)
{
	if (is_admin()) return $items;

	foreach ($items as $item) {

		if ($item->title == 'Услуги') {
			$terms = get_terms(['taxonomy' => 'service_cat', 'hide_empty' => false]);
			foreach ($terms as $term) {
				$term->menu_item_parent = $item->ID;
				$term->db_id = 0;
				$term->ID = 's-cat-' . $term->term_id;
				$term->object_id = $term->term_id;
				$term->object = 'service_cat';
				$term->type = 'taxonomy';
				$term->url = get_term_link($term);
				$term->title = $term->name;
				$items[] = $term;
			}
		}

		if ($item->title == 'Портфолио') {
			$terms = get_terms(['taxonomy' => 'portfolio_cat', 'hide_empty' => false]);
			foreach ($terms as $term) {
				$term->menu_item_parent = $item->ID;
				$term->db_id = 0;
				$term->ID = 'p-cat-' . $term->term_id;
				$term->object_id = $term->term_id;
				$term->object = 'portfolio_cat';
				$term->type = 'taxonomy';
				$term->url = get_term_link($term);
				$term->title = $term->name;
				$items[] = $term;
			}
		}

		if ($item->title == 'Блог') {
			$categories = get_categories(['hide_empty' => false]);
			foreach ($categories as $cat) {
				$cat->menu_item_parent = $item->ID;
				$cat->db_id = 0;
				$cat->ID = 'blog-cat-' . $cat->term_id;
				$cat->object_id = $cat->term_id;
				$cat->object = 'category';
				$cat->type = 'taxonomy';
				$cat->url = get_category_link($cat->term_id);
				$cat->title = $cat->name;
				$items[] = $cat;
			}
		}
	}

	return $items;
}

// убираем с фронта ненужную инфу в хедере
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');

remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);

// Выключаем xmlrpc, ибо дыра
add_filter('xmlrpc_enabled', '__return_false');


// Убираем из панели админки лого вп и обновления
function remove_admin_bar_links()
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('updates');
}
add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');

//фикс ошибок микроразметки
add_filter('disable_wpseo_json_ld_search', '__return_true');


function add_preloading_body_class($classes)
{
	$classes[] = 'preloading';
	return $classes;
}
add_filter('body_class', 'add_preloading_body_class');


function currentYear()
{
	return date('Y');
}



// Custom Posts
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
		'rewrite'           => ['slug' => 'services', 'with_front' => false],
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
		'has_archive'        => true,
		'menu_icon'          => 'dashicons-admin-tools',
		'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
		'rewrite'            => ['slug' => 'services/%service_cat%', 'with_front' => false],
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
			'add_new_item'       => 'Добавить новый проект',
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
	if ($post->post_type === 'services') {
		$terms = get_the_terms($post->ID, 'service_cat');
		if (!empty($terms)) {
			return str_replace('%service_cat%', $terms[0]->slug, $post_link);
		} else {
			return str_replace('%service_cat%', 'general', $post_link);
		}
	}

	if ($post->post_type === 'portfolio') {
		$terms = get_the_terms($post->ID, 'portfolio_cat');
		if (!empty($terms)) {
			return str_replace('%portfolio_cat%', $terms[0]->slug, $post_link);
		} else {
			return str_replace('%portfolio_cat%', 'uncategorized', $post_link);
		}
	}

	return $post_link;
}


// Article Blog fix
add_action('init', 'modify_base_post_settings');
function modify_base_post_settings()
{
	global $wp_rewrite;

	$wp_rewrite->extra_permastructs['category']['struct'] = 'blog/%category%';
}

add_action('init', 'fix_blog_single_rewrite_rules');
function fix_blog_single_rewrite_rules()
{
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


	$labels = &$wp_taxonomies['category']->labels;
	$labels->name = 'Категории статей';
	$labels->singular_name = 'Категория статей';
	$labels->add_new_item = 'Добавить новую категорию статей';
	$labels->edit_item = 'Изменить категорию статей';
	$labels->new_item_name = 'Название новой категории статей';
	$labels->search_items = 'Искать категории статей';
	$labels->all_items = 'Все категории статей';
	$labels->menu_name = 'Категории статей';

	register_taxonomy('post_tag', array());
}



// FORM SUBMIT CONFIG
