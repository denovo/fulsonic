<?php

class PeThemeConstant_peRefineSlide {
	public $options;

	public function __construct() {
		$this->options = 
			array(
				  "transition" =>
				  array(
						"label"=>__pe("Transition"),
						"type"=>"Select",
						"description" => __pe("Transition type"),
						"options" => 
						array(
							  __pe("Random") => "random",
							  __pe("Cube Horizontal") => "cubeH",
							  __pe("Cube Vertical") => "cubeV",
							  __pe("Fade") => "fade",
							  __pe("Slice Horizontal") => "sliceH",
							  __pe("Slice Vertical") => "sliceV",
							  __pe("Slide Horizontal") => "slideH",
							  __pe("Slide Vertical") => "slideV",
							  __pe("Scale") => "scale",
							  __pe("Block scale") => "blockScale",
							  __pe("Kaleidoscope") => "kaleidoscope",
							  __pe("Fan") => "fan",
							  __pe("Blind Horizontal") => "blindH",
							  __pe("Blind Vertical") => "blindV"
							  ),
						"default"=>"random"
						)
				  );
	}
	
}

?>
