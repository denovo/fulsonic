<?php

class PeThemeConstantBlog {
	public $metabox;

	public function __construct() {
		$this->metabox = 
			array(
				  "title" =>__pe("Blog"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-blog",
						),
				  "content"=>
				  array(
						"layout" =>
						array(
							  "label"=>__pe("Layout"),
							  "type"=>"RadioUI",
							  "description" => __pe("Select the required post layout. 'Full' - denotes a full width normal blog layout. 'Compact' - denotes a full width list style layout. 'Mini' - denotes a compressed layout with small post thumbnails."),
							  "options" => PeGlobal::$config["blog"],
							  "default"=>""
							  ),
						"count" =>
						array(
							  "label" => __pe("Max Posts"),
							  "type" => "Text",
							  "description" => __pe("Maximum number of posts to show."),
							  "default" => get_option("posts_per_page"),
							  ),
						"media" => 
						array(
							  "label"=>__pe("Show Media"),
							  "type"=>"RadioUI",
							  "description" => __pe("Specify if the post's image/video/gallery media is displayed."),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"yes"
							  ),
						"pager" => 
						array(
							  "label"=>__pe("Paged Result"),
							  "type"=>"RadioUI",
							  "description" => __pe("Display a pager when more posts are found than specified in the 'Maximum' field. "),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"yes"
							  ),
						"sticky" => 
						array(
							  "label"=>__pe("Include Sticky Posts"),
							  "type"=>"RadioUI",
							  "description" => __pe("Include sticky posts in the displayed list."),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"yes"
							  ),
						"category" =>
						array(
							  "label" => __pe("Category"),
							  "type" => "Select",
							  "description" => __pe("Only show posts from a specific category."),
							  "options" => array_merge(array(__pe("All")=>""),peTheme()->data->getTaxOptions("category")),
							  "default" => ""
							  ),
						"tag" =>
						array(
							  "label" => __pe("Tag"),
							  "type" => "Select",
							  "description" => __pe("Only show posts with a specific tag."),
							  "options" => array_merge(array(__pe("All")=>""),peTheme()->data->getTaxOptions("post_tag")),
							  "default" => ""
							  ),
						"format" =>
						array(
							  "label" => __pe("Post Format"),
							  "type" => "Select",
							  "description" => __pe("Only show posts of a specific format."),
							  "options" => array_merge(array(__pe("All")=>""),array_combine(PeGlobal::$config["post-formats"],PeGlobal::$config["post-formats"])),
							  "default" => ""
							  )
						)
				  );
		if (count(PeGlobal::$config["blog"]) < 2) {
			unset($this->metabox["content"]["layout"]);
		}
	}
	
}

?>