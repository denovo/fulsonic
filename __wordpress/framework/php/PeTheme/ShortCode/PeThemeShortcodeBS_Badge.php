<?php

class PeThemeShortcodeBS_Badge extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "badge";
		$this->group = __pe("UI");
		$this->name = __pe("Badge");
		$this->description = __pe("Add a badge");
		$this->fields = array(
							  "type"=> 
							  array(
									"label" => __pe("Badge Type"),
									"type" => "Select",
									"description" => __pe("Select the type of badge required. The badge type determines the bodge color"),
									"options" => 
									array(
										  __pe("Default") => "default",
										  __pe("Info") => "info",
										  __pe("Success") => "success",
										  __pe("Warning") => "warning",
										  __pe("Important") => "important",
										  __pe("Inverse") => "inverse"
										  ),
									"default" => "default"
									),
							  "url" =>
							  array(
									"label" => __pe("Url"),
									"type" => "Text",
									"description" => __pe("Enter the destination url of the badge. Leave this field blank if the badge is not required to be a clickable link"),
									),
							  "content" =>
							  array(
									"label" => __pe("Label"),
									"type" => "Text",
									"description" => __pe("Enter the badge's text content here."),
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$type = $atts["type"];
		if (!isset($url)) $url = false;
		$content = $content ? $this->parseContent($content) : '';
		if ($url) {
			$html = sprintf('<a href="%s" class="badge badge-%s">%s</a>',$url,$type,$content);
		} else {
			$html = sprintf('<span class="badge badge-%s">%s</span>',$type,$content);
		}
        return trim($html);
	}


}

?>
