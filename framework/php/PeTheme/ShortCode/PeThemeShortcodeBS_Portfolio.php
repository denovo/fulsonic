<?php

class PeThemeShortcodeBS_Portfolio extends PeThemeShortcode {

	public $instances = 0;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "portfolio";
		$this->group = __pe("CONTENT");
		$this->name = __pe("Portfolio");
		$this->description = __pe("Portfolio");

		$options =& peTheme()->content->getPagesOptionsByTemplate("portfolio");

		if (!$options) {
			$options = array();
		}

		$options =& array_merge(array(__pe("Default / All Posts")=>""),$options);

		
		$this->fields = array(
							  "id" => 
							  array(
									"label" => __pe("Portfolio Options"),
									"type" => "Select",
									"description" => __pe("Show all posts with default options or use custom settings of a blog page template."),
									"options" => $options
									),
							  "size" => 
							  array(
									"label"=>__pe("Media Size"),
									"type"=>"Text",
									"description" => __pe("The size of the Media Area in pixels. Leave empty to use default values"),
									"default"=>""
									),
							  );
	}

	public function output($atts,$content=null,$code="") {

		extract(shortcode_atts(array('id'=>''),$atts));
		
		$t =& peTheme();
		
		ob_start();
		$t->project->portfolio($id);
		$content =& ob_get_clean();
		return $content;

	}


}

?>
