<?php

if (function_exists('acf_add_options_page')) {
	acf_add_options_page([
		'page_title'    => 'Настройки темы',
		'menu_title'    => 'Настройки темы',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	]);

	acf_add_options_page([
		'page_title'    => 'Глобальные секции',
		'menu_title'    => 'Глобальные секции',
		'menu_slug'     => 'theme-general-settings2',
		'capability'    => 'edit_posts',
		'redirect'      => false
	]);
}

function render_global_block_notice($title)
{
	$url = admin_url('admin.php?page=theme-general-settings2');
	echo '
    <div class="global-block-notice">
        <div class="global-block-notice__title">Секция: ' . esc_html($title) . '</div>
        <div class="global-block-notice__text">Это глобальный блок. Редактирование данных доступно только на странице общих настроек.</div>
        <a href="' . $url . '" class="global-block-notice__link" target="_blank">Перейти к настройкам</a>
    </div>';
}

add_filter('block_categories_all', function ($categories) {
	array_unshift($categories, [
		'slug'  => 'custom-layout',
		'title' => 'Секции сайта',
		'icon'  => 'admin-appearance',
	]);
	return $categories;
});

add_action('acf/init', 'my_register_blocks');
function my_register_blocks()
{
	if (!function_exists('acf_register_block_type')) return;

	$blocks = [
		'presentation' => [
			'title' => 'Презентация',
			'desc'  => 'Глобальный блок презентации',
			'icon'  => 'media-document',
			'is_global_only' => true
		],
		'contacts' => [
			'title' => 'Контакты',
			'desc'  => 'Контактная информация',
			'icon'  => 'location-alt'
		],
		'faq' => [
			'title' => 'Частые вопросы',
			'desc'  => 'Список вопросов и ответов',
			'icon'  => 'format-chat'
		],
		'why' => [
			'title' => 'Почему выбирают нас',
			'desc'  => 'Блок преимуществ с иконками',
			'icon'  => 'yes',
		],
		'gratitudes' => [
			'title' => 'Благодарности',
			'desc'  => 'Слайдер с письмами благодарности',
			'icon'  => 'awards',
			'is_global_only' => true
		],
		'mission' => [
			'title' => 'Наша миссия',
			'desc'  => 'Секция миссии с колонками контента',
			'icon'  => 'awards',
		],
		'about' => [
			'title' => 'О компании',
			'desc'  => 'Секция с табами и изображениями',
			'icon'  => 'info'
		],
		'special-offer' => [
			'title' => 'Спецпредложение',
			'desc'  => 'Блок с акцией, карточками и изображением',
			'icon'  => 'star-filled',
		],
		'cases' => [
			'title' => 'Наши кейсы',
			'desc'  => 'Список проектов из портфолио',
			'icon'  => 'grid-view',
		],
		'services' => [
			'title' => 'Наши услуги',
			'desc'  => 'Секция услуг с выбором категорий и выводом проектов',
			'icon'  => 'screenoptions',
		],
		'clients' => [
			'title' => 'Наши клиенты',
			'desc'  => 'Секция с логотипами клиентов и кнопкой подгрузки',
			'icon'  => 'groups',
		],
		'clients-marquee' => [
			'title' => 'Наши клиенты (Бегущая строка)',
			'desc'  => 'Глобальный слайдер с логотипами клиентов',
			'icon'  => 'slides',
			'is_global_only' => true
		],
		'description' => [
			'title' => 'Описание (Что мы делаем)',
			'desc'  => 'Секция с заголовком и текстовым блоком',
			'icon'  => 'editor-alignleft',
		],
		'founder' => [
			'title' => 'Основатель',
			'desc'  => 'Секция с цитатой, фото и информацией об основателе',
			'icon'  => 'admin-users',
		],
		'numbers' => [
			'title' => 'О нас в цифрах',
			'desc'  => 'Секция со слайдером изображений и карточками показателей',
			'icon'  => 'performance',
		],
		'other-services' => [
			'title' => 'Другие услуги',
			'desc'  => 'Список ссылок на другие услуги',
			'icon'  => 'randomize',
		],
		'cards-block' => [
			'title' => 'Мы делаем (Карточки)',
			'desc'  => 'Сетка карточек с иконками, текстом и тултипами',
			'icon'  => 'layout',
		],
		'how-we-work' => [
			'title' => 'Как мы работаем',
			'desc'  => 'Этапы работы с нумерованным списком',
			'icon'  => 'editor-ol',
		],
		'licenses' => [
			'title' => 'Лицензии и сертификаты',
			'desc'  => 'Сетка изображений лицензий с названиями',
			'icon'  => 'awards',
		],
	];

	foreach ($blocks as $name => $settings) {
		$is_global_only = isset($settings['is_global_only']) && $settings['is_global_only'];

		acf_register_block_type([
			'name'            => $name,
			'title'           => $settings['title'],
			'description'     => $settings['desc'],
			'render_template' => "templates/_{$name}.php",
			'category'        => 'custom-layout',
			'icon'            => $settings['icon'],
			'mode'            => $is_global_only ? 'preview' : 'edit',
			'supports'        => [
				'align' => false,
				'jsx'   => true,
				'mode'  => !$is_global_only
			],
		]);
	}
}

