<?php

class PeThemeShortcodeBS_Popover extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "popover";
		$this->group = __pe("UI");
		$this->name = __pe("Popover");
		$this->description = __pe("Add a popover");
		$this->fields = array(
							  "position"=> 
							  array(
									"label" => __pe("Position"),
									"type" => "Select",
									"description" => __pe("Select the position for the popover"),
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
									"description" => __pe("Enter the destination url of the popover trigger object"),
									"default" => "#"
									),
							  "type"=> 
							  array(
									"label" => __pe("Button Type"),
									"type" => "Select",
									"description" => __pe("Select the type of button to use as the trigger object"),
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
									"description" => __pe("Enter the popover trigger button's text label here."),
									"default" => "Hover for popover."
									),
							  "title" =>
							  array(
									"label" => __pe("Title"),
									"type" => "Text",
									"description" => __pe("Enter the popover title here."),
									"default" => "Popover Title"
									),
							  "body" =>
							  array(
									"label" => __pe("Content"),
									"type" => "TextArea",
									"description" => __pe("Enter the popover content here."),
									"default" => "Popover content"
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		if (!@$url || !@$title || !@$body) return "";
		$class = (@$type && $type != "none") ? sprintf(' class="btn btn-%s"',$type) : "";
		return sprintf('<a%s href="%s" data-placement="%s" data-rel="popover" data-content="%s" title="%s">%s</a>',$class,$url,$position,esc_attr($body),esc_attr($title),$this->parseContent($content));
	}


}

?>
