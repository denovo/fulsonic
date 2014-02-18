<?php

class PeThemeFont {

	public $master;
	public $customCSS;
	public $fonts = false;

	public function __construct($master) {
		$this->master =& $master;
		if (!empty(PeGlobal::$config["fonts"])) {
			$this->fonts =& PeGlobal::$config["fonts"];
		}
	}

	public function &options($custom = true) {
		$options = array();
		foreach ($this->fonts as $key=>$value) {
			$options[$key] =
				array(
					  "label"=>$value["label"],
					  "type"=>"Fonts",
					  "section"=>__pe("Fonts"),
					  "default"=>$value["default"]
					  );
			
			if ($custom) {
				$options[$key."_custom"] =
					array(
						  //"label"=>$value["label"]." ".__pe("(custom font line)"),
						  "label" => "",
						  "type"=>"Text",
						  "section"=>__pe("Fonts"),
						  "description" => __pe("Here you can add a custom font declaration, useful when you want to change size or  use a common (not google) font.<br/>Example: <b>15px arial,sans-serif</b>"),
						  "default"=>""
						  );
			}
		}
		return $options;
	}
	
	public function load() {
		if (!$this->fonts) return;
		$options = $this->master->options->all();
		$googleFonts =& PeGlobal::$const->fonts->google->all;
		$install = array();
		$customCSS = "";
		$skins = false;
		if (isset(PeGlobal::$config["skins"])) {
			$skins = array_values(PeGlobal::$config["skins"]);
			// drop default skin
			array_shift($skins);
		}
		foreach ($this->fonts as $key => $values) {
			$font = $options->{$key};
			$custom = empty($options->{$key."_custom"}) ? false : $options->{$key."_custom"};

			if ($font || $custom) {
				if ($font) {
					$variants = apply_filters("pe_theme_font_variants",$googleFonts[$font]["request"],$font);
					$install[$variants] = true;
				}
				$selectors = $values["selectors"];
				$rule = join(",",$selectors);
				if ($skins) {
					foreach ($skins as $skin) {
						foreach ($selectors as $selector) {
							$rule .= ",html.skin_$skin $selector";
						}
					}
				}
				$customCSS .= ($custom) ? "$rule{font:$custom;}" : "$rule{font-family:'$font';}";
			}
		}

		if (count($install) > 0) {
			printf(
				   '<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=%s&amp;subset=%s">',
				   strtr(join("|",array_keys($install))," ","+"),
				   apply_filters("pe_theme_font_charset","latin,latin-ext")
				   );
			$this->customCSS = $customCSS;
		}
	}

	public function apply() {
		if ($this->customCSS) {
			printf('<style type="text/css">%s</style>',$this->customCSS);
		}
	}



}

?>