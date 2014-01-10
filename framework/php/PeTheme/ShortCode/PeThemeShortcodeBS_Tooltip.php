<?php

class PeThemeShortcodeBS_Tooltip extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "tooltip";
		$this->group = __pe("UI");
		$this->name = __pe("Tooltip");
		$this->description = __pe("Add a tooltip");
		$this->fields = array(
							  "position"=> 
							  array(
									"label" => __pe("Position"),
									"type" => "Select",
									"description" => __pe("Select the tooltip position."),
									"options" => 
									array(
										  __pe("Top") => "top",
										  __pe("Bottom") => "bottom",
										  __pe("Left") => "left",
										  __pe("Right") => "right"
										  ),
									"default" => "top"
									),
							  "url" =>
							  array(
									"label" => __pe("Url"),
									"type" => "Text",
									"description" => __pe("Enter the destination url of the tooltip trigger"),
									"default" => "#"
									),
							  "type"=> 
							  array(
									"label" => __pe("Button Type"),
									"type" => "Select",
									"description" => __pe("Select the type of button to use. The type determines the button color"),
									"options" => 
									array(
										  __pe("No button, use normal text") => "none",
										  __pe("Default") => "default",
										  __pe("Primary") => "primary",
										  __pe("Info") => "info",
										  __pe("Success") => "success",
										  __pe("Warning") => "warning",
										  __pe("Danger") => "danger",
										  __pe("Inverse") => "inverse"
										  ),
									"default" => "none"
									),
							  "content" =>
							  array(
									"label" => __pe("Label"),
									"type" => "Text",
									"description" => __pe("Enter the tooltip trigger label content here."),
									"default" => "Label content."
									),
							  "title" =>
							  array(
									"label" => __pe("Tooltip"),
									"type" => "Text",
									"description" => __pe("Enter the tooltip content here."),
									"default" => "Tooltip content"
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		if (!@$url || !@$title) return "";
		$class = (@$type && $type != "none") ? sprintf(' class="btn btn-%s" ',$type) : "";
		return sprintf('<a%s href="%s" data-rel="tooltip" data-position="%s" title="%s">%s</a>',$class,$url,$position,esc_attr($title),$this->parseContent($content));
	}


}

?>
