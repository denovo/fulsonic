<?php

class PeThemeShortcodeBS_Tabs extends PeThemeShortcode {

	public $instances = 0;
	protected $items;


	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "tab";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Tabs");
		$this->description = __pe("Tabs");
		$this->fields = array(
							  "size" =>
							  array(
									"label" => __pe("Number of Tabs"),
									"type" => "Select",
									"single" => true,
									"description" => __pe("Select the number of tabs to add"),
									"options" => range(1,10)
									)
							  );

		$this->parentTrigger();
		
	}

	public function parentTrigger() {
		add_shortcode("tabs",array(&$this,"container"));

		// add block level cleaning
		peTheme()->shortcode->blockLevel[] = $this->trigger;
		peTheme()->shortcode->blockLevel[] = "tabs";
	}

	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.shortcode.bs_properties.js",array(),"pe_theme_shortcode_properties");
		wp_enqueue_script("pe_theme_shortcode_properties");
	}

	protected function script() {
		$html = <<<EOT
<script type="text/javascript">
jQuery.pixelentity.shortcodes.$this->trigger = jQuery("#{$this->trigger}_size_").peShortcodeProperties({parent:"tabs",tag:"{$this->trigger}",title:"Tab"});
</script>
EOT;
		echo $html;
	}

	public function render() {
		parent::render();
		$this->script();
	}

	public function output($atts,$content=null,$code="") {
		$item = new StdClass();
		foreach ($atts as $key => $value) {
			$item->{$key} = $value;
		}
		$item->body = $this->parseContent($content);
		$this->items[] = $item;
	}

	public function container($atts,$content=null,$code="") {
		$this->instances++;
		$content = $this->parseContent($content);
		
		$head = $body = "";
		if (!is_array($this->items) || count($this->items) == 0) {
			return "";
		}

		$count = 1;
		$commonID = "tab".$this->instances."_";

		if (peTheme()->template->exists("shortcode","tab")) {
			$items = $this->items;
			$conf = (object) compact("atts","content","items");
			ob_start();
			peTheme()->template->get_part($conf,"shortcode","tab");
			$html = ob_get_clean();
			$this->items = array();
		} else {

			while ($tab = array_shift($this->items)) {
				$id = "{$commonID}_{$count}";
				$head .= sprintf('<li%s><a href="#%s" data-toggle="tab">%s</a></li>',$count == 1 ? ' class="active"' : '',$id,$tab->title);
				$body .= sprintf('<div class="tab-pane%s" id="%s">%s</div>',$count == 1 ? ' active' : '',$id,$tab->body);
				$count++;
			}

			$html = <<<EOL
	<ul class="nav nav-tabs">
		$head
	</ul>  
	<div class="tab-content">
		$body
	</div>
EOL;
}
		return $html;
	}


}

?>
