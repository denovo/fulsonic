<?php

class PeThemeShortcodeWarning extends PeThemeShortcodeInfo {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "warning";
		$this->name = __pe("Warning");
		$this->description = __pe("Add warning box");
	}

	public function output($atts,$content=null,$code="") {		
		if ($content) {
			$content = $this->parseContent($content);
		}		$html = <<< EOT
<div class="alert warning"><span class="sprite">Alert</span><p>$content</p></div>
EOT;
return trim($html);
	}



}

?>
