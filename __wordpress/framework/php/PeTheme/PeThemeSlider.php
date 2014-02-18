<?php

class PeThemeSlider {

	protected $master;

	public function __construct(&$master) {
		$this->master =& $master;
	}

	public function output($id = null) {
		if (!$id) {
			global $post;
			$id = $post->ID;
			$meta =& $this->master->content->meta();
			// get gallery id
			$id = empty($meta->gallery->id) ? false : $meta->gallery->id;
		} else {
			$post = get_post($id);
			$meta =& $this->master->meta->get($id,$post->post_type);
		}

		if (!$id) return;

		$loop =& $this->master->gallery->getSliderLoop($id);

		
		if ($loop) {
			if (!empty($meta->settings)) {
				$conf =& $meta->settings;
				/*
				$conf->plugin = isset($conf->lbType) && $conf->lbType ? $conf->lbType : "default";
				$conf->max = isset($conf->maxThumbs) ? intval($conf->maxThumbs) : 0;
				$conf->scale = isset($conf->lbScale) && $conf->lbScale ? $conf->lbScale : "fit";
				$conf->bw = isset($conf->bw) && $conf->bw === "yes" && $conf->plugin === "shutter" ? true : false;
				*/
			} else {
				$conf = new StdClass();
			}

			$this->master->template->data($id,$conf,$loop);
			//$this->master->get_template_part("slider",empty($conf->type) ? "" : $conf->type);
			$this->master->get_template_part("gallery","slider");
		}
	}

	public function caption($caption) {
		if ($html = do_shortcode(apply_filters("the_content",$caption))) {
			echo '<div class="peCaption">';
			echo $html; 
			echo '</div>';
		}
		
	}


}

?>
