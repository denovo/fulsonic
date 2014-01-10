<?php

class PeThemeShortcodeLightbox extends PeThemeShortcode {

	public function __construct($master) {
		parent::__construct($master);
		$this->trigger = "lightbox";
		$this->group = __pe("MEDIA");
		$this->name = __pe("Lightbox");
		$this->description = __pe("Lightbox");
		$this->fields = array(
							  "type" => 
							  array(
									"label"=>__pe("Media Type"),
									"type"=>"Select",
									"description" => __pe("Select the type of media to be displayed in the lightbox"),
									"options" =>
									array(
										  __pe("Image")=>"image",
										  __pe("Youtube")=>"youtube",
										  __pe("Vimeo")=>"vimeo",
										  __pe("Local video")=>"local",
										  __pe("Vid.ly")=>"vidly"
										  ),
									"default"=>"image"
									),
							  "poster" => PeGlobal::$const->video->fields->poster,
							  "image" => 
							  array(
									"label"=>__pe("Image"),
									"type"=>"Upload",
									"description" => __pe("This is the large image which will be opened inside the lightbox")
									),
							  "video" => PeGlobal::$const->video->fields->url,
							  "size" => 
							  array(
									"label"=>__pe("Video window"),
									"type"=>"Text",
									"description" => __pe("The size at which the video will be displayed. For best results these values should match the original file's resolution and/or aspect ratio."),
									"default"=>"720x405"
									),
							  "formats" => PeGlobal::$const->video->fields->formats,
							  "title" => 
							  array(
									"label"=>__pe("Title (Optional)"),
									"type"=>"Text",
									"description" => __pe("Title to be displayed in the lightbox"),
									"default"=>""
									),
							  "content" => 
							  array(
									"label"=>__pe("Description (Optional)"),
									"type"=>"TextArea",
									"description" => __pe("Text description to be displayed in the lightbox"),
									"default"=>""
									)
							  );
	}

	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.shortcode.lightbox.js",array(),"pe_theme_shortcode_lightbox");
		wp_enqueue_script("pe_theme_shortcode_lightbox");
	}

	protected function script() {
		$html = <<<EOT
<script type="text/javascript">
jQuery("#{$this->trigger}").peShortcodeLightbox({tag:"{$this->trigger}"});
</script>
EOT;
		echo $html;
	}

	public function render() {
		parent::render();
		$this->script();
	}

	public function output($atts,$content=null,$code="") {
		extract($atts,EXTR_PREFIX_ALL,"sc");
		
		if (!isset($sc_poster)) return "";
		if ($sc_type == "image") {
			if (isset($sc_image)) {
				$url = $sc_image;
			} else {
				return "";
			}
		} else {
			if (isset($sc_video)) {
				$url = $sc_video;
			} else {
				return "";
			}
		}

		$attr = "href=\"$url\"";

		$img = "<img src=\"$sc_poster\"/>";

		if ($sc_type == "local" && isset($sc_poster)) $attr .= " data-poster=\"$sc_poster\"";
		if (isset($sc_formats)) $attr .= " data-formats=\"$sc_formats\"";
		if (isset($sc_size)) $attr .= " data-size=\"$sc_size\"";
		if (isset($sc_title)) {
			$sc_title = esc_attr($sc_title);
			$attr .= " title=\"$sc_title\"";
		}
		if (isset($content)) {
			$content = esc_attr($this->parseContent($content));
			$attr .= " data-description=\"$content\"";
		}


		$html = "<a class=\"influx-over\" data-target=\"prettyphoto\" $attr>$img</a>";
		return $html;
	}


}

?>
