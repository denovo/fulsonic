<?php

class PeThemeShortcodeBS_Feature extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "feature";
		$this->group = __pe("LAYOUT");
		$this->name = __pe("Feature");
		$this->description = __pe("Add a Feature Box");
		$this->fields = array(
							  "icon"=> 
							  array(
									"label" => __pe("Icon"),
									"type" => "Select",
									"description" => __pe("Select an icon for this feature. See the help docs for a list of the available icons. "),
									"options" => 
									array(
										  __pe("Cloud")=>"icon-feature-cloud",
										  __pe("Minus")=>"icon-feature-minus",
										  __pe("Plus")=>"icon-feature-plus",
										  __pe("Quote")=>"icon-feature-quote",
										  __pe("Eye")=>"icon-feature-eye",
										  __pe("Info")=>"icon-feature-info",
										  __pe("Heart")=>"icon-feature-heart",
										  __pe("Lightbulb")=>"icon-feature-bulb",
										  __pe("Rss")=>"icon-feature-rss",
										  __pe("Award")=>"icon-feature-award",
										  __pe("Stats")=>"icon-feature-stat",
										  __pe("Star")=>"icon-feature-star",
										  __pe("Shield")=>"icon-feature-shield",
										  __pe("Film")=>"icon-feature-film",
										  __pe("Lock")=>"icon-feature-locked",
										  __pe("Ribbon")=>"icon-feature-ribbon",
										  __pe("Share")=>"icon-feature-share",
										  __pe("Location")=>"icon-feature-location",
										  __pe("User")=>"icon-feature-user",
										  __pe("List")=>"icon-feature-list",
										  __pe("Grid")=>"icon-feature-grid",
										  __pe("Comment")=>"icon-feature-comment",
										  __pe("Map")=>"icon-feature-map",
										  __pe("Graph")=>"icon-feature-graph",
										  __pe("Settings")=>"icon-feature-settings",
										  __pe("Tag")=>"icon-feature-tag",
										  __pe("Calendar")=>"icon-feature-calendar",
										  __pe("Mail")=>"icon-feature-mail",
										  __pe("Clock")=>"icon-feature-clock",
										  __pe("Lightening")=>"icon-feature-lightening",
										  __pe("Camera")=>"icon-feature-camera",
										  __pe("Zoom")=>"icon-feature-zoom-in",
										  __pe("Close")=>"icon-feature-close",
										  __pe("Tic")=>"icon-feature-tic",
										  __pe("CircleTic")=>"icon-feature-tic2",
										  __pe("CircleClose")=>"icon-feature-close2",
										  __pe("Document")=>"icon-feature-doc",
										  __pe("Article")=>"icon-feature-article",
										  __pe("Next")=>"icon-feature-next",
										  __pe("Prev")=>"icon-feature-prev",
										  __pe("Down")=>"icon-feature-down",
										  __pe("Up")=>"icon-feature-up",
										  __pe("UpRight")=>"icon-feature-up-right",
										  __pe("DownLeft")=>"icon-feature-down-left"
										  ),
									"default" => "icon-feature-tic"
									),
							  "content" =>
							  array(
									"label" => __pe("Content"),
									"type" => "TextArea",
									"description" => __pe("Enter the feature box text content here. Simple HTML tags are supported."),
									"default" => sprintf('<h3>Title</h3>%s<p>Description</p>',"\n")
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$content = $content ? $this->parseContent($content) : '';
		$html = sprintf('<div class="feature"><span class="featureIcon"><i class="%s"></i></span><div class="featureContent">%s</div></div>',$icon,$content);
        return trim($html);
	}


}

?>
