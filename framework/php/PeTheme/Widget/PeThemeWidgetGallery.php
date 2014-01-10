<?php

class PeThemeWidgetGallery extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Gallery");
		$this->description = __pe("Show a gallery");
		$this->wclass = "widget_gallery";

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Gallery widget"
									),
							  "size" => 
							  array(
									"label"=>__pe("Size"),
									"type"=>"Text",
									"description" => __pe("Gallery widget size"),
									"default"=>"218x180"
									),
							  "id" => PeGlobal::$const->gallery->id
							  );

		parent::__construct();
	}


	public function widget($args,$instance) {
		$instance = $this->clean($instance);

		extract($instance);

		if (!@$id) return;
		$post = get_post($id);
		if (!$post) return;
		echo $args["before_widget"];
		if (isset($title)) echo "<h3>$title</h3>";
		list($w,$h) = explode("x",$size);
		echo "<div>";
		$t =& peTheme();
		$t->data->postSetup($post);
		$t->template->gallery_cover($w,$h);
		$t->data->postReset();
		$t->template->intro_gallery($id,90,74,"fullscreen");
		echo "</div>";
		echo $args["after_widget"];
	}


}
?>
