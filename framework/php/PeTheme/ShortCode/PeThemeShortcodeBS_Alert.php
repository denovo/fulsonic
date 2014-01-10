<?php

class PeThemeShortcodeBS_Alert extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "alert";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Alert Box");
		$this->description = __pe("Add an Alert Box");
		$this->fields = array(
							  "type"=> 
							  array(
									"label" => __pe("Alert Box Type"),
									"type" => "Select",
									"description" => __pe("Select the type of Alert Box required. The alert type determines the color of the box and text"),
									"options" => 
									array(
										  __pe("Default") => "default",
										  __pe("Primary") => "primary",
										  __pe("Info") => "info",
										  __pe("Success") => "success",
										  __pe("Warning") => "warning",
										  __pe("Danger") => "danger",
										  __pe("Inverse") => "inverse"
										  ),
									"default" => "default"
									),
							  "display"=> 
							  array(
									"label" => __pe("Alert Box Layout"),
									"type" => "Select",
									"description" => __pe("Select the layout based on what type of content the box will hold, inline content or block content"),
									"options" => 
									array(
										  __pe("Block") => "block",
										  __pe("Inline") => "inline"
										  ),
									"default" => "block"
									),
							  "content" =>
							  array(
									"label" => __pe("Content"),
									"type" => "TextArea",
									"description" => __pe("Enter the Alert Box content here ( Basic HTML supported )."),
									)
							  );
		// add block level cleaning
		peTheme()->shortcode->blockLevel[] = $this->trigger;
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$content = $content ? $this->parseContent($content) : '';
		$html = <<< EOT
<div class="alert alert-$type alert-$display fade in">
	$content
</div>
EOT;
        return trim($html);
	}


}

?>
