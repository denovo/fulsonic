<?php

class PeThemeStaff {

	public $master;

	public function __construct($master) {
		$this->master =& $master;
	}

	public function cpt() {
		$cpt = 
			array(
				  'labels' => 
				  array(
						'name'              => __pe("Staff Members"),
						'singular_name'     => __pe("Staff Member"),
						'add_new_item'      => __pe("Add New Staff Member"),
						'search_items'      => __pe('Search Staff Members'),
						'popular_items' 	  => __pe('Popular Staff Members'),		
						'all_items' 		  => __pe('All Staff Members'),
						'parent_item' 	  => __pe('Parent Staff Member'),
						'parent_item_colon' => __pe('Parent Staff Member:'),
						'edit_item' 		  => __pe('Edit Staff Member'), 
						'update_item' 	  => __pe('Update Staff Member'),
						'add_new_item' 	  => __pe('Add New Staff Member'),
						'new_item_name' 	  => __pe('New Staff Member Name')
						),
				  'public' => true,
				  'has_archive' => false,
				  "supports" => array("title","editor","thumbnail"),
				  "taxonomies" => array("")
				  );

		PeGlobal::$config["post_types"]["staff"] = $cpt;

		$mbox = 
			array(
				  "title" => __pe("Personal Info"),
				  "type" => "",
				  "priority" => "core",
				  "where" =>
				  array(
						"staff" => "all"
						),
				  "content" =>
				  array(
						"position" => 	
						array(
							  "label"=>__pe("Position"),
							  "type"=>"Text",
							  "default"=>__pe("Founder/Partner")
							  ),
						"twitter" => 	
						array(
							  "label"=>__pe("Twitter Link"),
							  "type"=>"Text",
							  "default"=>""
							  ),
						"linkedin" => 	
						array(
							  "label"=>__pe("LinkedIn Link"),
							  "type"=>"Text",
							  "default"=>""
							  ),
						"facebook" => 	
						array(
							  "label"=>__pe("Facebook Link"),
							  "type"=>"Text",
							  "default"=>""
							  )
						)
				  
				  );

		PeGlobal::$config["metaboxes-staff"] = 
			array(
				  "info" => $mbox
				  );
			
	}

	public function option() {
		$posts = get_posts(
						   array(
								 "post_type"=>"staff",
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
			$options = array(__pe("No staff member defined.")=>-1);
		}
		return $options;
	}

}

?>