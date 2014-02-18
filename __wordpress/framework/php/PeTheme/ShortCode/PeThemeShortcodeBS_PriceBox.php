<?php

class PeThemeShortcodeBS_PriceBox extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "pricetable";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Price Table");
		$this->description = __pe("Add an Price Box");

		$html = <<<EOL
<ul class="unstyled">
    <li><i class="icon-ok icon-white"></i>Includes stuff</li>
    <li><i class="icon-ok icon-white"></i>Other great items</li>
    <li><i class="icon-ok icon-white"></i>Yep that too</li>
</ul>
EOL;

		$this->fields = array(
							  "color"=> 
							  array(
									"label" => __pe("Background Color"),
									"type" => "Color",
									"description" => __pe("Select background color."),
									"default" => "#666666"
									),
							 "title" =>
							  array(
									"label" => __pe("Title"),
									"type" => "Text",
									"description" => __pe("Price table title."),
									"default" => "Like a Player",
									),
							  "price" =>
							  array(
									"label" => __pe("Price"),
									"type" => "Text",
									"description" => __pe("Price table price."),
									"default" => "$19<span>99 /m</span>",
									),
							  "content" =>
							  array(
									"label" => __pe("Features"),
									"type" => "TextArea",
									"description" => __pe("Enter the pricing tables features, one per line."),
									"default" => $html
									),
							  "button_type"=> 
							  array(
									"label" => __pe("Button Type"),
									"type" => "Select",
									"description" => __pe("Select the type of button required. The type determines the button color"),
									"options" => 
									array(
										  __pe("Default") => "default",
										  __pe("Primary") => "primary",
										  __pe("Info") => "info",
										  __pe("Success") => "success",
										  __pe("Warning") => "warning",
										  __pe("Danger") => "danger",
										  __pe("Inverse") => "inverse"
										  ),
									"default" => "default"
									),
							  "button_url" =>
							  array(
									"label" => __pe("Button Url"),
									"type" => "Text",
									"description" => __pe("Enter the destination url of the button"),
									"default" => "#"
									),
							  "button_label" =>
							  array(
									"label" => __pe("Button Label"),
									"type" => "Text",
									"description" => __pe("Enter the button label here. Leave this field blank to hide the button"),
									"default" => "Sign Up" 
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$content = $content ? $this->parseContent($content) : '';
		$html = sprintf('<div class="hero-unit price warning well" style="background-color: %s;">',$color);
		if (@$title) $html .= sprintf('<p class="type">%s</p>',$title);
		if (@$price) $html .= sprintf('<h1>%s</h1>',$price);
		if (@$content) $html .= $content;
		if (@$button_label) $html .= sprintf('<br/><p><a href="%s" class="btn btn-%s">%s</a></p>',$button_url,$button_type,$button_label);
		$html .= "</div>";
        return trim($html);
	}


}

?>
