<?php

require_once('includes/admin-custom.php');
require_once('includes/my-guttenberg-blocks.php');
require_once('includes/acf-custom.php');
require_once('includes/post-types.php');
require_once('includes/custom-menu.php');

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
	wp_enqueue_script('jquery', get_template_directory_uri() . '/assets/js/libs/jquery-4.0.0.min.js', array(), null, true);
	wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/js/libs/swiper-bundle.min.js', array(), null, true);
	wp_enqueue_script('fancybox-js', get_template_directory_uri() . '/assets/js/libs/fancybox.umd.js', array(), null, true);
	wp_enqueue_script('app-js', get_template_directory_uri() . '/assets/js/app.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'theme_enqueue_scripts');


// =========================================================================
// 3. THEME SUPPORT AND UTILITIES
// =========================================================================

add_action('after_setup_theme', function () {
	add_theme_support('post-thumbnails');
});

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

// запрет висячих строк
function fix_widows_after_prepositions($text)
{
	if (empty($text) || !is_string($text)) {
		return $text;
	}

	$prepositions = [
		'в',
		'и',
		'или',
		'к',
		'с',
		'на',
		'у',
		'о',
		'от',
		'для',
		'за',
		'по',
		'без',
		'из',
		'над',
		'под',
		'при',
		'про',
		'через',
		'об',
		'со'
	];

	$pattern = implode('|', array_map('preg_quote', $prepositions));
	$regex = '/\b(' . $pattern . ')\s+/iu';

	return preg_replace_callback($regex, function ($matches) {
		return $matches[1] . "\xC2\xA0";
	}, $text);
}

add_filter('the_content', 'fix_widows_after_prepositions', 99);
add_filter('the_title', 'fix_widows_after_prepositions', 99);
add_filter('the_excerpt', 'fix_widows_after_prepositions', 99);
add_filter('widget_text_content', 'fix_widows_after_prepositions', 99);
add_filter('acf/format_value', 'fix_widows_after_prepositions', 99, 3);


add_filter('wpseo_breadcrumb_separator', '__return_empty_string');

// FORM SUBMITTING
require_once('includes/form-submitting.php');

// pagination
function get_great_pagination_class_filter($template)
{
	$template = str_replace('page-numbers', 'pagination__item', $template);
	$template = str_replace('current', 'active', $template);

	$template = str_replace('prev pagination__item', 'pagination__prev icon-arrow-left', $template);
	$template = str_replace('next pagination__item', 'pagination__next icon-arrow-right', $template);

	return $template;
}
add_filter('paginate_links', 'get_great_pagination_class_filter');

add_filter('next_posts_link_attributes', 'posts_link_attributes');
add_filter('previous_posts_link_attributes', 'posts_link_attributes');

function posts_link_attributes()
{
	return 'class="pagination__item"';
}

function custom_prev_class($format)
{
	return str_replace('href=', 'class="pagination__prev icon-arrow-left" href=', $format);
}
add_filter('previous_posts_link_attributes', function () {
	return 'class="pagination__prev icon-arrow-left"';
});
add_filter('next_posts_link_attributes', function () {
	return 'class="pagination__next icon-arrow-right"';
});

// время чтения в минутах для поста
function get_great_reading_time($post_id = null, $wpm = 10, $seconds_per_image = 5)
{
	$post_id = $post_id ?: get_the_ID();

	// 1. Берём «сырое» содержимое и сразу прогоняем сквозь фильтры → HTML
	$html = apply_filters('the_content', get_post_field('post_content', $post_id));

	// 2. Считаем слова (wp_strip_all_tags убирает HTML, шорткоды, комментарии)
	$words = str_word_count(wp_strip_all_tags($html));

	// 3. Считаем картинки
	preg_match_all('/<img\b[^>]*>/i', $html, $matches);
	$images = count($matches[0]);

	// Переводим «картинки‑в‑секунды» в «дополнительные слова»
	$words += ($images * $seconds_per_image) * $wpm / 60;

	return max(1, (int) ceil($words / $wpm));
}

function get_great_the_reading_time($before = '', $after = ' мин. читать')
{
	printf(
		'%s%d%s',
		$before,
		get_great_reading_time(),
		$after
	);
}

// Просмотры статьи
function get_great_set_post_views($postID)
{
	$count_key = 'get_great_post_views';
	$count     = get_post_meta($postID, $count_key, true);

	if ($count == '') {
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, 1);
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}

function get_great_get_post_views($postID)
{
	$count = get_post_meta($postID, 'get_great_post_views', true);
	return $count ? (int) $count : 0;
}


// Лайки статьи
function get_great_add_like()
{
	if (! isset($_POST['post_id']) || ! is_numeric($_POST['post_id'])) {
		wp_send_json_error();
	}

	$post_id = (int) $_POST['post_id'];

	$current_likes = (int) get_post_meta($post_id, 'get_great_likes', true);
	$current_likes++;
	update_post_meta($post_id, 'get_great_likes', $current_likes);

	wp_send_json_success(['likes' => $current_likes]);
}
add_action('wp_ajax_get_great_add_like', 'get_great_add_like');
add_action('wp_ajax_nopriv_get_great_add_like', 'get_great_add_like');


function get_great_transliterate($text)
{
	$cyr = [
		'а',
		'б',
		'в',
		'г',
		'д',
		'е',
		'ё',
		'ж',
		'з',
		'и',
		'й',
		'к',
		'л',
		'м',
		'н',
		'о',
		'п',
		'р',
		'с',
		'т',
		'у',
		'ф',
		'х',
		'ц',
		'ч',
		'ш',
		'щ',
		'ъ',
		'ы',
		'ь',
		'э',
		'ю',
		'я',
		'А',
		'Б',
		'В',
		'Г',
		'Д',
		'Е',
		'Ё',
		'Ж',
		'З',
		'И',
		'Й',
		'К',
		'Л',
		'М',
		'Н',
		'О',
		'П',
		'Р',
		'С',
		'Т',
		'У',
		'Ф',
		'Х',
		'Ц',
		'Ч',
		'Ш',
		'Щ',
		'Ъ',
		'Ы',
		'Ь',
		'Э',
		'Ю',
		'Я'
	];
	$lat = [
		'a',
		'b',
		'v',
		'g',
		'd',
		'e',
		'io',
		'zh',
		'z',
		'i',
		'y',
		'k',
		'l',
		'm',
		'n',
		'o',
		'p',
		'r',
		's',
		't',
		'u',
		'f',
		'h',
		'ts',
		'ch',
		'sh',
		'shb',
		'',
		'y',
		'',
		'e',
		'yu',
		'ya',
		'a',
		'b',
		'v',
		'g',
		'd',
		'e',
		'io',
		'zh',
		'z',
		'i',
		'y',
		'k',
		'l',
		'm',
		'n',
		'o',
		'p',
		'r',
		's',
		't',
		'u',
		'f',
		'h',
		'ts',
		'ch',
		'sh',
		'shb',
		'',
		'y',
		'',
		'e',
		'yu',
		'ya'
	];

	$text = str_replace($cyr, $lat, $text);
	return sanitize_title($text);
}

function get_great_content_with_toc($content)
{
	$toc_list = '';

	$content = preg_replace_callback('/<h([2])(.*?)>(.*?)<\/h\1>/i', function ($matches) use (&$toc_list) {
		$tag = $matches[1];
		$attrs = $matches[2];
		$title_html = $matches[3];
		$title_text = strip_tags($title_html);

		$slug = get_great_transliterate($title_text);

		if (!$slug) {
			$slug = 'heading-' . mt_rand(1000, 9999);
		}

		$indent_class = ($tag === '3') ? ' sidebar__link--indent' : '';
		$toc_list .= '<li><a href="#' . $slug . '" class="sidebar__link' . $indent_class . '">' . $title_text . '</a></li>';

		return '<h' . $tag . $attrs . ' id="' . $slug . '">' . $title_html . '</h' . $tag . '>';
	}, $content);

	return [
		'content' => $content,
		'toc'     => $toc_list
	];
}
