<?php

class PeThemeShortcodeBS_Hero extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "hero";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Hero Unit");
		$this->description = __pe("Add an Hero Unit");
		$this->fields = array(
							  "type"=> 
							  array(
									"label" => __pe("Hero Unit Type"),
									"type" => "Select",
									"description" => __pe("Select the type of hero unit required. the type determines the color"),
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
							 "title" =>
							  array(
									"label" => __pe("Title"),
									"type" => "Text",
									"description" => __pe("Enter the title of the Hero Unit."),
									),
							  "content" =>
							  array(
									"label" => __pe("Content"),
									"type" => "Editor",
									"description" => __pe("Enter the Hero Unit content here."),
									)
							  );

		peTheme()->shortcode->blockLevel[] = $this->trigger;
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
	
		$content = $content ? $this->parseContent($content) : '';
		$title = isset($title) ? "<h1>$title</h1>" : "";

		$html = <<< EOT
<div class="hero-unit well $type">
	$title
	<p>$content</p>
</div>
EOT;
        return trim($html);
	}


}

?>
