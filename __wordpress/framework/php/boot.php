<?php

// framework location
define('PE_FRAMEWORK',dirname(dirname(__FILE__)));
define('PE_THEME_URL',get_bloginfo("template_url"));
define('PE_THEME_META',"pe_theme_".PE_THEME_NAME);

function __pe($text) {
	return __($text,PE_THEME_NAME);
}

function e__pe($text) {
	echo __($text,PE_THEME_NAME);
}

require(PE_FRAMEWORK."/php/PeGlobal.php");

PeGlobal::$config["classPath"] = apply_filters('pe_theme_class_paths',
	array(
		  PE_THEME_PATH."/theme/php/PeTheme",
		  PE_FRAMEWORK."/php/PeTheme"
		  ));

PeGlobal::$config["libPath"] = apply_filters('pe_theme_lib_paths',
	array(
		  PE_FRAMEWORK."/php/libs"
		  ));

PeGlobal::init();

// instantiate the controller
if (!function_exists("peTheme")) {
	$peThemeClassName = apply_filters('pe_theme_controller_classname','PeTheme'.PE_THEME_NAME);

	PeGlobal::$controller =& new $peThemeClassName();

	function &peTheme() {
		return PeGlobal::$controller;
	}

	peTheme()->boot();

}

if ( ! isset( $content_width ) ) {
	$content_width = PeGlobal::$config["content-width"];
}

add_action("init", array(peTheme(),"init"));

if (has_action("after_switch_theme")) {
	// 3.3 and upper
	add_action("after_switch_theme", array(peTheme(),"after_switch_theme"));
} else if (is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	// below 3.3
	peTheme()->after_switch_theme(PE_THEME_NAME);
}

add_action("after_setup_theme", array(peTheme(),"after_setup_theme"));
add_action("template_redirect", array(peTheme(),"enqueueAssets"),1);

add_action("add_meta_boxes", array(peTheme(),"add_meta_boxes"),10,2);
add_action("save_post",array(peTheme(),"save_post"),10,2);
add_action("admin_menu",array(peTheme(),"admin_menu"));
add_action("admin_init",array(peTheme(),"admin_init"));
add_action("widgets_init",array(peTheme(),"widgets_init"));
add_action("dbx_post_advanced",array(peTheme(),"dbx_post_advanced"));
add_action("sidebar_admin_setup",array(peTheme(),"sidebar_admin_setup"));

add_action("export_wp",array(peTheme(),"export_wp"));
add_action("rss2_head",array(peTheme(),"rss2_head"));

add_action("wp_ajax_nopriv_peThemeContactForm",array(peTheme(),"contactForm"));
add_action("wp_ajax_peThemeContactForm",array(peTheme(),"contactForm"));

add_action("wp_ajax_nopriv_peThemeNewsletter",array(peTheme(),"newsletter"));
add_action("wp_ajax_peThemeNewsletter",array(peTheme(),"newsletter"));


?>
