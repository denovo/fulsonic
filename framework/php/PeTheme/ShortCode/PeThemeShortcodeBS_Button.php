<?php

class PeThemeShortcodeBS_Button extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "button";
		$this->group = __pe("UI");
		$this->name = __pe("Button");
		$this->description = __pe("Add a button");
		$this->fields = array(
							  "type"=> 
							  array(
									"label" => __pe("Button Type"),
									"type" => "Select",
									"description" => __pe("Select the type of button required. The button type determines the boton's color"),
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
							  "size"=> 
							  array(
									"label" => __pe("Button Size"),
									"type" => "Select",
									"description" => __pe("Select the size of button"),
									"options" => 
									array(
										  __pe("Small") => "small",
										  __pe("Medium") => "medium",
										  __pe("Large") => "large"
										  ),
									"default" => "small"
									),
							  "url" =>
							  array(
									"label" => __pe("Url"),
									"type" => "Text",
									"description" => __pe("Enter the destination url of the button"),
									),
							  "content" =>
							  array(
									"label" => __pe("Optional Label"),
									"type" => "Text",
									"description" => __pe("Enter the button label here. If no text is entered the button will have no label and so will require an icon or something else to be inserted. This can be done using the icon shortcode once this button shortcode has been added to the editor"),
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$type = $atts["type"];
		if (!isset($url)) $url = "#";
		$content = $content ? $this->parseContent($content) : '';
		$html = <<< EOT
<a href="$url" target="_blank" class="btn btn-$size btn-$type">$content</a>
EOT;
        return trim($html);
	}


}

?>
