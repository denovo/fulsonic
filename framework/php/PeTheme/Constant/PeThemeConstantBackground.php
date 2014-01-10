<?php

class PeThemeConstantBackground {
	public $fields;
	public $options;
	public $metabox;

	public function __construct() {

		$this->fields = new stdClass();

		$this->fields->image = 							  
			array(
				  "label"=>__pe("Image"),
				  "type"=>"Upload",
				  "description" => __pe("Select a background image."),
				  "default"=>""
				  );

		$this->metabox = 
			array(
				  "type" =>"Background",
				  "title" =>__pe("Background"),
				  "where" => 
				  array(
						"post" => "all",
						"page" => "all"
						/*
						  format: "taxonomy" => "value1,value2"
						 */
						),
				  "content"=>
				  array(
						"type" => 
						array(
							  "label"=>__pe("Background"),
							  "type"=>"RadioUI",
							  "description" => __pe("This option controls the backgrounds type.<br/><span><strong>Default</strong> uses global setting (defined in theme options).<br/></span><strong>Custom</strong> means use custom settings and <br/><strong>None</strong> disables the custom background component."),
							  //"options" => Array(__pe("Default")=>"default",__pe("Color")=>"color",__pe("Black&White")=>"bw",__pe("None")=>"none"),
							  "options" => Array(__pe("Default")=>"default",__pe("Custom")=>"color",__pe("None")=>"none"),
							  "default"=>"default"
							  ),
						"resource" => 
						array(
							  "label"=>__pe("Type"),
							  "type"=>"RadioUI",
							  "description" => __pe("<strong>Image</strong> means you can select a static image,<br/><strong>Slider</strong> means a background image will be set according to the current slide as shown in the first slider of that page,<br/><strong>Gallery</strong> means a slideshow is displayed of a selected gallery's images.<br/>These may be overwritten on a page by page basis by setting different background options in specific pages."),
							  "options" => 
							  array(
									__pe("Image") => "image",
									__pe("Slider") => "slider",
									__pe("Gallery") => "gallery"
),
							  "default"=>"image"
							  ),
						"image" => $this->fields->image,
						"gallery" => PeGlobal::$const->gallery->id,
						"mobile" => 
						array(
							  "label"=>__pe("Mobile"),
							  "type"=>"Upload",
							  "description" => __pe("Static image for mobile."),
							  "default"=>""
							  ),
						"overlay" => 
						array(
							  "label"=>__pe("Overlay"),
							  "type"=>"RadioUI",
							  "description" => __pe("This option allows a tiled pattern overlay to be applied to the background."),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"yes"
							  ),
						"overlayImage" =>
						array(
							  "label"=>__pe("Pattern"),
							  "type"=>"Upload",
							  "description" => __pe("Select a background pattern tile."),
							  "default"=> PE_THEME_URL."/img/skin/pat.png"
							  )
						)
				  );

		foreach ($this->metabox["content"] as $key => $value) {
			$value["section"] = __pe("Background");
			if ($key == "type") {
				//unset($value["options"][__pe("Default")]);
				$value["options"] = Array(__pe("Enabled")=>"color",__pe("Disabled")=>"none");
				$value["default"] = "none";
				$value["description"] = __pe("This option controls the default background.");
					//preg_replace("/<span>.*<\/span>/","",$value["description"]);
			} 
			$this->options["background_".$key] = $value;
		}

	}
	
}

?>