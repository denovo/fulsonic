<?php

class PeThemeConstantProject {
	public $all;
	public $metabox;

	public function __construct() {
		$this->all = $this->all =& peTheme()->project->option();

		$this->metabox = 
			array(
				  "title" =>__pe("Project"),
				  "priority" => "core",
				  "type" => "Project",
				  "where" => 
				  array(
						"project" => "all",
						),
				  "content"=>
				  array(
						"subtitle" => 	
						array(
							  "label"=>__pe("Subtitle"),
							  "type"=>"Text",
							  "description" => __pe("Specify a project subtitle. This will be shown on the portfolio single column page as well as the single project pages. "),
							  "default"=>'Subtitle here'
							  ),
						"icon" => 	
						array(
							  "label"=>__pe("Icon"),
							  "type"=>"Select",
							  "description" => __pe("Select an icon which represents the contents or theme of this project. This icon will be shown on all portfolio and project pages. "),
							  "options" => apply_filters("pe_theme_project_icons",
							  array(
									__pe("Image")=>"icon-picture",
									__pe("Film")=>"icon-film",
									__pe("Video")=>"icon-facetime-video",
									__pe("Music")=>"icon-music",
									__pe("File")=>"icon-file",
									__pe("Review")=>"icon-search",
									__pe("List")=>"icon-list",
									__pe("Thumbnails")=>"icon-th",
									__pe("Book")=>"icon-book",
									__pe("Photography")=>"icon-camera",
									__pe("Typography")=>"icon-font",
									__pe("Private")=>"icon-lock",
									__pe("Info")=>"icon-info-sign",
									__pe("Event")=>"icon-calendar",
									__pe("Commentary")=>"icon-comment",
									__pe("Announcement")=>"icon-bullhorn",
									__pe("Business")=>"icon-briefcase",
									__pe("World")=>"icon-globe",
									__pe("Location")=>"icon-map-marker",
									__pe("Illustration")=>"icon-pencil",
									__pe("Person")=>"icon-user"
									)),
							  "default"=> apply_filters("pe_theme_project_default_icon",'icon-picture')
							  )
						)
				  );

		$layouts = apply_filters("pe_theme_project_layouts",array());
		if (count($layouts) > 0) {
			$this->metabox["content"]["layout"] =
				array(
					  "label"=>__pe("Layout"),
					  "type"=>"Select",
					  "description" => __pe("Select project layout."),
					  "options" => $layouts,
					  "default" =>"right"
					  );
		}

		$this->metaboxFeatured = 
			array(
				  "title" =>__pe("Featured Project"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-portfolio",
						),
				  "content"=>
				  array(
						"featured" => 
						array(
							  "label"=>__pe("Project"),
							  "type"=>"Select",
							  "description" => __pe("Select the project you wish to be featured. (Shown full width at top of page)"),
							  "options" =>
							  array_merge(
										  array(__pe("None") => ""),
										  $this->all
										  ),
							  "default"=>""
							  )
						)
				  );

	}
	
}

?>