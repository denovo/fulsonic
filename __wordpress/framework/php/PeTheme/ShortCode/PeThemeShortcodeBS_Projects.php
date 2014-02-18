<?php

class PeThemeShortcodeBS_Projects extends PeThemeShortcode {

	public $instances = 0;
	public $count;
	public $custom;

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "projects";
		$this->group = __pe("CONTENT");
		$this->name = __pe("Projects");
		$this->description = __pe("Projects");
		$this->fields = array(
							  "count" =>
							  array(
									"label" => __pe("Max Projects"),
									"type" => "Text",
									"description" => __pe("Maximum number of projects to display."),
									"default" => 10,
									),
							  "tag" =>
							  array(
									"label" => __pe("Project Tag"),
									"type" => "Select",
									"description" => __pe("Only display projects from a specific project tag."),
									"options" => array_merge(array(__pe("All")=>""),peTheme()->data->getTaxOptions("prj-category")),
									"default" => ""
									)
							  );

	}

	
	public function output($atts,$content=null,$code="") {

		$defaults = apply_filters("pe_theme_shortcode_projects_defaults",array('count'=>3,'tag'=> ''),$atts);
		$conf = (object) shortcode_atts($defaults,$atts);

		$t =& peTheme();
		$content = "";

		if ($loop =& $t->project->customLoop($conf->count,$conf->tag,false)) {

			ob_start();
			$t->template->data($conf,$loop);
			$t->get_template_part("shortcode","projects");
			$content =& ob_get_clean();
			$t->content->resetLoop();

		}

		return $content;

	}


}

?>
