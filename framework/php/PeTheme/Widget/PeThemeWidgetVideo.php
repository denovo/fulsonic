<?php

class PeThemeWidgetVideo extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Video");
		$this->description = __pe("Show a video");
		$this->wclass = "widget_video";

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Video Widget"
									),
							  "id" => PeGlobal::$const->video->fields->id
							  );

		parent::__construct();
	}


	public function widget($args,$instance) {
		$instance = $this->clean($instance);
		extract($instance);

		if (!@$id) return;		
		echo $args["before_widget"];
		if (isset($title)) echo "<h3>$title</h3>";
		echo "<div>";
		peTheme()->video->show($id);
		echo "</div>";
		echo $args["after_widget"];
	}


}
?>
