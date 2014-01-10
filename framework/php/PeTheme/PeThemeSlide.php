<?php

class PeThemeSlide {

	protected $master;
	protected $fields;

	public function __construct(&$master) {
		$this->master =& $master;
	}

	public function registerAssets() {
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.slide.js",array("pe_theme_utils","editor","json2"),"pe_theme_slide");
		
		// prototype.js alters JSON2 behaviour, it shouldn't be loaded in our admin page anyway but
		// if other plugins are forcing it in all wordpress admin pages, we get rid of it here.
		wp_deregister_script("prototype");
	}

	public function cpt() {
		$cpt = 
			array(
				  'labels' => 
				  array(
						'name'              => __pe("Slides"),
						'singular_name'     => __pe("Slide"),
						'add_new_item'      => __pe("Add New Slide"),
						'search_items'      => __pe('Search Slides'),
						'popular_items' 	  => __pe('Popular Slides'),		
						'all_items' 		  => __pe('All Slides'),
						'parent_item' 	  => __pe('Parent Slide'),
						'parent_item_colon' => __pe('Parent Slide:'),
						'edit_item' 		  => __pe('Edit Slide'), 
						'update_item' 	  => __pe('Update Slide'),
						'add_new_item' 	  => __pe('Add New Slide'),
						'new_item_name' 	  => __pe('New Slide Name')
						),
				  'public' => true,
				  'has_archive' => false,
				  "supports" => array("title","editor","thumbnail"),
				  "taxonomies" => array("post_format")
				  );

		PeGlobal::$config["post_types"]["slide"] = $cpt;
		//PeGlobal::$config["post-formats-slide"] = array("gallery");


		$mbox = 
			array(
				  "title" => __pe("Layers Builder"),
				  "type" => "",
				  "priority" => "core",
				  "where" =>
				  array(
						"post" => "all"
						),
				  "content" =>
				  array(
						"preview" => 	
						array(
							  "section" => "preview",
							  "type"=>"LayersBuilder",
							  "default" => "940x300",
							  ),
						"captions" => 
						array(
							  "section" => "main",
							  "label"=>"",
							  "type"=>"Items",
							  "description" => "",
							  "button_label" => __pe("Add New Layer"),
							  "sortable" => true,
							  "auto" => __pe("Layer"),
							  "unique" => false,
							  "editable" => true,
							  "legend" => true,
							  "fields" => 
							  array(
									array(
										  "name" => "content",
										  "type" => "textimg",
										  "width" => 300,
										  "default" => ""
										  ),
									array(
										  "name" => "x",
										  "type" => "text",
										  "width" => 40, 
										  "default" => "10"
										  ),
									array(
										  "name" => "y",
										  "type" => "text",
										  "width" => 40,
										  "default" => "10"
										  ),
									array(
										  "name" => "delay",
										  "type" => "text",
										  "width" => 50,
										  "default" => "10"
										  ),
									array(
										  "name" => "transition",
										  "type" => "hidden",
										  "default" => ""
										  ),
									),
							  "default" => ""
							  ),
						"transition" => 
						array(
							  "label"=>__pe("Transition Type"),
							  "type"=>"Select",
							  "section"=>"edit",
							  "options"=>
							  array(
									__pe("Fade") => "fade",
									__pe("Fly from left") => "flyLeft",
									__pe("Fly from right") => "flyRight",
									__pe("Fly from top") => "flyTop",
									__pe("Fly from bottom") => "flyBottom",
									),
							  "default"=>"fade"
							  ),
						"backgroundColor" =>
						array(
							  "label"=>__pe("Background color"),
							  "type"=>"Color",
							  "section"=>"edit",
							  "default"=> "#000000"
							  ),
						"backgroundAlpha" =>
						array(
							  "label"=>__pe("Background opacity."),
							  "type"=>"Select",
							  "section"=>"edit",
							  "options"=>
							  array(
									__pe("No background") => "",
									__pe("10%") => "0.1",
									__pe("20%") => "0.2",
									__pe("30%") => "0.3",
									__pe("40%") => "0.4",
									__pe("50%") => "0.5",
									__pe("60%") => "0.6",
									__pe("70%") => "0.7",
									__pe("80%") => "0.8",
									__pe("90%") => "0.9",
									__pe("100%") => "1",
									),
							  "default"=> "0.5"
							  ),
						"saveCaption" => 
						array(
							  "label"=>__pe("Save current layer"),
							  "type"=>"Button",
							  "section"=>"edit",
							  "default"=> ""
							  )
						)
				  );

		$mboxFormat = 
			array(
				  "title" => __pe("Format"),
				  "type" => "Plain",
				  "context" => "side",
				  "priority" => "core",
				  "where" =>
				  array(
						"post" => "all"
						),
				  "content" =>
				  array(
						"type" => 
						array(
							  "label"=>"",
							  "type"=>"RadioUI",
							  "options"=>
							  array(
									__pe("Normal") => "normal",
									__pe("Layers") => "layers"
									),
							  "default"=>"normal"
							  ),
						)
				  );

		PeGlobal::$config["metaboxes-slide"] = 
			array(
				  "layers" => $mbox,
				  "format" => $mboxFormat
				  );
		
		add_action('add_meta_boxes_slide',array(&$this,'add_meta_boxes_slide'));
	}

	public function option() {
		$posts = get_posts(
						   array(
								 "post_type" => "slide",
								 "posts_per_page" => -1,
								 "suppress_filters" => 0
								 )
						   );
		if (count($posts) > 0) {
			$options = array();
			$options[__pe("No Slide")] = 0;
			foreach($posts as $post) {
				$options[$post->post_title] = $post->ID;
			}
		} else {
			$options = array(__pe("No slides defined.")=>-1);
		}
		return $options;
	}

	public function add_meta_boxes_slide() {
		// layer builder
		$this->registerAssets();
		wp_enqueue_script("pe_theme_slide");
	}

	public function output($captions) {

		if ($captions and is_array($captions)) {
			foreach ($captions as $caption) {
				if (isset($caption->data)) {
					$name = $caption->name;
					$caption =& $caption->data;
					$style = "";
					if (isset($caption->backgroundAlpha) && floatval($caption->backgroundAlpha) > 0) {
						$c = isset($caption->backgroundColor) ? $caption->backgroundColor : "#000000" ;
						$style = sprintf("background-color: %s;",$c);
						if (floatval($caption->backgroundAlpha) < 1) {
							$style .= sprintf(
											  " background-color: rgba(%s,%s,%s,%s);",
											  hexdec(substr($c, 1, 2)),
											  hexdec(substr($c, 3, 2)),
											  hexdec(substr($c, 5, 2)),
											  $caption->backgroundAlpha
											  );
						}
						$style = "style=\"{$style}\"";
					}
					printf(
						   '<div class="%s %s %s" %s data-align="%s" data-transition="%s" data-delay="%s" data-offset="%s">%s</div>',
						   "peCaption",
						   isset($caption->visibility) ? $caption->visibility : "",
						   "peCaption_".sanitize_title_with_dashes($name),
						   $style,
						   isset($caption->align) ? $caption->align : "center,left",
						   isset($caption->transition) ? $caption->transition : "fade",
						   isset($caption->delay) ? $caption->delay : "0",
						   isset($caption->offset) ? $caption->offset : "0,0",
						   isset($caption->content) ? PeThemeShortcode::parseContent($caption->content) : ""
						   );					
				}
			}
		}
	}

}

?>
