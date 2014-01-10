<?php

class PeThemeVideo {

	protected $master;
	protected $options;
	protected $cache;

	public function __construct(&$master) {
		$this->master =& $master;
		add_action('pe_theme_metabox_config_video',array(&$this,'pe_theme_metabox_config_video'));
	}

	public function cpt() {
		$cpt =
			array(
				  'labels' => 
				  array(
						'name'              => __pe("Videos"),
						'singular_name'     => __pe("Video"),
						'add_new_item'      => __pe("Add New Video"),
						'search_items'      => __pe('Search Videos'),
						'popular_items' 	  => __pe('Popular Videos'),		
						'all_items' 		  => __pe('All Videos'),
						'parent_item' 	  => __pe('Parent Video'),
						'parent_item_colon' => __pe('Parent Video:'),
						'edit_item' 		  => __pe('Edit Video'), 
						'update_item' 	  => __pe('Update Video'),
						'add_new_item' 	  => __pe('Add New Video'),
						'new_item_name' 	  => __pe('New Video Name')
						),
				  'public' => true,
				  'has_archive' => false,
				  "supports" => array("title","thumbnail"),
				  "taxonomies" => array("")
				  );
		
		PeGlobal::$config["post_types"]["video"] =& $cpt;
	}

	public function pe_theme_metabox_config_video() {
		$mbox = 
			array(
				  "type" =>"Video",
				  "title" =>__pe("Video Options"),
				  "where" => 
				  array(
						"video" => "all",
						),
				  "content"=>
				  array(
						"type" => 
						array(
							  "label"=>__pe("Type"),
							  "type"=>"select",	
							  "options" =>
							  array(
									__pe("Youtube")=>"youtube",
									__pe("Vimeo")=>"vimeo"
									),
							  "default"=>"youtube"
							  ),
						"url" => 
						array(
							  "label"=>__pe("Url"),
							  "type"=>"Text",				  
							  "description" => __pe("Insert here the youtube/vimeo video url."),
							  "default"=>""
							  ),
						"fullscreen" =>  
						array(
							  "label"=>__pe("Play fullscreen"),
							  "type"=>"RadioUI",
							  "description" => __pe("Specify if video should play in a fullscreen lightbox window."),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"no"
							  ),
						"width" => 
						array(
							  "label"=>__pe("Max Width"),
							  "type"=>"Text",				  
							  "description" => __pe("Max width of the video when played inside the lightbox, use 0 for fullscreen"),
							  "default"=>"0"
							  )
						)
				  );

		PeGlobal::$config["metaboxes-video"] = 
			array(
				  "video" => $mbox
				  );
	}


	public function option() {
		$posts = get_posts(
						   array(
								 "post_type"=>"video",
								 "posts_per_page"=>-1
								 )
						   );
		if (count($posts) > 0) {
			$options = array();
			foreach($posts as $post) {
				$options[$post->post_title] = $post->ID;
			}
		} else {
			$options = array(__pe("No videos defined")=>-1);
		}
		return $options;
	}


	public function &get($id) {
		$post = false;
		if (!isset($id) || $id == "" ) return $post;
		if (isset($this->cache[$id])) return $this->cache[$id];
		$post =& get_post($id);
		if (!$post || $post->post_type != "video") {
			$post = false;
			return $post;
		}
		$meta =& $this->master->meta->get($id,$post->post_type);
		$post->meta = $meta;
		switch ($meta->video->type) {
		case "vimeo":
			preg_match("/https?:\/\/(vimeo\.com|www\.vimeo\.com)\/([\w|\-]+)/i",$meta->video->url,$matches);
			break;
		case "youtube":
			preg_match("/https?:\/\/(www.youtube.com\/watch\?v=|youtube.com\/watch\?v=|youtu.be\/)([\w|\-]+)/i",$meta->video->url,$matches);
			break;
		default:
			$matches = false;
		} 
		if ($matches && isset($matches[2])) $meta->video->id = $matches[2];

		$poster = wp_get_attachment_url(get_post_thumbnail_id($id));

		$meta->video->cover = $meta->video->poster = $poster ? $poster : "";

		return $post;
	}

	public function exists($id) {
		return $this->get($id) !== false;		
	}

	public function getInfo($id) {
		$video = $this->get($id);
		return $video === false ? $video : $video->meta->video;		
	}

	public function inline($id) {
		$post = $this->get($id);
		if (!$post) return null;
		$video =& $post->meta->video;
		
		if ($video->fullscreen === "yes" ) {
			$template = '<a href="%s" data-target="flare" data-flare-videoformats="%s" data-poster="%s" data-flare-videoposter="%s" class="peVideo"></a>';
		} else {
			$template = '<a href="%s" data-formats="%s" data-poster="%s" class="peVideo"></a>';
		}

		return sprintf($template,
					   $video->url,
					   join(",",$video->formats),
					   $video->poster,
					   $video->poster
					   );
	}

	public function output($id = null) {
		if (!$id) {
			global $post;
			$id = $post->ID;
			
			// if not video, get video id from meta
			if ($post->post_type != "video") {
				$meta =& $this->master->meta->get($id,$post->post_type);
				$id = empty($meta->video->id) ? false : $meta->video->id;
			}
		}

		if ($id && ($conf = $this->getInfo($id))) {
			$this->master->template->data($conf);
			get_template_part("video",$conf->type);
		}

	}

	public function show($id) {
		$inline = $this->inline($id);
		if ($inline) {
			echo $inline;
		}
		
	}


}

?>
