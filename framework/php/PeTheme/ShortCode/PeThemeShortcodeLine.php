<?php

class PeThemeShortcodeLine extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "line";
		$this->group = __pe("DIVIDERS");
		$this->name = __pe("Line");
		$this->description = __pe("Add a line");
		$this->fields = array(
							  "type" =>
							  array(
									"label" => __pe("Line Type"),
									"type" => "Select",
									"description" => __pe("Select the line type of the divider"),
									"options" => 
									array(
										  __pe("Solid") => "solid",
										  __pe("Dotted") => "dotted"
										  )
									),
							  "top" =>
							  array(
									"label"=>__pe("Back to top link"),
									"type"=>"RadioUI",
									"description" => __pe("Select whether the line will contain a button which allows the user to scroll back to the top of the page"),
									"options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
									"default"=>"no"
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		if (@$atts["top"] != "yes") {
			$html = <<< EOT
<div class="divider {$atts['type']} clearfix"><span></span></div>
EOT;
		} else {
			$top = __pe("top &uarr;");
			$html = <<< EOT
	<div class="divider topBtn {$atts['type']} clearfix"><span></span><a href="#top" title="Go to top">$top</a></div>
EOT;
		}
		return trim($html);

	}



}

?>
