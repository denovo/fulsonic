<?php

class PeThemeShortcodeBS_Label extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "label";
		$this->group = __pe("UI");
		$this->name = __pe("Label");
		$this->description = __pe("Add a label");
		$this->fields = array(
							  "type"=> 
							  array(
									"label" => __pe("Label Type"),
									"type" => "Select",
									"description" => __pe("Select the type of label required. The type determines the label color"),
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
									"description" => __pe("Enter the destination url of the label. Leave this field blank if the label is not a clickable link"),
									),
							  "content" =>
							  array(
									"label" => __pe("Label"),
									"type" => "Text",
									"description" => __pe("Enter the label content here."),
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$type = $atts["type"];
		if (!isset($url)) $url = false;
		$content = $content ? $this->parseContent($content) : '';
		if ($url) {
			$html = sprintf('<a href="%s" class="label label-%s">%s</a>',$url,$type,$content);
		} else {
			$html = sprintf('<span class="label label-%s">%s</span>',$type,$content);
		}
        return trim($html);
	}


}

?>
