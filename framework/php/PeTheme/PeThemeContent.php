<?php

class PeThemeContent {

	protected $master;
	protected $loops = array();
	protected $current = false;
	protected $blogLoop = false;
	protected $cols = 0;

	public function __construct(&$master) {
		$this->master = &$master;
		add_filter("pe_post_thumbnail",array(&$this,"post_thumbnail_filter"));	
		add_filter("wp_tag_cloud",array(&$this,"wp_tag_cloud_filter"));
		add_filter("widget_tag_cloud_args",array(&$this,"widget_tag_cloud_args_filter"));
		add_filter("previous_post_link",array(&$this,"strip_rel_filter"));
		add_filter("next_post_link",array(&$this,"strip_rel_filter"));
		add_filter("the_category",array(&$this,"strip_rel_filter"));
		add_filter("excerpt_more",array(&$this,"excerpt_more_filter"));
		add_filter("the_content_more_link",array(&$this,"the_content_more_link_filter"));
		add_filter("edit_post_link",array(&$this,"edit_post_link_filter"));	
	}

	public function instantiate() {
	}

	public function loop($name = "") {
		get_template_part("loop", $this->have_posts() ? "$name" : "empty");
	}

	public function have_posts() {
		if ($this->current) {
			//print_r($this->current);
			$res = $this->current->have_posts();
		} else {
			$res = have_posts();
		}
		return $res;
	}

	public function idx() {
		return $this->wpq->current_post;
	}

	public function last() {
		return $this->wpq->post_count-1;
	}


	public function the_post() {
		if ($this->current) {
			$res = $this->current->the_post();
			$GLOBALS["more"] = false;
		} else {
			$res = the_post();
		}
		return $res;
	}

	public function beginRow($markup) {
		$cols = $this->cols;
		$idx = $this->wpq->current_post;
		if ($cols > 0 && ($idx % $cols) == 0) {
			echo $markup;
		}
	}

	public function endRow($markup) {
		$cols = $this->cols;
		$idx = $this->wpq->current_post;
		$last = $this->wpq->post_count-1;
		if ($cols > 0 && (($idx == $last) || ($idx % $cols) == ($cols-1))) {
			echo $markup;
		}
	}


	public function looping($cols = 0) {
		if ($this->have_posts()) {
			$this->cols = $cols;
			$this->the_post();
			return true;
		}
		return false;
	}

	public function &wpq() {
		global $wp_query;
		return $wp_query;
	}

	public function &__get($what) {
		switch ($what) {
		case "wpq":
			if ($this->current) {
				return $this->current;
			}
			return $this->wpq();
		case "qv":
			return $this->wpq()->query_vars;
		case "page":
			$which = (is_front_page() && !is_home()) ? "page" : "paged";
			$page = isset($this->qv[$which]) ? intval($this->qv[$which]) : 0;
			return $page;
		}
	}

	public function title() {
		the_title();
	}

	public function titleAttribute() {
		the_title_attribute();
	}

	public function link() {
		the_permalink();
	}

	public function twitterShareLink() {
		$link = "http://twitter.com/home?status=";
		$link .= urlencode(get_the_title()." - ");
		$link .= get_permalink();
		echo esc_attr($link);
	}

	public function facebookShareLink() {
		$link = "http://www.facebook.com/sharer/sharer.php?u=";
		$link .= get_permalink();
		echo esc_attr($link);
	}

	public function filterClasses($tax,$id = null) {
		if (empty($tax)) return;
		if (empty($id)) {
			global $post;
			$id = $post->ID;
		}
		$classes = wp_get_post_terms($id,$tax,array("fields" => "slugs"));
		if (is_array($classes) && ($count = count($classes)) > 0) {
			while($count--) {
				$classes[$count] = "filter-".$classes[$count];
			}
			echo join(" ",$classes);
		}
	}

