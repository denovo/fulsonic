<?php

class PeThemeWidgetProject extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Projects");
		$this->description = __pe("Show projects");
		$this->wclass = "widget_portfolio widget_featured";

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=> __pe("Featured Work")
									),
							  "id" => 
							  array(
									"label"=>__pe("Project"),
									"type"=>"Links",
									"description" => __pe("Add one or more projects."),
									"sortable" => true,
									"options"=> PeGlobal::$const->project->all
									)
							 
							  );

		parent::__construct();
	}

	public function &getContent(&$instance) {
		$html = "";

		$settings = shortcode_atts(array('title'=>'','id'=>array(),"template" => "widget-projects"),$instance);
		extract($settings);

		$settings = (object) $settings;

		if (isset($title)) {
			$html .= "<h3>$title</h3>";
		}

		// if no project manually added, just show last 2
		if (count($id) == 0) {
			$settings->count = 2;
		}

		$t =& peTheme();
		
		ob_start();
		$t->project->portfolio($settings);
		$html .= ob_get_clean();

		return $html;
	}



}
?>
