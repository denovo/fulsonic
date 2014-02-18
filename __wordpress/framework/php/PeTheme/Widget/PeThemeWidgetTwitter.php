<?php

class PeThemeWidgetTwitter extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Twitter");
		$this->description = __pe("Displays the latest tweets");
		$this->wclass = "widget_twitter";

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Twitter"
									),
							  "username" => 
							  array(
									"label"=>__pe("Username"),
									"type"=>"Text",
									"description" => __pe("Twitter username from which to load tweets"),
									"default"=>"envato"
									),
							  "count" => 
							  array(
									"label"=>__pe("Number Of Tweets"),
									"type"=>"RadioUI",
									"description" => __pe("Select the number of tweets to be displayed"),
									"single" => true,
									"options" => range(1,10),
									"default"=>2
									),
							  
							  );

		parent::__construct();
	}

	public function getContent(&$instance) {
		extract($instance);
		$html = <<<EOL
<h3>$title <a class="followBtn" href="https://twitter.com/#!/$username"><span class="label">follow</span></a></h3>
<div class="twitter" data-topdate="false" data-count="$count" data-username="$username"></div>
EOL;


		return $html;
	}


}
?>
