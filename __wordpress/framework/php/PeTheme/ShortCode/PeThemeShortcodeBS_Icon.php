<?php

class PeThemeShortcodeBS_Icon extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "icon";
		$this->group = __pe("UI");
		$this->name = __pe("Icon");
		$this->description = __pe("Select the cion type to add. See the help documentation for a link to the list of available icons");
		$this->fields = array(
							  "type"=> PeGlobal::$const->data->fields->icon,
							  "color" =>
							  array(
									"label" => __pe("Color"),
									"description" => __pe("Select color of the icon"),
									"type" => "Select",
									"options" =>
									array(
										  __pe("White") => "white",
										  __pe("Black") => "black"
										  ),
									"default" => "white"
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$html = sprintf('<i class="%s icon-%s"></i>',$type,$color);
        return trim($html);
	}


}

?>
