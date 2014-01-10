<?php

class PeThemeShortcodeBS_Gallery extends PeThemeShortcode {

	public $instances = 0;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "pegallery";
		$this->group = __pe("MEDIA");
		$this->name = __pe("Gallery");
		$this->description = __pe("Gallery");

		$this->fields = array(
							  "id" => PeGlobal::$const->gallery->id,
							  "size" => 
							  array(
									"label"=>__pe("Size"),
									"type"=>"Text",
									"description" => __pe("The size of the gallery in pixels. Only used in Fullscreen/Single Images modes, written in the form WidthxHeight. Leave empty to use default values"),
									"default"=>""
									),
							  );

		peTheme()->shortcode->blockLevel[] = $this->trigger;

	}


	public function output($atts,$content=null,$code="") {
		global $post;

		$defaults = apply_filters("pe_theme_shortcode_gallery_defaults",array('id'=>'','size'=> ''),$atts);
		
		extract(shortcode_atts($defaults,$atts));
		
		if (!$id) return "";

		$size = $size ? explode("x",$size) : false;

		$t =& peTheme();
		
		ob_start();
		if ($size) 	$t->media->size($size[0],$size[1]);
		$t->gallery->output($id);
		if ($size) $t->media->size();
		$content =& ob_get_clean();
		return $content;

	}


}

?>
