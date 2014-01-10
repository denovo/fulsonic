<?php

class PeThemeConstantVideo {
	public $type;
	public $formats;
	public $url;
	public $fields;
	public $metabox;
	public $all;
	public $video;

	public function __construct() {
		$this->all =& peTheme()->video->option();

		$this->type = 
			array(
				  __pe("Youtube")=>"youtube",
				  __pe("Vimeo")=>"vimeo",
				  //__pe("Local video")=>"local",
				  //__pe("Vid.ly")=>"vidly"
				  );

		$this->formats =
			array(
				  __pe("Mp4")=>"mp4",
				  __pe("Ogg")=>"ogv",
				  __pe("Webm")=>"webm"
				  );

		$this->fields = new stdClass();

		$this->fields->type = 
			array(
				  "label"=>__pe("Video Type"),
				  "type"=>"Select",
				  "section"=>__pe("General"),
				  "description" => __pe("Select which type of video you would like to insert."),
				  "options" => $this->type,
				  "default"=>"youtube"
				  );

		$this->fields->url = 
			array(
				  "label"=>__pe("Video Url"),
				  "type"=>"UploadLink",
				  "section"=>__pe("General"),
				  "description" => __pe("Insert here the youtube/vimeo video url."),
				  "options" => $this->type,
				  "default"=>""
				  );

		$this->fields->formats = 							  
			array(
				  "label"=>__pe("Available Formats"),
				  "type"=>"CheckboxUI",
				  "section"=>__pe("General"),
				  "description" => __pe("Some browsers require a video to be uploaded in a specific format. Select the formats uploaded from this list so that they can be served to visitors using those browsers."),
				  "options" => $this->formats,
				  "default"=>"mp4"
				  );

		$this->fields->poster =
			array(
				  "label"=>__pe("Placeholder Image"),
				  "type"=>"Upload",
				  "section"=>__pe("General"),
				  "description" => __pe("This is the image which will be used as the video cover and will disappear once the video begins playing. Enter here the link to this image or click the upload button to upload an image using the WordPress media loader")
				  );

		$description = current($this->all) < 0 ? sprintf(__pe('<a href="%s">Create a new Video</a>'),admin_url('post-new.php?post_type=video')) : __pe("Select which video to use");

		$this->fields->id = 
			array(
				  "label"=>__pe("Use video"),
				  "type"=>"Select",
				  "description" => $description,
				  "options" => $this->all,
				  "default"=>""
				  );

		

		$this->metabox = 
			array(
				  "type" =>"Video",
				  "title" =>__pe("Video Options"),
				  "where" => 
				  array(
						"video" => "all",
						),
				  "content"=>
				  array(
						"type" => $this->fields->type,
						"url" => $this->fields->url,
						//"formats" => $this->fields->formats,
						//"poster" => $this->fields->poster,
						"fullscreen" =>  
						array(
							  "label"=>__pe("Play fullscreen"),
							  "type"=>"RadioUI",
							  "description" => __pe("Specify if video should play in a fullscreen lightbox window."),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"no"
							  )
						)
				  );

		$this->metaboxPost = 
			array(
				  "title" => __pe("Video Options"),
				  "where" =>
				  array(
						"post" => "video"
						),
				  "content" =>
				  array(
						"id" => $this->fields->id
						)
				  );
	}
	
}

?>