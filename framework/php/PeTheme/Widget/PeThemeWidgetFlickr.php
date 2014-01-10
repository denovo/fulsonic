<?php

class PeThemeWidgetFlickr extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Flickr");
		$this->description = __pe("Displays Flickr Image Thumbnails");
		$this->wclass = "widget_flickr";

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title."),
									"default"=>"Flickr Widget"
									),
							  "username" => 
							  array(
									"label"=>__pe("Username"),
									"type"=>"Text",
									"description" => __pe("Flickr username ID Number from which to load images."),
									"default"=>"68880463@N03"
									),
							  "count" => 
							  array(
									"label"=>__pe("Number Of Images"),
									"type"=>"Select",
									"description" => __pe("Select the number of images to be displayed.(3 per row)"),
									"single" => true,
									"options" => range(1,10),
									"default"=>6
									)/*,
							  "cols" => 
							  array(
									"label"=>__pe("Columns"),
									"type"=>"Select",
									"description" => __pe("Select the number of columns."),
									"single" => true,
									"options" => range(1,10),
									"default"=>3
									)*/
							  
							  );

		parent::__construct();
	}

	public function getContent(&$instance) {
		extract($instance);
		$cols = 3;
		$html = <<<EOL
<h3>$title</h3>
<div class="flickr" data-userID="$username" data-count="$count" data-cols="$cols"></div>
EOL;


		return $html;
	}


}
?>
