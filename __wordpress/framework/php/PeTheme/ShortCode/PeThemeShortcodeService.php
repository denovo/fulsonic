<?php

class PeThemeShortcodeService extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "service";
		$this->group = __pe("CONTENT");
		$this->name = __pe("Service");
		$this->description = __pe("Service");
		$this->fields = array(
							  "id" =>
							  array(
									"label" => __pe("Service"),
									"type" => "Select",
									"description" => __pe("Select a service to show."),
									"options" => peTheme()->service->option(),
									"default" => ""
									)
							  );

		// add block level cleaning
		peTheme()->shortcode->blockLevel[] = $this->trigger;

	}


	public function output($atts,$content=null,$code="") {
		
		$content =& peTheme()->content;

		if ($content->customLoop("service",1,null,array("post__in" => array($atts["id"])))) {
			ob_start();
			while ($content->looping()) {
				get_template_part("shortcode","service");
			}
			$html =& ob_get_contents();
			ob_end_clean();
			$content->resetLoop();
		} else {
			$html = "";
		}

		return $html;

	}


}

?>
