<?php

class PeThemeShortcodeClearfix extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "clear";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Clear");
		$this->description = __pe("Description");
	}

	public function output($atts,$content=null,$code="") {		
		$html = <<< EOT
<div class="clearfix"></div>
EOT;
return trim($html);
	}


}

?>
