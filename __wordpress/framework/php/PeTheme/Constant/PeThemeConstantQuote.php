<?php

class PeThemeConstantQuote {
	public $metabox;

	public function __construct() {
		$this->metabox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Quote Options"),
				  "where" => 
				  array(
						"post" => "quote",
						),
				  "content"=>
				  array(
						"text" => 	
						array(
							  "label"=>__pe("Content"),
							  "type"=>"TextArea",
							  "description" => __pe("Text content of the quote box. ( Basic HTML is supported )"),
							  "default"=>'"Lorem ipsum dolor sit amet, <a href="#">consectetuer adipiscing elit</a>, donec odio. Quisque volutpat mattis eros."'
							  ),
						"sign" => 	
						array(
							  "label"=>__pe("Cite"),
							  "type"=>"Text",
							  "description" => __pe("Quote cite"),
							  "default"=>'John Dough, Client'
							  )
						)
				  );
	}
	
}

?>