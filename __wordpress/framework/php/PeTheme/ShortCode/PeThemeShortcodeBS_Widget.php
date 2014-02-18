<?php

class PeThemeShortcodeBS_Widget extends PeThemeShortcode {

	public $instances = 0;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "widget_sidebar";
		$this->group = __pe("CONTENT");
		$this->name = __pe("Widgets Sidebar");
		$this->description = __pe("Widget");
		$this->fields = array(
							  "id" => 
							  array(
									"label"=>__pe("Widget Area"),
									"type"=>"Select",
									"description" => __pe("Select which widget area to insert. Widget areas need to be created in the 'Theme Options' panel before they will appear in this list."),
									"options" => peTheme()->sidebar->option(),
									"default"=>"default"
									)
							  );

	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		if (!@$id) return "";
		//return peTheme()->widget->inline($id);
		ob_start();
		peTheme()->sidebar->show($id,true);
		$content =& ob_get_contents();
		ob_end_clean();
		return $content;
	}


}

?>
