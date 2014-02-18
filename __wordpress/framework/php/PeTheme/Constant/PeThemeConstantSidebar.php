<?php

class PeThemeConstantSidebar {
	public $all;
	public $fields;
	public $metabox;

	public function __construct() {
		$this->all = array_merge(array(__pe("No sidebar")=>"-none-"),peTheme()->sidebar->option());

		$this->fields = new stdClass();

		$this->fields->sidebar = 
			array(
				  "label"=>__pe("Sidebar"),
				  "type"=>"SelectPlain",
				  "section"=>__pe("General"),
				  "description" => __pe("Select which sidebar to use"),
				  "options" => $this->all,
				  "default"=>"default"
				  );


		$this->metabox = 
			array(
				  "type" =>"Plain",
				  "title" =>__pe("Sidebar"),
				  "context" => "side",
				  "priority" => "core",
				  "where" => 
				  array(
						"post" => "all"
						),
				  "content"=>
				  array(
						"value" => $this->fields->sidebar
						)
				  );
		
		$this->metaboxFooter = 
			array(
				  "title" => __pe("Footer")
				  );

		$this->metaboxFooter = array_merge($this->metabox,$this->metaboxFooter);
		$this->metaboxFooter["content"]["value"]["options"] = peTheme()->sidebar->option();
		$this->metaboxFooter["content"]["value"]["default"] = "footer";

	}
	
}

?>