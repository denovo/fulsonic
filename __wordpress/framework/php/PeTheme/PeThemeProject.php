<?php

class PeThemeProject {

	protected $master;
	protected $portfolioLoop;

	public $custom = "project";
	public $taxonomy = "prj-category";
	public $emtpyMsg;

	public function __construct(&$master) {
		$this->master =& $master;
		$this->emptyMsg = __pe("No project defined, please create one");
	}

	public function option() {
		$posts = get_posts(
						   array(
								 "post_type"=>$this->custom,
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
			$options = array($this->emptyMsg=>-1);
		}
		return $options;
	}

	public function cpt() {
		$cpt = 
			array(
				  'labels' => 
				  array(
						'name'              => __pe("Projects"),
						'singular_name'     => __pe("Project"),
						'add_new_item'      => __pe("Add New Project"),
						'search_items'      => __pe('Search Projects'),
						'popular_items' 	  => __pe('Popular Projects'),		
						'all_items' 		  => __pe('All Projects'),
						'parent_item' 	  => __pe('Parent Project'),
						'parent_item_colon' => __pe('Parent Project:'),
						'edit_item' 		  => __pe('Edit Project'), 
						'update_item' 	  => __pe('Update Project'),
						'add_new_item' 	  => __pe('Add New Project'),
						'new_item_name' 	  => __pe('New Project Name')
						),
				  'public' => true,
				  'has_archive' => false,
				  "supports" => array("title","editor","thumbnail","post-formats"),
				  "taxonomies" => array("post_format")
				  );

		$tax = 
			array(
				  'project',
				  array(
						'label' => __pe('Project Tags'),
						'sort' => true,
						'args' => array('orderby' => 'term_order' ),
						'show_in_nav_menus' => false,
						'rewrite' => array('slug' => 'projects' )
						)
				  );

		PeGlobal::$config["post_types"]["project"] =& $cpt;
		PeGlobal::$config["taxonomies"]["prj-category"] =& $tax;
	}


	public function &get($id) {
		if (isset($this->cache[$id])) return $this->cache[$id];
		$post =& get_post($id);
		if (!$post) return false;
		$meta =& $this->master->meta->get($id,$post->post_type);
		$post->meta = $meta;
		return $post;
	}

	public function exists($id) {
		return $this->get($id) !== false;
		
	}

	public function filter($sep = "",$aclass="label") {
		$tags = false;
		$meta =& $this->master->content->meta();
		if (isset($meta->portfolio->tags) && ($tags = $meta->portfolio->tags) && is_array($tags) && count($tags) > 0) {
			$tags = array_flip($tags);
		}
		$terms = get_terms($this->taxonomy);
		$output = "";
		if (is_array($terms) && count($terms) > 0) {
			$output = apply_filters("pe_theme_project_filter_item",sprintf('<a class="%s active" data-category="" href="#">%s</a>%s',$aclass,__pe("All"),"$sep\n"),$aclass,"",__pe("All"));
			foreach ($terms as $term) {
				if ($tags && !isset($tags[$term->slug])) continue;
				$output .= apply_filters("pe_theme_project_filter_item",sprintf('<a class="%s" data-category="%s" href="#">%s</a>%s',$aclass,$term->slug,$term->name,"$sep\n"),$aclass,$term->slug,$term->name);
			}
			print $output;
		}
	}

	public function filterClasses() {
		global $post;
		$classes = wp_get_post_terms($post->ID,$this->taxonomy,array("fields" => "slugs"));
		if (is_array($classes) && ($count = count($classes)) > 0) {
			while($count--) {
				$classes[$count] = "filter-".$classes[$count];
			}
			echo join(" ",$classes);
		}
	}

	public function tags($sep=", ") {
		echo get_the_term_list(null, $this->taxonomy, "", $sep,"");
	}


	public function filterNames() {
		global $post;
		$names = wp_get_post_terms($post->ID,$this->taxonomy,array("fields" => "names"));
		if (is_array($names) && ($count = count($names)) > 0) {
			echo join(", ",$names);
		}
	}

	public function portfolio($settings,$showpager = true) {
		global $post;
		
		$exclude = false;

		// prevents nested portfolios
		if ($this->portfolioLoop) return;
		$this->portfolioLoop = true;

		// prevents loops
		if (isset($post) && $post) {
			$exclude = $post->ID;
		}

		if (is_string($settings) && !empty($settings)) {
			$id = $settings;
			$post = get_post($id);
			if (!$post) return;
			$meta = $this->master->meta->get($id,$post->post_type);
			if (empty($meta->portfolio)) return true;
			$settings = $meta->portfolio;
		}

		$settings = (object) shortcode_atts(
											array(
												  "columns" => apply_filters("pe_theme_portfolio_default_layout",3),
												  "id" => array(),
												  "filterable" => "yes",
												  "count" => "",
												  "pager" => "yes",
												  "tags" => "",
												  "template" => "portfolio"
												  ),
											(array) $settings
											);

		// prevents loops
		if ($exclude) {
			$custom = array("post__not_in" => array($exclude));
		}

		if (count($settings->id) > 0) {
			$custom = array("post__in" => $settings->id);
			$custom['orderby'] = "post__in";
		}

		if ($settings->tags) {
			$custom[$this->taxonomy] = join(",",$settings->tags);
		}
		
		$settings->count = intval(empty($settings->count) ? -1 : $settings->count); 
		$settings->pager = $settings->count != -1 && !empty($settings->pager) && $settings->pager == "yes" ;

		/*
		if ($settings->format) {
			$tax_query = array(
							   array(
									 'taxonomy' => 'post_format',
									 'field' => 'slug',
									 'terms' => array("post-format-{$settings->format}")
									 )
							   );
			$custom["tax_query"] = $tax_query;
		}
		*/

		$content =& $this->master->content;

		if ($content->customLoop($this->custom,$settings->count,null,$custom,$settings->pager)) { 
	
			$this->master->template->data($settings);
			$this->master->get_template_part($settings->template,empty($conf->type) ? "" : $conf->type);
			
			if ($showpager && $settings->pager) {
				$content->pager();
			}
		}

		$content->resetLoop();

		$this->portfolioLoop = false;
		
	}


	public function customLoop($count,$tags,$paged) {
		$custom = null;
		if (is_array($tags) && count($tags) > 0) {
			$custom[$this->taxonomy] = join(",",$tags);
		}
		return $this->master->content->customLoop($this->custom,$count,null,$custom,$paged);
	}

}

?>
