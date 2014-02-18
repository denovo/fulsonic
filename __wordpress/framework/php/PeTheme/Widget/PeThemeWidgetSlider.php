<?php

class PeThemeWidgetSlider extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Slider");
		$this->description = __pe("Show a slider");
		$this->wclass = "widget_slider";

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Slider Widget"
									),
							  "size" => 
							  array(
									"label"=>__pe("Slider Size"),
									"type"=>"Text",
									"description" => __pe("The size of the slider in pixels. Written in the form widthxheight"),
									"default"=>"218x180"
									),
							  );

		$this->fields = array_merge($this->fields,PeGlobal::$const->gallery->metaboxSlider["content"]);

		parent::__construct();
	}


	public function widget($args,$instance) {
		$instance = $this->clean($instance);
		extract($instance);

		if (!@$id) return;		
		echo $args["before_widget"];
		if (isset($title)) echo "<h3>$title</h3>";
		list($w,$h) = explode("x",$size);
		echo "<div>";

		$config = new StdClass();

		foreach ($instance as $key => $value) {
			$config->{$key} = $value;
		}
		
		$loop = peTheme()->gallery->getSliderLoop($id,$w,$h,4,"span4",array("config"=>$config));
		$loop->main->link = false;

		peTheme()->template->slider_volo($loop); 
		echo "</div>";
		echo $args["after_widget"];
	}


}
?>
