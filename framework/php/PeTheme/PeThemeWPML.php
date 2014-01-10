<?php

class PeThemeWPML {

	public $master;
	public $sidebars = array();

	public function __construct($master) {
		$this->master =& $master;
	}

	public function instantiate() {
		if (function_exists("icl_get_languages")) {
			PeGlobal::$config["widgets"][] = "Wpml";
		}
		PeGlobal::$config["shortcodes"][] = "Wpml";

		add_filter('widget_display_callback', array(&$this,'dynamic_sidebar_params_filter'),10,3);
	}

	public function options() {
		$options[__pe("Any")] = "" ;
		
		$langs = icl_get_languages('skip_missing=0');
		if (is_array($langs)) {
			foreach($langs as $value) {
				$options[strtoupper($value["language_code"])] = $value["language_code"];
			}
		}
		return $options;
		
	}


	public function dynamic_sidebar_params_filter($instance,$widget,$args) {
		$sb = $args["id"];
		if (!empty($widget->is_wpml_conditional)) {
			$this->sidebars[$sb] = empty($instance["lang"]) ? false : $instance["lang"];
			return false;
		}
		if (!empty($this->sidebars[$sb]) && ICL_LANGUAGE_CODE != $this->sidebars[$sb]) return false;
		return $instance;
	}

	public function widget_callback($args,$instance) {
		return "";
	}

	public function deflang() {
		global $sitepress;
		return $sitepress->get_default_language();
	}

	public function notDefaultLanguage() {
		return (ICL_LANGUAGE_CODE != "all" && ICL_LANGUAGE_CODE != $this->deflang());
	}


	public function register_strings() {
		if (!function_exists("icl_register_string")) return;
		get_template_part("languages/wpml_strings");
		if (!empty(PeGlobal::$config["wpml_strings"]) && is_array(PeGlobal::$config["wpml_strings"])) {
			foreach (PeGlobal::$config["wpml_strings"] as $s) {
				icl_register_string('theme '.PE_THEME_NAME,md5($s),$s);
			}
		}
	}


}

?>