	public function thumb($useFilters = true) {
		global $post;
		if (has_post_thumbnail()) {
			$thumb = get_the_post_thumbnail($post->ID,"thumbnail");
			if ($useFilters && has_filter("pe_post_thumbnail")) {
				echo apply_filters("pe_post_thumbnail",$thumb);
			} else {
				echo $thumb;
			}
		}
	}

	public function post_thumbnail_filter($data) {
		return $data;
	}

	public function hasFeatImage() {
		global $post;
		return @has_post_thumbnail($post->ID);		
	}

	public function get_origImage($id = null) {
		return wp_get_attachment_url(get_post_thumbnail_id($id));
	}

	public function resizedImg($w,$h) {
		$url = wp_get_attachment_url(get_post_thumbnail_id());
		return $this->master->image->resizedImg($url,$w,$h);
	}

	public function img($w,$h = null) {
		$img = $this->resizedImg($w,$h);
		echo apply_filters("pe_theme_content_img",$img ? $img : "",$w,$h);
	}


	public function get_thumbImage($thumb) {
		if (@has_post_thumbnail()) {
			$thumb = wp_get_attachment_image_src(get_post_thumbnail_id(),$thumb);
			return $thumb[0];
		}
		return "";
	}

	public function origImage() {
		echo $this->get_origImage();
	}

	public function excerpt() {
		the_excerpt();
	}

	public function content($text = null) {
		the_content($text);
	}

	public function current($add = 0) {
		$page = $this->page;
		if ($page > 1) {
			$add += $this->qv["posts_per_page"]*($page-1);
		}
		echo $this->wpq->current_post + $add;
	}

	public function terms($tax,$sep = ",") {
		global $post;
		return join($sep,wp_get_post_terms($post->ID,$tax,array("fields" => "names")));
	}

	public function &getPostsQueryArgs($type,$count,$tax = null,$custom = null,$paged = false) {
		$args = array(
					  "post_type"=>"$type",
					  "posts_per_page"=>$count
					  );

		if ($tax) {
			$custom[$tax] = $this->terms($tax);
		}

		if (is_array($custom)) {
			$args = array_merge($args,$custom);
		}

		if ($paged) {
			$page = $this->page;
			$page = $page ? $page - 1 : 0;
			$args["offset"] = $count*$page;
		} else {
			// if pagination is not needed, avoid counting rows to boost performances
			$args['no_found_rows'] = true;
		}
		return $args;
	}

	public function getPostsLoop($type,$count,$tax = null,$custom = null,$paged = false) {

		$data = new StdClass();
		$args =& $this->getPostsQueryArgs($type,$count,$tax,$custom,$paged);

		$wpq =&  new WP_Query();
		$data->loop =& $wpq->query($args);

		$loop =& $this->master->data->create($data,true);

		if ($paged) {
			$loop->pages = $wpq->max_num_pages;
		}

		return $loop;
	}

	public function customLoop($type,$count = 10,$tax = null,$custom = null,$paged = false) {
		$args =& $this->getPostsQueryArgs($type,$count,$tax,$custom,$paged);
		if ($this->current) {
			$this->loops[] =& $this->current;
		}
		$this->master->data->postSave();
		$this->current =& new WP_Query($args);
		return $this->current->post_count > 0;
	}

	public function resetLoop() {
		$this->master->data->postReset();
		$this->current = (count($this->loops) >0) ? array_pop($this->loops) : false;
	}

