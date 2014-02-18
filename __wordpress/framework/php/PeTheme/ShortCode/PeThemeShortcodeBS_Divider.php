<?php

class PeThemeShortcodeBS_Divider extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "divider";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Divider");
		$this->description = __pe("Add a divider");
		$this->fields = array(
							  "type"=> 
							  array(
									"label" => __pe("Divider Type"),
									"type" => "Select",
									"description" => __pe("Select the type of divider required."),
									"options" => 
									array(
										  __pe("Solid") => "solid",
										  __pe("Dotted") => "dotted"
										  ),
									"default" => "solid"
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$html =<<<EOL
<div class="row-fluid">
    <div class="span12">
        <div class="divider $type clearfix"><span></span></div>
    </div>
</div>
EOL;
        return trim($html);
	}


}

?>
