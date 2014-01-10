<?php

class PeThemeWidgetSocialLinks extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Social links");
		$this->description = __pe("Link to social profiles");
		$this->wclass = "widget_social";
		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Social Media Widget"
									),
							  "links" => 
							  array(
									"label"=>__pe("Links"),
									"type"=>"Links",
									"description" => __pe("Paste your social media profile links one at a time and hit the Add New button. The link will be added to a table below and the appropriate icon will be automatically selected based on the link's domain name"),
									"sortable" => true,
									"default"=>""
									)
							 
							  );

		parent::__construct();
	}

	public function &getContent(&$instance) {
		extract($instance);
		$html = "";
		if (!isset($links)) return $html;
		$html = isset($title) ? "<h3>$title</h3>" : "";
		$html .= peTheme()->content->getSocialLinks($links);
		return $html;
	}


}
?>
