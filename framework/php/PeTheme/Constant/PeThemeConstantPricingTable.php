<?php

class PeThemeConstantPricingTable {
	public $all;
	public $fields;
	public $metabox;

	public function __construct() {
		$this->all = peTheme()->ptable->option();

		$this->metabox = 
			array(
				  "title" => __pe("Table Properties"),
				  "type" => "",
				  "priority" => "core",
				  "where" =>
				  array(
						"ptable" => "all"
						),
				  "content" =>
				  array(
						"title" => 	
						array(
							  "label"=>__pe("Title"),
							  "type"=>"Text",
							  "description" => __pe("Table title. "),
							  "default"=>__pe("Package One")
							  ),
						"price" => 	
						array(
							  "label"=>__pe("Price Box"),
							  "type"=>"TextArea",
							  "description" => __pe("Price box content, can be html."),
							  "default"=>__pe("<h2><span>$199</span> Plus monthly free</h2>")
							  ),
						"features" => 
						array(
							  "label"=>__pe("Features"),
							  "type"=>"Links",
							  "description" => __pe("Add one or more features."),
							  "sortable" => true,
							  "unique" => false,
							  "default"=>array(__pe("Feature 1"),__pe("Feature 2"),__pe("Feature 3"))
							  ),
						"button_label" => 	
						array(
							  "label"=>__pe("Button Label"),
							  "type"=>"Text",
							  "default"=>__pe("Sign Up")
							  ),
						"button_link" => 	
						array(
							  "label"=>__pe("Button Link"),
							  "type"=>"Text",
							  "default"=>"#"
							  )
						)
				  
				  );

		$this->metaboxGroup =
			array(
				  "type" =>"",
				  "title" =>__pe("Pricing Tables"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-pricing_table",
						),
				  "content"=>
				  array(
						"items" => 
						array(
							  "label"=>__pe("Tables"),
							  "type"=>"Links",
							  "description" => __pe("Add one or more pricing tables."),
							  "sortable" => true,
							  "options"=> $this->all
							  ),
						"labels" =>				
						array(
							  "label"=>__pe("Show Labels"),
							  "type"=>"RadioUI",
							  "description"=>__pe('If set to "YES", the first table will be used to show property labels.'),
							  "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							  "default"=>"no"
							  ),
						"starter" => 
						array(
							  "label"=>__pe("Starter"),
							  "type"=>"RadioUI",
							  "description" => __pe('Which table should be highlighted as "Starter" pack, "1" = highlight first table.'),
							  "options" => 
							  array(
									__pe("None") => 0,
									"1" => 1,
									"2" => 2,
									"3" => 3,
									"4" => 4,
									"5" => 5,
									),
							  "default"=> 0
							  ),
						"popular" => 
						array(
							  "label"=>__pe("Popular"),
							  "type"=>"RadioUI",
							  "description" => __pe('Which table should be highlighted as "Popular" pack, "1" = highlight first table.'),
							  "options" => range(1,5),
							  "single" => true,
							  "default"=> 2
							  )
						)
				  
				  );

		

	}
	
}

?>