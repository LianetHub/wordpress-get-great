<?php
/* Customize Admin Panel */
class Wptuts_Simple_Admin
{
	function __construct()
	{
		add_action('admin_menu', array($this, 'remove_menus'));
		add_action('wp_dashboard_setup', array($this, 'remove_dashboard_widget'));
		add_action('wp_before_admin_bar_render', array($this, 'my_admin_bar_render'));
		add_action('login_head',  array($this, 'my_custom_login_logo'));
		add_filter('login_headerurl', array($this, 'change_wp_login_url'));
		add_filter('login_headertext', array($this, 'change_wp_login_title'));
		add_action('admin_head', array($this, 'custom_css'));
	}

	function remove_menus()
	{
		global $submenu;
		unset($submenu['themes.php'][6]);
		remove_menu_page('edit-comments.php');
	}

	function remove_dashboard_widget()
	{
		remove_meta_box('dashboard_primary', 'dashboard', 'side');
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
		remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
		remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
		remove_meta_box('dashboard_activity', 'dashboard', 'normal');
		remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'normal');
		remove_meta_box('wpseo-wincher-dashboard-overview', 'dashboard', 'normal');
		remove_action('welcome_panel', 'wp_welcome_panel');
	}

	function my_admin_bar_render()
	{
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('wp-logo');
	}

	function custom_css()
	{
		$css = "<style>";
		$css .= "#toplevel_page_theme-general-settings .wp-menu-name,#toplevel_page_theme-general-settings2 .wp-menu-name{ background: #0022aa; } #toplevel_page_theme-general-settings:hover .wp-menu-name{ background: #111; }";
		$css .= "</style>";
		echo $css;
	}

	function my_custom_login_logo()
	{
		echo '
                <style type="text/css">
                    .login h1 a {
                        background: url(' . get_bloginfo('template_directory') . '/assets/img/logo.svg) rgba(24, 29, 39, 0.86) center no-repeat !important;
                        background-size: 67% !important;
                        width: 312px!important;
                        height: 110px!important;
                    }
                </style>
        ';
	}

	function change_wp_login_url()
	{
		return home_url();
	}

	function change_wp_login_title()
	{
		return get_option('blogname');
	}
}
$wptuts_simple_admin = new Wptuts_Simple_Admin();
