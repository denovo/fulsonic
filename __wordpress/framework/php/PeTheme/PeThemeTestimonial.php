<?php

class PeThemeTestimonial {

	public $master;
	public $slug = "testimonial";

	public function __construct($master) {
		$this->master =& $master;
	}

	public function cpt() {
		$cpt = 
			array(
				  'labels' => 
				  array(
						'name'              => __pe("Testimonials"),
						'singular_name'     => __pe("Testimonial"),
						'add_new_item'      => __pe("Add New Testimonial"),
						'search_items'      => __pe('Search Testimonials'),
						'popular_items' 	  => __pe('Popular Testimonials'),		
						'all_items' 		  => __pe('All Testimonials'),
						'parent_item' 	  => __pe('Parent Testimonial'),
						'parent_item_colon' => __pe('Parent Testimonial:'),
						'edit_item' 		  => __pe('Edit Testimonial'), 
						'update_item' 	  => __pe('Update Testimonial'),
						'add_new_item' 	  => __pe('Add New Testimonial'),
						'new_item_name' 	  => __pe('New Testimonial Name')
						),
				  'public' => true,
				  'has_archive' => false,
				  "supports" => array("title","editor"),
				  "taxonomies" => array("")
				  );

		PeGlobal::$config["post_types"][$this->slug] = $cpt;

		$mbox = 
			array(
				  "title" => __pe("Info"),
				  "type" => "",
				  "priority" => "core",
				  "where" =>
				  array(
						"staff" => "all"
						),
				  "content" =>
				  array(
						"type" => 	
						array(
							  "label"=>__pe("Type"),
							  "type"=>"Text",
							  "default"=>__pe("Web Client")
							  )
						)
				  );

		PeGlobal::$config["metaboxes-".$this->slug] = 
			array(
				  "info" => $mbox
				  );
			
	}

	public function customLoop($id) {
		return $this->master->content->customLoop($this->slug,-1,null,array("post__in" => $id,"orderby" => "post__in"),false);
	}


	public function option() {
		$posts = get_posts(
						   array(
								 "post_type"=>$this->slug,
								 "posts_per_page"=>-1
								 )
						   );
		if (count($posts) > 0) {
			$options = array();
			foreach($posts as $post) {
				$options[$post->post_title] = $post->ID;
			}
		} else {
			$options = array(__pe("No testimonial defined.")=>-1);
		}
		return $options;
	}

}

?>