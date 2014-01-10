<?php

class PeThemeShortcodeInfo extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "info";
		$this->group = __pe("ALERTS");
		$this->name = __pe("Info");
		$this->description = __pe("Add info box");
		$this->fields = array(
							  "content" =>
							  array(
									"label" => __pe("Alert Text"),
									"type" => "Text",
									"description" => __pe("Enter the text content of the alert box"),
									)
							  );
	}

	public function output($atts,$content=null,$code="") {		
		if ($content) {
			$content = $this->parseContent($content);
		}
		$html = <<< EOT
<div class="alert note"><span class="sprite">Alert</span><p>$content</p></div>
EOT;
return trim($html);
	}


}

?>
