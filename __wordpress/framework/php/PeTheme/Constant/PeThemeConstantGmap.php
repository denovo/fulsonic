<?php

class PeThemeConstantGmap {
	public $metabox;

	public function __construct() {
		$this->metabox = 
			array(
				  "title" =>__pe("Google Map"),
				  "where" => 
				  array(
						"page" => "page-contact",
						),
				  "content"=>
				  array(
						"show" =>
						array(
							  "label"=>__pe("Show Google Map"),
							  "type"=>"RadioUI",
							  "description" => __pe("Specify whether or not to show the Google map"),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"yes"
							  ),
						"latitude" => 	
						array(
							  "label"=>__pe("Latitude"),
							  "type"=>"Text",
							  "description" => __pe("Latitudinal location for the map center. See the help documentation for a link to a utility used to convert addresses into lat/long numbers"),
							  "default"=>'51.50813'
							  ),
						"longitude" => 	
						array(
							  "label"=>__pe("Longitude"),
							  "type"=>"Text",
							  "description" => __pe("Longitudinal location for the map center. See the help documentation for a link to a utility used to convert addresses into lat/long numbers"),
							  "default"=>'-0.12801'
							  ),
						"zoom" => 	
						array(
							  "label"=>__pe("Zoom Level"),
							  "type"=>"Text",
							  "description" => __pe("Enter the zoom level of the map upon page load. The user is then free to adjust this zoom level using the map UI"),
							  "default"=>'12'
							  ),
						"title" => 	
						array(
							  "label"=>__pe("Map Marker Title"),
							  "type"=>"Text",
							  "description" => __pe("Enter a title for the map marker flyout"),
							  "default"=>'Custom title here'
							  ),
						"description" => 	
						array(
							  "label"=>__pe("Map Marker Description"),
							  "type"=>"TextArea",
							  "description" => __pe("Enter a description for the map marker flyout"),
							  "default"=>'Custom description here'
							  )
						)
				  );
	}
	
}

?>