add_filter('acf/load_value', 'force_source_value_on_options_page', 10, 3);
function force_source_value_on_options_page($value, $post_id, $field)
{
	if (strpos($field['name'], '_source') !== false && $post_id === 'options') {
		if (is_admin() && function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if ($screen && strpos($screen->id, 'theme-general-settings2') !== false) {
				return 'local';
			}
		}
	}
	return $value;
}


add_filter('allowed_block_types_all', function ($allowed_blocks, $editor_context) {
	if ($editor_context->post->post_type !== 'services') {
		if (isset($allowed_blocks['acf/other-services'])) {
			unset($allowed_blocks['acf/other-services']);
		}
	}
	return $allowed_blocks;
}, 10, 2);

add_filter('acf/prepare_field', 'fix_all_source_fields_on_options_page');
function fix_all_source_fields_on_options_page($field)
{
	if (strpos($field['name'], '_source') !== false) {
		if (is_admin() && function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if ($screen && strpos($screen->id, 'theme-general-settings2') !== false) {
				$field['wrapper']['class'] .= ' hide-source-field';
			}
		}
	}
	return $field;
}

add_action('acf/input/admin_head', function () {
	$screen = get_current_screen();
	if ($screen && strpos($screen->id, 'theme-general-settings2') !== false) {
		echo '<style>
            .hide-source-field {
                display: none !important;
            }
            [data-name$="_source"] {
                display: none !important;
            }
        </style>';
	}
});



add_action('acf/input/admin_head', function () {
?>
	<style type="text/css">
		h2.hndle.ui-sortable-handle {
			background: #cfa144;
			color: #fff !important;
			-webkit-transition: all 0.25s;
			-o-transition: all 0.25s;
			transition: all 0.25s;
		}

		.acf-field.acf-accordion .acf-label.acf-accordion-title {
			background: #EBE9F5;
			transition: all 0.25s;
		}

		.acf-accordion .acf-accordion-title label {
			text-transform: uppercase;
			color: #000;
		}

		.acf-field p.description {
			color: #ffa500;
		}

		.acf-field-group {
			border: 1px solid #282D41 !important;
		}

		.global-block-notice {
			padding: 30px;
			background: #fff;
			border: 2px dashed #cfa144;
			text-align: center;
			border-radius: 4px;
		}

		.global-block-notice__title {
			font-size: 24px;
			font-weight: bold;
			margin-bottom: 10px;
			color: #23282d;
		}

		.global-block-notice__text {
			font-size: 14px;
			color: #646970;
			margin-bottom: 15px;
		}

		.global-block-notice__link {
			display: inline-block;
			background: #cfa144;
			color: #fff !important;
			padding: 8px 20px;
			text-decoration: none;
			border-radius: 4px;
			font-weight: 500;
		}
	</style>
<?php
});
