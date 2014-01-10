<?php

class PeThemeService {

	public $master;

	public function __construct($master) {
		$this->master =& $master;
	}

	public function cpt() {
		$cpt = 
			array(
				  'labels' => 
				  array(
						'name'              => __pe("Services"),
						'singular_name'     => __pe("Service"),
						'add_new_item'      => __pe("Add New Service"),
						'search_items'      => __pe('Search Services'),
						'popular_items' 	  => __pe('Popular Services'),		
						'all_items' 		  => __pe('All Services'),
						'parent_item' 	  => __pe('Parent Service'),
						'parent_item_colon' => __pe('Parent Service:'),
						'edit_item' 		  => __pe('Edit Service'), 
						'update_item' 	  => __pe('Update Service'),
						'add_new_item' 	  => __pe('Add New Service'),
						'new_item_name' 	  => __pe('New Service Name')
						),
				  'public' => true,
				  'has_archive' => false,
				  "supports" => array("title","editor"),
				  "taxonomies" => array("")
				  );

		PeGlobal::$config["post_types"]["service"] = $cpt;

		$mbox = 
			array(
				  "title" => __pe("Service Info"),
				  "type" => "",
				  "priority" => "core",
				  "where" =>
				  array(
						"service" => "all"
						),
				  "content" =>
				  array(
						"icon" => 	
						array(
							  "label"=>__pe("Icon"),
							  "type"=>"RadioUI",
							  "options" => 
							  array(
									__pe("Icon 1") => "01",
									__pe("Icon 2") => "02",
									__pe("Icon 3") => "03"
									),
							  "default"=>"01"
							  ),
						"features" => 
						array(
							  "label"=>__pe("Features"),
							  "type"=>"Links",
							  "description" => __pe("Add one or more service features."),
							  "sortable" => true,
							  "default"=>""
							  )
						)
				  
				  );

		PeGlobal::$config["metaboxes-service"] = 
			array(
				  "info" => $mbox
				  );
			
	}

	public function option() {
		$posts = get_posts(
						   array(
								 "post_type"=>"service",
								 "suppress_filters"=>false,
								 "posts_per_page"=>-1
								 )
						   );
		if (count($posts) > 0) {
			$options = array();
			foreach($posts as $post) {
				$options[$post->post_title] = $post->ID;
			}
		} else {
			$options = array(__pe("No service defined.")=>-1);
		}
		return $options;
	}

}

?>