	public function blog($settings,$showpager = true) {
		global $post;
		
		$exclude = false;

		// prevents nested blogs
		if ($this->blogLoop) return;
		$this->blogLoop = true;

		// prevents loops
		if (isset($post) && $post) {
			$exclude = $post->ID;
		}

		if (is_string($settings) && !empty($settings)) {
			$id = $settings;
			$post = get_post($id);
			if (!$post) return;
			$meta = $this->master->meta->get($id,$post->post_type);
			if (empty($meta->blog)) return true;
			$settings = $meta->blog;
		}

		$settings = (object) shortcode_atts(
											array(
												  "layout" => "",
												  "count" => get_option("posts_per_page"),
												  "media" => "yes",
												  "pager" => "yes",
												  "sticky" => "yes",
												  "category" => "",
												  "tag" => "",
												  "format" => ""
												  ),
											(array) $settings
											);

		// prevents loops
		if ($exclude) {
			$custom = array("post__not_in" => array($exclude));
		}

		$custom["ignore_sticky_posts"] = ($settings->sticky === "no") ? 1 : 0;

		if ($settings->category) {
			$custom["category_name"] = $settings->category;
		}

		if ($settings->tag) {
			$custom["tag"] = $settings->tag;
		}
		
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

		$media = $settings->media === "yes";

		$this->customLoop("post",$settings->count,null,$custom,$settings->pager === "yes");

		$this->master->template->get_part(compact("media"),"loop",$this->have_posts() ? $settings->layout : "empty");

		if ($showpager && $settings->pager === "yes") {
			$this->pager();
		}

		$this->resetLoop();
		$this->blogLoop = false;
		
	}

	public function getPagerLoop($max = 5,$pages = false) {
		$pages = $pages ? $pages : $this->wpq->max_num_pages;
		if ($pages <= 1) return false;
		for ($p = 0;$p<$pages;$p++) {
			$links[] = get_pagenum_link($p+1);
		}
		return $this->master->data->createPager($this->page,$links,$max);
	}

	public function pager($class = "span12",$pages = false) {
		$loop = $this->getPagerLoop(5,$pages);
		if ($loop) $loop->main->class = $class;
		$this->master->template->paginate_links($loop);
	}


	public function comments() {
		comments_number('0','1','%');
	}

	public function body_class($class = "") {
		echo 'class="' . apply_filters("pe_theme_body_class",join( ' ', get_body_class( $class ) )) . '"';
	}


	public function total() {
		echo $this->wpq->found_posts;
	}

	public function hasNextPage() {
		$max = $this->wpq->max_num_pages;
		return ($max > 1 && $this->page < $max);
	}

	public function hasPrevPage() {
		$max = $this->wpq->max_num_pages;
		return ($max > 1 && $this->page > 1);
	}


	public function tagCloud($number,$orderby="name") {
		wp_tag_cloud(array("number"=>$number,"orderby"=>$orderby,"order"=>$orderby == "count" ? "DESC" : "ASC")); 
	}

	public function tags($sep = ", ") {
		the_tags("",$sep,"");
	}

	public function category($prefix="") {
		if ($prefix) {
			echo "$prefix ";
		}
		the_category(", ");
	}

	public function date($prefix="") {
		if ($prefix) {
			echo "$prefix ";
		}
		the_time(get_option('date_format'));
	}

	public function author($prefix="") {
		if ($prefix) {
			echo "$prefix ";
		}
		the_author();
	}

	public function format() {
		global $post;
		return get_post_format($post->ID);
	}

	public function pageTemplate($post_id = null) {
		if (function_exists("get_page_template_slug")) return get_page_template_slug($post_id);
		$post = get_post( $post_id ); 
		if ( 'page' != $post->post_type ) 
			return false; 
		$template = get_post_meta( $post->ID, '_wp_page_template', true ); 
		if ( ! $template || 'default' == $template ) 
			return ''; 
	}

	public function slug() {
		global $post; 
		echo $post->post_name;
	}


	public function type() {
		global $post;
		return $post->post_type;
	}

	public function classes($add="") {
		$c = join(" ",get_post_class());
		$c = $add ? "$c $add" : "$c";
		printf('class="%s"',$c);
	}


	public function isVideo() {
		return get_post_format() === "video";
	}

	public function includeLoopPart($prefix="looped") {
		global $post;
		$type = $post->post_type;
		get_template_part("$prefix-$type",$this->format());
	}

