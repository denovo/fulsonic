<?php

class PeThemeShortcodeBS_Blog extends PeThemeShortcode {

	public $instances = 0;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "blog";
		$this->group = __pe("CONTENT");
		$this->name = __pe("Blog");
		$this->description = __pe("Blog");

		$options =& peTheme()->content->getPagesOptionsByTemplate("blog");

		if (!$options) {
			$options = array();
		}

		$options =& array_merge(array(__pe("Default / All Posts")=>""),$options);

		
		$this->fields = array(
							  "id" => 
							  array(
									"label" => __pe("Blog Options"),
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

		extract(shortcode_atts(array('id'=>'','size'=>''),$atts));
		
		$size = $size ? explode("x",$size) : false;

		$t =& peTheme();
		
		ob_start();
		if ($size) 	$t->media->size($size[0],$size[1]);
		$t->content->blog($id);
		if ($size) $t->media->size();
		$content =& ob_get_clean();
		return $content;

	}


}

?>
