<?php

class PeThemeShortcodeLink extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "link";
		$this->group = __pe("ALERTS");
		$this->name = __pe("Link");
		$this->description = __pe("Add link box");
		$this->fields = array(
							  "content" =>
							  array(
									"label" => __pe("Content"),
									"type" => "Text",
									"description" => __pe("Enter the text content of the alert box"),
									),
							  "url" =>
							  array(
									"label" => __pe("Url"),
									"type" => "Text",
									"description" => __pe("Enter the destination url of the alert box when clicked"),
									)
							  );
	}

	public function output($atts,$content=null,$code="") {		
		if ($content) {
			$content = $this->parseContent($content);
		}
		$html = <<< EOT
<a href="{$atts['url']}"><div class="alert link"><span class="sprite"></span><p>$content</p></div></a>
EOT;
return trim($html);
	}


}

?>
