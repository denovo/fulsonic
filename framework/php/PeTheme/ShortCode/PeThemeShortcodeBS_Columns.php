<?php

class PeThemeShortcodeBS_Columns extends PeThemeShortcode {

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

		add_shortcode("cols",array(&$this,"container"));

		// add block level cleaning
		peTheme()->shortcode->blockLevel[] = $this->trigger;
		peTheme()->shortcode->blockLevel[] = "cols";

	}

	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.shortcode.bs_columns.js",array(),"pe_theme_shortcode_columns");
		wp_enqueue_script("pe_theme_shortcode_columns");
	}

	protected function getOptions() {
		$options = array();

		$options[__pe("2 Column layouts")] = 
			array(
					 __pe("1/2 1/2") => "1/2 1/2", /*span6 span6*/
					 __pe("1/3 2/3") => "1/3 2/3", /*span4 span8*/
					 __pe("2/3 1/3") => "2/3 1/3", /*span8 span4*/
					 __pe("1/4 3/4") => "1/4 3/4", /*span3 span9*/
					 __pe("3/4 1/4") => "3/4 1/4", /*span9 span3*/
					 __pe("5/6 1/6") => "5/6 1/6", /*span10 span2*/
					 __pe("1/6 5/6") => "1/6 5/6", /*span2 span10*/
					 );

		$options[__pe("3 Column layouts")] = 
			array(
				  __pe("1/3 1/3 1/3") => "1/3 1/3 1/3", /*span4 span4 span4*/
				  __pe("1/4 1/4 2/4") => "1/4 1/4 2/4", /*span3 span3 span6*/
				  __pe("2/4 1/4 1/4") => "2/4 1/4 1/4", /*span6 span3 span3*/ 
				  );


		$options[__pe("4 Column layouts")] = 
			array(
				  __pe("1/4 1/4 1/4 1/4") => "1/4 1/4 1/4 1/4" /*span3 span3 span3 span3*/
				  );


		$options[__pe("6 Column layouts")] = 
			array(
				  __pe("1/6 1/6 1/6 1/6 1/6 1/6") => "1/6 1/6 1/6 1/6 1/6 1/6" /*span2 x 6*/
				  );


		return apply_filters("pe_theme_shortcode_columns_options",$options);
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
		$class = strtr($sc_class,
					   apply_filters("pe_theme_shortcode_columns_mapping",
							  array(
									"1/6" => "span2",
									"1/4" => "span3",
									"1/3" => "span4",
									"1/2" => "span6",
									"2/4" => "span6",
									"2/3" => "span8",
									"3/4" => "span9",
									"5/6" => "span10",
									"last" => ""
							  ))
					   );
		$content = $this->parseContent($content);
		return "<div class=\"$class\">$content</div>";
	}

	public function container($atts,$content=null,$code="") {
		$content = $this->parseContent($content);
		return apply_filters("pe_theme_shortcode_columns_container",sprintf('<div class="row-fluid">%s</div>',$content),$content);
	}

}

?>