	public function getBlogLink() {
		$pfp = get_option("page_for_posts"); 
		$pfp  = $pfp ? get_page_link($pfp) : "";

		return get_option('show_on_front') == 'page' ? $pfp : home_url();
	}

	public function wp_tag_cloud_filter($data) {
		if (is_tag()) {
			global $wp_query;
			$currentTagID = $wp_query->get_queried_object()->term_id;
			$data = str_replace("tag-link-$currentTagID","tag-link-$currentTagID current-tag",$data);
		}
		return preg_replace('/style=.[^"|\']+./i','',$data);
	}

	public function widget_tag_cloud_args_filter($args) {
		$options =& $this->master->options;
		$orderby = $options->get("tagCloudOrder");
		$args = array_merge($args,array("number"=>$options->get("tagCloudCount"),"orderby"=>$orderby,"order"=>$orderby == "count" ? "DESC" : "ASC"));
		return $args;
	}

	public function &meta($postID = FALSE) {
		global $post;
		//print_r($post);
		return $this->master->meta->get($postID ? $postID : ($post ? $post->ID : NULL),$post ? $post->post_type : "post");
	}

	public function strip_rel_filter($content) {
		return preg_replace('/rel="/','data-rel="',$content);
	}

	public function excerpt_more_filter($more) {
		return "";
	}

	public function the_content_more_link_filter($link) {
		$link = sprintf('&nbsp;<a href="%s#more-%s" class="label label-default">%s</a>',get_permalink(),$GLOBALS["post"]->ID,__pe("more"));
		return $link;
	}

	public function edit_post_link_filter($link) {
		return str_replace("post-edit-link","label",$link);
	}

	
	public function getSocialLinks($links) {
		if (is_array($links)) {
			$html = "";
			foreach ($links as $link) {
				$domain = strtr($link,array("http://"=>"","https://"=>"","www."=>""));
				$domain = explode(".",$domain);
				$domain = $domain[0];
				$icon = strtr($domain,array("linkedin"=>"linked_in","plus"=>"google_plus","feeds" => "rss"));
				$icon = preg_replace("/:.*/","",$icon);
				$html .= apply_filters("pe_theme_content_get_social_link",sprintf('<a href="%s" data-rel="tooltip" title="%s" class="sm-icon sm-icon-%s"></a>',$link,$domain,$icon),$link,$domain,$icon);
			}
			return $html;
		}
	    return false;
	}

	public function socialLinks($links,$section = "") {
		$html = apply_filters("pe_theme_social_links",$this->getSocialLinks($links),$section);
		echo $html ? $html : "";
	}

	public function getPagesByTemplate($template) {

		$args = array();

		if ($template) {
			$args = 
				array(
					  'meta_key' => '_wp_page_template',
					  'meta_value' => "page-$template.php"
					  );				
		} 

		$pages = get_pages($args);
		return $pages;
	}

	public function getPagesLinkByTemplate($template) {
		$pages = $this->getPagesByTemplate($template);
		if (!is_array($pages)) return false;
		$links = false;
		foreach ($pages as $page) {
			$links[] = get_page_link($page->ID);
		}
		return $links;
	}

	public function getPagesOptionsByTemplate($template) {
		$pages = $this->getPagesByTemplate($template);
		if (!is_array($pages)) return false;
		$links = false;
		foreach ($pages as $page) {
			$links[$page->post_title] = $page->ID;
		}
		return $links;
	}

	public function getPageLinkByTemplate($template) {
		$pages = $this->getPagesLinkByTemplate($template);
		return $pages ? $pages[0] : "";
	}


	public function adjPostLink($previous = false) {
		$post = get_adjacent_post(false,"", $previous);
		return $post ? get_permalink($post) : "";	
	}

	public function prevPostLink() {
		return $this->adjPostLink(true);
	}

	public function nextPostLink() {
		return $this->adjPostLink(false);
	}

	public function linkPages() {
		wp_link_pages();
	}


}

?>