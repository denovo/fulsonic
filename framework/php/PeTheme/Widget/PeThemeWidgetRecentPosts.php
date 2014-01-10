<?php

class PeThemeWidgetRecentPosts extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Recent posts");
		$this->description = __pe("The most recent posts on your site");
		$this->wclass = "pe_widget widget_recent_entries";

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Recent Posts"
									),
							  "link" => 
							  array(
									"label"=>__pe("Blog Link"),
									"type"=>"Text",
									"description" => __pe("Blog link text. If empty, no link will be shown."),
									"default"=>"Visit The Blog"
									),
							  "url" => 
							  array(
									"label"=>__pe("Blog Link Url"),
									"type"=>"Text",
									"description" => __pe("Blog url. If empty, theme will try to autodetect."),
									"default"=>""
									),
							  "count" => 
							  array(
									"label"=>__pe("Number Of Posts"),
									"type"=>"RadioUI",
									"description" => __pe("Select the number of recent posts to show in this widget."),
									"single" => true,
									"options" => range(1,10),
									"default"=>2
									),
							  "chars" => 
							  array(
									"label"=>__pe("Excerpt Length"),
									"type"=>"Text",
									"description" => __pe("Excerpt lenght in characters. This number is then rounded so as not to cut a word."),
									"default"=>130
									)
							 
							  );
		

		parent::__construct();
	}

	public function &getContent(&$instance) {
		$instance = $this->clean($instance);
		extract($instance);
		$title = isset($title) ? $title : "";
		$plaintitle = $title;
		if (isset($link)) {
			$url = isset($url) && $url ? $url : peTheme()->content->getBlogLink();
			$title .= sprintf('<a href="%s"><span class="label">%s</span></a>',$url,$link);
		}
		$html = $title ? "<h3>$title</h3>" : "";
		$count = intval($count);
		$count = $count > 0 ? $count : 2;

		$chars = empty($chars) ? 130 : intval($chars);
		$chars = $chars > 0 ? $chars : 130;

		$t =& peTheme();
		$content =& $t->content;
		

		if ($content->customLoop("post",$count)) {
			
			if (peTheme()->template->exists("widget","recentposts")) {
				$conf = (object) array(
									   "count" => $count,
									   "chars" => $chars,
									   "title" => $plaintitle,
									   "link" => $link,
									   "url" => $url,
									   );

				ob_start();
				$t->template->get_part($conf,"widget","recentposts");
				$html = ob_get_clean();
			} else {

				$counter = 0;
				while ($content->looping()) {
				
				
					$counter++;
				
					$class = $content->idx() === $content->last()  ? ' class="last"' : ""; 
					$html .= "<ul><li$class>";
					$thumb = $t->content->resizedImg(50,50);
					$link = get_permalink();
					if ($thumb) {
						$html .= "<a class=\"thumb insetHighlight\" href=\"$link\">$thumb</a>";
					}
					$html .= "<div>";
					$html .= "<a class=\"title\" href=\"$link\">".get_the_title()."</a>";
					$html .= "<p>".$t->utils->truncateString(get_the_excerpt(),$chars)."</p>";
					$html .= "</div>";
					$html .= "</li></ul>";
				}
			}
			$content->resetLoop();
		}
		return $html;
	}


}
?>
