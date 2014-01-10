<?php

class PeThemeShortcodeBS_Share extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "share";
		$this->group = __pe("UI");
		$this->name = __pe("Share");
		$this->description = __pe("Add a social share button");
		$this->fields = array(
							  "type"=> 
							  array(
									"label" => __pe("Social Network"),
									"type" => "Select",
									"description" => __pe("Select the social network on which to share content."),
									"options" => 
									array(
										  __pe("Facebook") => "facebook",
										  __pe("Twitter") => "twitter",
										  __pe("Google +1") => "google",
										  __pe("Pinterest") => "pinterest"
										  ),
									"default" => "facebook"
									)
							  );
	}

	public function output($atts,$content=null,$code="") {
		extract($atts);
		$html = sprintf('<button class="share %s"></button>',$type);
        return trim($html);
	}


}

?>
