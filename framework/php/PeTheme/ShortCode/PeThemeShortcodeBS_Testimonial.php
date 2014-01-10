<?php

class PeThemeShortcodeBS_Testimonial extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "testimonial";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Testimonial");
		$this->description = __pe("Add a testimonial block");
		$this->fields = array(
							  "content" => 
							  array(
									"label"=>__pe("Testimonial Content"),
									"type"=>"TextArea",
									"description" => __pe("Block content HTML. The 'blockquote' tag contains the quoted content. The 'cite' tag contains the citation for the quoted content."),
									"default"=>sprintf('<blockquote>Text here</blockquote>%s<cite>citation</cite>',"\n")
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		$t =& peTheme();
		$content = isset($content) ? sprintf('<div class="content">%s</div>',$this->parseContent($content)) : "";
		$html =<<<EOL
<div class="row-fluid">
    <div class="span12">
        <div class="testimonial"><div class="speech"></div>$content</div>
    </div>
</div>
EOL;
        return trim($html);
	}


}

?>
