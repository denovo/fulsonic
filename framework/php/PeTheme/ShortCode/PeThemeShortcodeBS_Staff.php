<?php

class PeThemeShortcodeBS_Staff extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "staff";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Staff");
		$this->description = __pe("Add a staff block");
		$this->fields = array(
							  "layout"=> 
							  array(
									"label" => __pe("Layout"),
									"type" => "Select",
									"description" => __pe("Select position of main image."),
									"options" => 
									array(
										  __pe("Left") => "left",
										  __pe("Right") => "right"
										  ),
									"default" => "left"
									),
							  "image" => 
							  array(
									"label"=>__pe("Image"),
									"type"=>"Upload",
									"description" => __pe("Upload the large image. 400x320px aprox. ")
									),
							  "thumb" => 
							  array(
									"label"=>__pe("Thumbnail"),
									"type"=>"Upload",
									"description" => __pe("Upload the small Image. 110x130px aprox. Leave this field blank if no small images is required.")
									),
							  "content" => 
							  array(
									"label"=>__pe("Content"),
									"type"=>"TextArea",
									"description" => __pe("Description content. Simple HTML tags and buttons are supported."),
									"default" => sprintf('<h3>Full Name <span>Position</span></h3>%s<p>Description</p>',"\n")
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$t =& peTheme();
		$content = isset($content) ? sprintf('<div class="span7"><div class="innerSpacer">
			<div class="content">%s</div>
		</div></div>',$this->parseContent($content)) : "";
		
		$thumb = isset($thumb) ? sprintf('<div class="thumb">%s</div>',$t->image->resizedImg($thumb,110,130)) : "";
		$image = isset($image) ? sprintf('<div class="span5 clearfix"><div class="image">%s</div>%s</div>',$t->image->resizedImg($image,420,300),$thumb) : "";

		$content = isset($layout) && $layout == "left" ? "$image $content" : "$content $image";

		$html =<<<EOL
<div class="row-fluid">
    <div class="span12">
        <div class="staff clearfix $layout"><div class="row-fluid">$content</div></div>
    </div>
</div>
EOL;
        return trim($html);
	}


}

?>
