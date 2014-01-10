<?php

class PeThemeConstantImage {
	public $scale;
	public $align;
	public $fields;
	public $metabox;

	public function __construct() {
		$this->scale = 
			array(
				  __pe("FILL")=>"fill",
				  __pe("FIT")=>"fit"
				  );

		$this->align =
			array(
				  __pe("Top Left")=>"top,left",
				  __pe("Top Center")=>"top,center",
				  __pe("Top Right")=>"top,right",
				  __pe("Center Left")=>"center,left",
				  __pe("Center Center")=>"center,center",
				  __pe("Center Right")=>"center,right",
				  __pe("Bottom Left")=>"bottom,left",
				  __pe("Bottom Center")=>"bottom,center",
				  __pe("Bottom Right")=>"bottom,right",
				  );

		$this->fields = new stdClass();

		$this->fields->scale = 
			array(
				  "label"=>__pe("Scale Mode"),
				  "type"=>"RadioUI",
				  "section"=>__pe("General"),
				  "description" => __pe("This setting determins how the images are scaled / cropped when displayed in the browser window.\"<strong>Fit</strong>\" fits the whole image into the browser ignoring surrounding space.\"<strong>Fill</strong>\" fills the whole browser area by cropping the image if necessary"),
				  "options" => $this->scale,
				  "default"=>"fill"
				  );

		$this->fields->align = 							  
			array(
				  "label"=>__pe("Image Alignment"),
				  "type"=>"Select",
				  "section"=>__pe("General"),
				  "description" => __pe("Specify the alignment to be used in the event of the image being cropped. Use this to ensure that important parts of the image can be always seen."),
				  "options" => $this->align,
				  "default"=>"center,center"
				  );

		$this->metabox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Image Options"),
				  "where" => 
				  array(
						"post" => "image,video",
						"page" => "all"
						/*
						  format: "taxonomy" => "value1,value2"
						 */
						),
				  "content"=>
				  array(
						"scale" => $this->fields->scale,
						"align" => $this->fields->align
						)
				  );

		$this->metaboxScale = 
			array(
				  "type" =>"",
				  "title" =>__pe("Image Options"),
				  "where" => 
				  array(
						"post" => "image",
						),
				  "content"=>
				  array(
						"scale" => $this->fields->scale
						)
				  );
	}
	
}

?>