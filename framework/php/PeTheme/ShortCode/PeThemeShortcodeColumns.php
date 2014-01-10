<?php

class PeThemeShortcodeColumns extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "col";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Columns");
		$this->description = __pe("Add 2 columns");
		$this->fields = array(
							  "size" =>
							  array(
									"label" => __pe("Layout"),
									"type" => "SelectColumns",
									"groups" => true,
									"description" => __pe("Select the number and proportion of the columns required. The bar will update to show the layout of the chosen arrangement"),
									"options" => $this->getOptions()
									)
							  );
	}

	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.shortcode.columns.js",array(),"pe_theme_shortcode_columns");
		wp_enqueue_script("pe_theme_shortcode_columns");
	}

	protected function getOptions() {
		$options = array();

		$options[__pe("2 Column layouts")] = 
			array(
					 __pe("1/2 1/2") => "1/2 1/2",
					 __pe("1/3 2/3") => "1/3 2/3",
					 __pe("2/3 1/3") => "2/3 1/3",
					 __pe("1/4 3/4") => "1/4 3/4",
					 __pe("3/4 1/4") => "3/4 1/4",
					 __pe("1/5 4/5") => "1/5 4/5",
					 __pe("4/5 1/5") => "4/5 1/5",
					 );

		$options[__pe("3 Column layouts")] = 
			array(
				  __pe("1/3 1/3 1/3") => "1/3 1/3 1/3",
				  __pe("1/4 1/4 2/4") => "1/4 1/4 2/4",
				  __pe("2/4 1/4 1/4") => "2/4 1/4 1/4",
				  __pe("2/5 2/5 1/5") => "2/5 2/5 1/5",
				  __pe("1/5 2/5 2/5") => "1/5 2/5 2/5",
				  );


		$options[__pe("4 Column layouts")] = 
			array(
				  __pe("1/4 1/4 1/4 1/4") => "1/4 1/4 1/4 1/4"
				  );


		$options[__pe("5 Column layouts")] = 
			array(
				  __pe("1/5 1/5 1/5 1/5 1/5") => "1/5 1/5 1/5 1/5 1/5"
				  );


		return $options;
	}

	protected function script() {
		$html = <<<EOT
<script type="text/javascript">
jQuery.pixelentity.shortcodes.$this->trigger = jQuery("#{$this->trigger}_size_").peShortcodeColumns({tag:"{$this->trigger}"});
</script>
EOT;
		echo $html;
	}

	public function render() {
		parent::render();
		$this->script();
	}

	public function output($atts,$content=null,$code="") {
		extract($atts,EXTR_PREFIX_ALL,"sc");
		$class = "col_".strtr(isset($sc_size) ? $sc_size : $sc_last,"/","-");
		if (isset($sc_last)) {
			$class = "$class last";
		}
		$content = $this->parseContent($content);
		return "<div class=\"$class\">$content</div>";
	}


}

?>
