<?php

class PeThemeHalfcreativeAsset extends PeThemeAsset  {

	public function __construct(&$master) {
		$this->minifiedJS = "theme/compressed/theme.min.js";
		$this->minifiedCSS = "theme/compressed/theme.min.css";
		parent::__construct($master);
	}

	public function registerAssets() {

		add_filter("pe_theme_minified_js_deps",array(&$this,"pe_theme_minified_js_deps_filter"));
		add_filter("pe_theme_video_js_deps",array(&$this,"pe_theme_video_js_deps_filter"));
		add_filter("pe_theme_flare_css_deps",array(&$this,"pe_theme_flare_css_deps_filter"));

		parent::registerAssets();

		$options =& $this->master->options->all();		

		// override projekktor skin
		wp_deregister_style("pe_theme_projekktor");
		$this->addStyle("framework/js/pe.flare/video/theme/style.css",array(),"pe_theme_projekktor");

		//$this->addStyle("css/dark_skin.css",array(),"pe_theme_hydra_dark_skin");		

		if ($this->minifyCSS) {
			$deps = 
				array(
					  "pe_theme_compressed"
					  );
		} else {

			// theme styles
			$this->addStyle("styles/reset.css",array(),"pe_theme_halfcreative_reset");
			$this->addStyle("styles/slider_captions.css",array(),"pe_theme_halfcreative_slider_captions");
			$this->addStyle("styles/slider_captions_style.css",array(),"pe_theme_halfcreative_slider_captions_style");
			$this->addStyle("styles/slider_ui.css",array(),"pe_theme_halfcreative_slider_ui");
			$this->addStyle("styles/entypo-icon-font.css",array(),"pe_theme_halfcreative_entypo");
			$this->addStyle("styles/socialico-icon-font.css",array(),"pe_theme_halfcreative_socialico");
			$this->addStyle("styles/main.css",array(),"pe_theme_halfcreative_style");
			$this->addStyle("styles/media.css",array(),"pe_theme_halfcreative_style-responsive");
			$this->addStyle("styles/custom.css",array(),"pe_theme_halfcreative_style-custom");
		
			$deps = 
				array(
					  "pe_theme_halfcreative_reset",
					  "pe_theme_video",					  
					  "pe_theme_volo",
					  "pe_theme_halfcreative_slider_ui",
					  "pe_theme_halfcreative_slider_captions",
					  "pe_theme_halfcreative_slider_captions_style",
					  "pe_theme_halfcreative_entypo",
					  "pe_theme_halfcreative_socialico",
					  "pe_theme_halfcreative_style",
					  "pe_theme_halfcreative_style-responsive",
					  "pe_theme_halfcreative_style-custom"
					  );
		}

		/*
		if ($options->skin == "dark") {
			$deps[] = "pe_theme_halfcreative_dark_skin";
		}
		*/

		$this->addStyle("style.css",$deps,"pe_theme_init");

		$this->addScript("js/modernizr.custom.js",array(),"pe_theme_halfcreative_modernizr");
		$this->addScript("js/waypoints.js",array(),"pe_theme_halfcreative_waypoints");
		$this->addScript("js/waypoints-sticky.js",array(),"pe_theme_halfcreative_waypoints-sticky");
		$this->addScript("js/scripts.js",array(),"pe_theme_halfcreative_scripts");
		$this->addScript("js/grid.js",array(),"pe_theme_halfcreative_grid");

		$this->addScript("theme/js/pe/pixelentity.controller.js",
						 array(
							   "pe_theme_halfcreative_modernizr",
							   "pe_theme_halfcreative_waypoints",
							   "pe_theme_halfcreative_waypoints-sticky",
							   "pe_theme_halfcreative_scripts",
							   "pe_theme_halfcreative_grid",
							   "pe_theme_videoPlayer",
							   "pe_theme_utils",
							   "pe_theme_utils_geom",
							   "pe_theme_utils_browser",
							   "pe_theme_utils_preloader",
							   "pe_theme_lazyload",
							   "pe_theme_widgets_contact",
							   "pe_theme_widgets_volo"

							   ),"pe_theme_controller");

		/*
		wp_localize_script("pe_theme_init", 'peThemeOptions',
						   array(
								 "backgroundMinWidth" => absint($options->backgroundMinWidth)
								 ));
		*/

	}
	
	public function pe_theme_minified_js_deps_filter($deps) {
		return array("jquery");
	}

	public function pe_theme_video_js_deps_filter($deps) {
		return array(
					 "pe_theme_utils_youtube",
					 "pe_theme_utils_vimeo",
					 );
	}

	public function pe_theme_flare_css_deps_filter($deps) {
		return 	array(
					  "pe_theme_flare_common"
					  );
	}
	

	public function style() {
		bloginfo("stylesheet_url"); 
	}

	public function enqueueAssets() {
		$this->registerAssets();
		
		if ($this->minifyJS && file_exists(PE_THEME_PATH."/preview/init.js")) {
			$this->addScript("preview/init.js",array("jquery"),"pe_theme_preview_init");
			wp_localize_script("pe_theme_preview_init", 'o',
							   array(
									 "dark" => PE_THEME_URL."/css/dark_skin.css",
									 "css" => $this->master->color->customCSS(true,"color1")
									 ));
			wp_enqueue_script("pe_theme_preview_init");
		}	
		
		wp_enqueue_style("pe_theme_init");
		wp_enqueue_script("pe_theme_init");

		if ($this->minifyJS && file_exists(PE_THEME_PATH."/preview/preview.js")) {
			$this->addScript("preview/preview.js",array("pe_theme_init"),"pe_theme_skin_chooser");
			wp_localize_script("pe_theme_skin_chooser","pe_skin_chooser",array("url"=>urlencode(PE_THEME_URL."/")));
			wp_enqueue_script("pe_theme_skin_chooser");
		}
	}


}

?>