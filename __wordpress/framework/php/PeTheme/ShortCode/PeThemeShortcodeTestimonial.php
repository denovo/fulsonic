<?php

class PeThemeShortcodeTestimonial extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "testimonial";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Testimonial");
		$this->description = __pe("Testimonial");
		$this->fields = array(
							  "content" =>
							  array(
									"label" => __pe("Content"),
									"type" => "TextArea",
									"description" => __pe("Enter the testimonial or quotation text in this field"),
									),
							  "title" =>
							  array(
									"label" => __pe("Quotee"),
									"type" => "Text",
									"description" => __pe("Enter the name of the person being quoted"),
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		$title = isset($atts["title"]) ? "<h3>{$atts['title']}</h3>" : "";
		if ($content) {
			$content = $this->parseContent($content);
		}		
		$html = <<< EOT
<div class="testimonial">
    <blockquote><span class="sprite open">66</span>$content<span class="sprite close">99</span></blockquote>$title
</div>
EOT;
return trim($html);
	}


}

?>
