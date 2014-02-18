<?php

class PeThemeShortcodeWpml extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "lang";
		$this->group = __pe("CONTENT");
		$this->name = __pe("WPML Language Block");
		$this->description = __pe("WPML Language Block");
		$langs = peTheme()->wpml->options();
		// drop "all" option
		array_shift($langs);
		$this->fields = array(
							  "code" => 
							  array(
									"label"=>__pe("Language"),
									"description" => __pe("Only show content when language match the above selection."),
									"type"=>"RadioUI",
									"options" => $langs,
									"default"=>"en"
									),
							  "content" =>
							  array(
									"label" => __pe("Content"),
									"type" => "Editor",
									"description" => __pe("Block content."),
									"default" => sprintf("%scontent%s","\n","\n")
									)
							  );

		peTheme()->shortcode->blockLevel[] = $this->trigger;

	}


	public function output($atts,$content=null,$code="") {
		extract(shortcode_atts(array('code'=> ''),$atts));
		if (empty($code)) {
			if (!empty($atts) && count($atts) > 0) {
				$code = $atts[0];
			}
		}

		$content = (!$code || ICL_LANGUAGE_CODE == $code) ? $this->parseContent($content) : "";

		
		return $content;

	}


}

?>
