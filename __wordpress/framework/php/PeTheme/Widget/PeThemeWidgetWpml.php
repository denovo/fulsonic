<?php

class PeThemeWidgetWpml extends PeThemeWidget {

	public $is_wpml_conditional = true;

	public function __construct() {
		$this->name = __pe("WPML - Conditional");
		$this->description = __pe("Show/Hide widgets according to language");

		$this->fields = array(
							  "lang" => 
							  array(
									"label"=>__pe("Language"),
									"description" => __pe("Only show subsequent widgets when language match the above selection."),
									"type"=>"RadioUI",
									"options" => peTheme()->wpml->options(),
									"default"=>""
									)
							  );

		parent::__construct();
	}

	public function &getContent(&$instance) {
		$html = "";
		return $html;
	}


}
?>
