<?php

class PeThemeShortcodeButton extends PeThemeShortcode {

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
									"description" => __pe("Select the type of button required. The button type determines the icon displayed on the button"),
									"options" => 
									array(
										  __pe("Download") => "download",
										  __pe("Link") => "link",
										  __pe("Info") => "info",
										  __pe("Thumbs") => "thumbs",
										  __pe("Vcard") => "vcard",
										  __pe("Love") => "love",
										  __pe("Warning") => "warning",
										  __pe("Tweet") => "tweet",
										  __pe("Like") => "like",
										  __pe("Note") => "note"
										  ),
									"default" => "download"
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
									"description" => __pe("Enter the button label here. If no text is entered the button will consist of an icon only"),
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		$type = $atts["type"];
		$class = $content ? "content " : "";
		$content = $content ? '<span class="content">'.$this->parseContent($content).'</span>' : '';
		$html = <<< EOT
<a href="{$atts['url']}" class="btn $class$type"><span class="sprite"></span>$content</a>
EOT;
        return trim($html);
	}


}

?>
