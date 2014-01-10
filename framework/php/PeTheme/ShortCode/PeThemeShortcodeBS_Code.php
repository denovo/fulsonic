<?php

class PeThemeShortcodeBS_Code extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "codehs";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Code Block (Syntax Highlighting)");
		$this->description = __pe("Add a Code Box");
		$this->fields = array(
							  "lang"=> 
							  array(
									"label" => __pe("Language"),
									"type" => "Select",
									"description" => __pe("Language type of code block."),
									"options" => 
									array(
										  __pe("HTML") => "html",
										  __pe("CSS") => "css",
										  __pe("Javascript") => "js",
										  __pe("PHP") => "php",
										  __pe("XML") => "xml",
										  __pe("SQL") => "sql"
										  ),
									"default" => "html"
									),
							  "options"=> 
							  array(
									"label" => __pe("Options"),
									"type" => "CheckboxUI",
									"description" => __pe("Use vertical scrollbar / Show line numbers. If a vertical scrollbar is chosen, the code block's height is fixed as 350px"),
									"options" => 
									array(
										  __pe("Scrollbar") => "pre-scrollable",
										  __pe("Line Numbers") => "linenums"
										  )
									),
							  
							  "content" =>
							  array(
									"label" => __pe("Content"),
									"type" => "TextArea",
									"description" => __pe("Enter the content here."),
									)
							  );
	}

	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.shortcode.code.js",array(),"pe_theme_shortcode_code");
		wp_enqueue_script("pe_theme_shortcode_code");
	}

	protected function script() {
		$html = <<<EOT
<script type="text/javascript">
jQuery.pixelentity.shortcodes.$this->trigger = jQuery("#{$this->trigger}_content_").peShortcodeCode({lang:jQuery("#{$this->trigger}_lang_"),options:jQuery('input[id^="{$this->trigger}_options_"]')});
</script>
EOT;
		echo $html;
	}

	public function render() {
		parent::render();
		$this->script();
	}

		// not used
	public function output($atts,$content=null,$code="") {
		extract($atts);
		$lines = $lines == "yes" ? "linenums" : "";
		$scroll = $scroll == "yes" ? "pre-scrollable" : "";
		$content = $content ? esc_attr($content) : '';
		$html = <<< EOT
<pre class="prettyprint $lines lang-$lang $scroll">$content</pre>
EOT;
        return trim($html);
	}


}

?>
