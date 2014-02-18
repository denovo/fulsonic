<?php

class PeThemeShortcodeBS_ContentBox extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "contentbox";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Content Box");
		$this->description = __pe("Add Content Box");

		$this->fields = array(
							  "background"=> 
							  array(
									"label" => __pe("Background Color"),
									"type" => "Color",
									"description" => __pe("Select background color for the content box."),
									"default" => ""
									),
							  "padding"=> 
							  array(
									"label" => __pe("Content Padding"),
									"type" => "Text",
									"description" => __pe("Content padding: Top, Right, Bottom, Left."),
									"default" => "10px 10px 10px 10px"
									),
							  "content" =>
							  array(
									"label" => __pe("Box Content"),
									"type" => "TextArea",
									"description" => __pe("Enter the box content here. Basic HTML tags are supported."),
									"default" =>" content "
									)
							  );

		// add block level cleaning
		peTheme()->shortcode->blockLevel[] = $this->trigger;

	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$content = $content ? $this->parseContent($content) : '';
		$style = "";
		$style .= (isset($background) && $background) ? "background-color:$background;" : "";
		$style .= (isset($padding) && $padding) ? "padding:$padding;\"" : "";
		if ($style) $style = "style=\"$style";

		$html = sprintf('<div class="contentBox" %s>%s</div>',$style,$content);
        return trim($html);
	}


}

?>
