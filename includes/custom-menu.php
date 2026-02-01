<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('after_setup_theme', 'theme_register_nav_menu');
function theme_register_nav_menu()
{
    register_nav_menus([
        'primary_menu' => 'Главное меню (в шапке)',
        'footer_menu'  => 'Меню в подвале',
        'menu_policies'  => 'Меню политики конфиденциальности'
    ]);
}
class Menu_Nav_Walker extends Walker_Nav_Menu
{
    function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;

        if ($depth === 0) {
            $classes[] = 'menu__item';
        } elseif ($depth === 1) {
            $classes[] = 'sub-menu__item';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $output .= '<li' . $class_names . '>';

        $atts = [];
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
        $atts['href']   = !empty($item->url)        ? $item->url        : '';

        if ($depth === 0) {
            $atts['class'] = 'menu__link';
        } elseif ($depth === 1) {
            $atts['class'] = 'sub-menu__link';
        }

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';

        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<button type="button" class="menu__arrow icon-chevron-down" aria-label="Открыть подменю"></button>';
        }

        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    function start_lvl(&$output, $depth = 0, $args = [])
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"sub-menu\">\n$indent\t<ul class=\"sub-menu__list\">\n";
    }

    function end_lvl(&$output, $depth = 0, $args = [])
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent\t</ul>\n$indent</div>\n";
    }
}

class Footer_Menu_Walker extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = [])
    {
        $indent = str_repeat("\t", $depth);
        $classes = ($depth === 0) ? 'footer__submenu' : 'footer__subsubmenu';
        $output .= "\n$indent<ul class=\"$classes\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);

        $custom_classes = array_filter($classes, function ($cls) {
            return !in_array($cls, ['menu-item', 'menu-item-type-post_type', 'menu-item-object-page', 'menu-item-has-children']);
        });

        if ($depth === 0) {
            $custom_classes[] = 'footer__menu-item';
            $link_base_class = 'footer__menu-link';
        } elseif ($depth === 1) {
            $custom_classes[] = 'footer__submenu-item';
            $link_base_class = 'footer__submenu-link';
        } else {
            $custom_classes[] = 'footer__subsubmenu-item';
            $link_base_class = 'footer__subsubmenu-link';
        }

        if ($has_children) {
            $custom_classes[] = 'has-child';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($custom_classes), $item, $args));
        $output .= '<li class="' . esc_attr($class_names) . '">';

        $atts = [];
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts['class']  = $link_base_class;
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';

        if ($has_children) {
            $aria_lvl = $depth + 1;
            $item_output .= '<button type="button" aria-label="Открыть подменю ' . $aria_lvl . ' уровня вложенности" data-spoller class="footer__arrow-button icon-chevron-down"></button>';
        }

        $item_output .= $args->after;
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}
