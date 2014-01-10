<?php

class PeThemeConstantContact {
	public $metabox;

	public function __construct() {
		$this->metabox = 
			array(
				  "title" =>__pe("Contact Form"),
				  "where" => 
				  array(
						"page" => "page-contact",
						),
				  "content"=>
				  array(
						"msgOK" => 	
						array(
							  "label"=>__pe("Mail Sent Message"),
							  "type"=>"TextArea",
							  "description" => __pe("Message shown when form message has been sent without errors"),
							  "default"=>'<strong>Your Message Has Been Sent!</strong> Thank you for contacting us.'
							  ),
						"msgKO" => 	
						array(
							  "label"=>__pe("Form Error Message"),
							  "type"=>"TextArea",
							  "description" => __pe("Message shown when form message encountered errors"),
							  "default"=>'<strong>Oops, An error has occured!</strong> See the marked fields above to fix the errors.'
							  )
						)
				  );
	}
	
}

?>