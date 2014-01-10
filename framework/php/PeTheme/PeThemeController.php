<?php

class PeThemeController {

	protected $runtime;
	protected $defaultOptions;

	public function boot() {
		add_filter('pre_get_posts',array(&$this,"pre_get_posts_filter"));
		// add post__in sorting
		add_filter("posts_orderby",array(&$this,"posts_orderby_filter"), 10, 2 );

		PeGlobal::$config["content-width"] = 940;
		PeGlobal::$config["post-formats"] = array("image","video");
		PeGlobal::$config["nav-menus"]["main"] = __pe("Main menu");	

		PeGlobal::$config["shortcodes"] = 
			array(
				  "Clearfix",
				  "Testimonial",
				  "Button",
				  "Lightbox",
				  "Video",
				  "Download",
				  "Link",
				  "Warning",
				  "Info",
				  "Properties",
				  "Columns",
				  "Line"
				  );

		PeGlobal::$config["sliders"] = 
			apply_filters(
						  "pe_theme_available_sliders",
						  array(
								__pe("Pixelentity (slide, touchenabled)") => "peVolo"
								)
						  );

		$brandingSection = isset($_GET["branding"]) ? __pe("Branding") : "hidden";
		
		$options = array(
						 "import_demo" => 
						 array(
							   "label"=>__pe("Import Demo Content"),
							   "type"=>"ImportDemo",
							   "section"=>__pe("General"),
							   "description" => __pe("Will import all demo data, including menus, sidebars, widgets and configuration"),
							   "default"=>"default"
							   ),						 
						 "customCSS" =>
						 array(
							   "label"=>__pe("Custom CSS"),
							   "type"=>"TextArea",
							   "section"=>__pe("General"),
							   "description" => __pe("Here you can enter custom CSS selectors to add to or overwrite the theme's default CSS styles. See the help documentation for some code snippets which can be pasted here"),
							   "default"=>""
							   ),
						 "customJS" =>
						 array(
							   "label"=>__pe("Custom JS"),
							   "type"=>"TextArea",
							   "section"=>__pe("General"),
							   "description" => __pe("Here you can enter custom javascript code and it will be added to the theme's existing javascript code"),
							   "default"=>""
							   ),
						 "adminLogo" => 
						 array(
							   "label"=>__pe("Custom Admin Panel Logo"),
							   "type"=>"Upload",
							   "section"=>$brandingSection,
							   "description" => __pe("Enter the url of the logo you would like to be displayed in this theme's custom options panel. The image should be aprox. 170x50px .png file. This field is hidden to prevent further rebranding. See the help docs for more info."),
							   "default"=> PE_THEME_URL."/framework/images/framework_logo.png"
							   ),
						 "adminUrl" =>
						 array(
							   "label"=>__pe("Custom Admin Panel Url"),
							   "type"=>"Text",
							   "section"=>$brandingSection,
							   "description" => __pe("This is the link which will be added to the theme options panel's custom logo. This field is also hidden"),
							   "default"=>"http://pixelentity.com"
							   ),
						 "lazyImages" =>				
						 array(
							   "label"=>__pe("Lazy Loading"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", enables Lazy Loading. All image assets are loaded upon page load, with Lazy Loading enabled, images are only loaded once they are needed. Page loads faster and rendering requires less cpu , which is especially useful in mobile and tablet devices.'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"no"
							   ),
						 "minifyJS" =>				
						 array(
							   "label"=>__pe("Enable Javascript Compression"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", a single compressed javascript file will be loaded instead of multiple ones: site will load faster but any customization you made to theme javascript sources will be ignored'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"no"
							   ),
						 "minifyCSS" =>				
						 array(
							   "label"=>__pe("Enable CSS Compression"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", a single compressed css file will be loaded instead of multiple ones: site will load faster but any customization you made to style.css or other theme stylesheet will be ignored'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"no"
							   ),
						 "adminThumbs" =>				
						 array(
							   "label"=>__pe("Show Thumbnails"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", shows thumbnails (featured images) in admin post list view.'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"yes"
							   ),
						 "mediaQuick" =>				
						 array(
							   "label"=>__pe("Enable Quick Browse Mode"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES", a new tab will appear in the default WordPress media uploader. This tab, named "Quick Browse" will display a filterable thumbnail grid of all uploaded media content. Media may be selected from this grid and added to galleries, posts and pages. When disabled, some functions related Galleries managment won\'t be available.'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"yes"
							   ),
						 "mediaQuickDefault" =>				
						 array(
							   "label"=>__pe("Make Quick Browse the Default Tab"),
							   "type"=>"RadioUI",
							   "section" => __pe("Advanced"),
							   "description"=>__pe('If set to "YES" the default WordPress Media Loader\'s dialog  will display this "Quick Browse" mode as its default tab.'),
							   "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
							   "default"=>"no"
							   ),
						 "contactEmail" =>				
						 array(
							   "label"=>__pe("Email Address"),
							   "type"=>"Text",
							   "section" => __pe("Contact Form"),
							   "description"=>__pe('Enter the email address where the contact form emails will be sent. If this field is left blank, the Admin email address will be used. The Admin email address is that entered in General Settings > Email Address.'),
							   "default"=>""
							   ),
						 "contactSubject" =>				
						 array(
							   "label"=>__pe("Subject Line"),
							   "type"=>"Text",
							   "section" => __pe("Contact Form"),
							   "description"=>__pe('Enter a custom subject line which will appear on all email sent from the contact form. This is useful when setting up email filters.'),
							   "default"=>"Contact Form Message",
							   "wpml" => true
							   ),
						 "updateCheck" => 
						 array(
							   "label"=>__pe("Check for Theme Updates"),
							   "type"=>"RadioUI",
							   "section"=>__pe("Auto Update"),
							   "description" => __pe("Specify if theme should automatically check for updates."),
							   "options" => 
							   array(
									 __pe("Yes") => "yes",
									 __pe("No") => "0",
									 ),
							   "default"=>"0"
							   ),
						 "updateUsername" => 
						 array(
							   "label"=>__pe("Envato Username"),
							   "type"=>"EnvatoUsername",
							   "section"=>__pe("Auto Update"),
							   "description" => __pe("Insert your Envato Username (account used to purchase this theme)."),
							   "default"=>""
							   ),
						 "updateAPIKey" => 
						 array(
							   "label"=>__pe("API Key"),
							   "type"=>"EnvatoAPI",
							   "section"=>__pe("Auto Update"),
							   "description" => __pe("Insert your API Key %swhich can be obtained here%s. (Generate one if none available)"),
							   "default"=>""
							   )

						 );

		if ($this->is_ngg_active()) {
			$options["nggCustom"] = 
				array(
					  "label"=>__pe("Enable NextGen Plugin Integration"),
					  "type"=>"RadioUI",
					  "section"=>__pe("NextGen"),
					  "description" => __pe("If you have installed the NextGEN Gallery plugin, this option will enable it to be auto configured. See help docs for more info."),
					  "options" => Array(__pe("Yes")=>"yes",__pe("No")=>"no"),
					  "default"=>"yes"
					  );
				
			$options["nggColumns"] = 
				array(
					  "label"=>__pe("Gallery columns"),
					  "type"=>"RadioUI",
					  "section"=>__pe("NextGen"),
					  "description" => __pe("Select the number of columns to be shown in the NextGen galleries"),
					  "single" => true,
					  "options" => range(1,3),
					  "default"=>3
					  );
		}

		$this->defaultOptions =& $options;
		PeGlobal::$config["options"] = $this->defaultOptions;

		// no common metaboxes
		PeGlobal::$config["metaboxes"] = array();

		// custom post types
		do_action("pe_theme_custom_post_type");

	}

	public function posts_orderby_filter($s,$q) {
		global $wpdb;
		if (!empty($q->query['post__in']) && isset($q->query['orderby']) && $q->query['orderby'] == 'post__in' )
			$s = "find_in_set({$wpdb->posts}.ID, '" . implode( ',', $q->query['post__in'] ) . "')";

		return $s;
	}	

	

	// after_theme_setup hook
	public function after_setup_theme() {
		$tp = get_template_directory();

		load_theme_textdomain(PE_THEME_NAME,"$tp/languages");
	
		$locale = get_locale();
		$locale_file = "$tp/languages/$locale.php";
	
		if (is_readable($locale_file)) {
			require_once($locale_file);
		}
		
		if (isset(PeGlobal::$config["post-formats"])) {
			add_theme_support("post-formats",PeGlobal::$config["post-formats"]);
		}
		
		add_theme_support("post-thumbnails");
		add_theme_support("automatic-feed-links");
	}

	// init hook
    public function init() {

		// menus
		$nav_menu =& PeGlobal::$config["nav-menus"];
		if (isset($nav_menu) && count($nav_menu) > 0) {
			foreach ($nav_menu as $name => $description ) {
				register_nav_menu($name,$description);				
			}
		}

		$image_sizes =& PeGlobal::$config["image-sizes"];
		if (isset($image_sizes) && count($image_sizes) > 0) {
			foreach ($image_sizes as $name => $params ) {
				add_image_size($name,$params[0],$params[1],$params[2]);
			}
		}

		// taxonomies
		$taxonomies =& PeGlobal::$config["taxonomies"];
		if (isset($taxonomies) && count($taxonomies) > 0) {
			foreach ($taxonomies as $name=>$params) {
				register_taxonomy($name,$params[0],$params[1]);
			}
		}
		// custom post types
		$post_types =& PeGlobal::$config["post_types"];
		if (isset($post_types) && count($post_types) > 0) {
			foreach ($post_types as $name=>$params) {
				register_post_type($name,$params);
			}
		}

		// sidebars
		$this->sidebar->register();

		// shortcodes
		$this->shortcode->add();

		// instantiate content module
		$this->content->instantiate();

		if ($this->options->get("nggCustom") && $this->is_ngg_active()) {
			$this->ngg->instantiate();
		}

	}

	public function widgets_init() {
		// WPML plugin support
		if (defined('ICL_LANGUAGE_CODE')) {
			$this->wpml->instantiate();
		}

		$this->widget->add();
	}


	public function is_ngg_active() {
		return ($this->is_plugin_active("nextgen-gallery/nggallery.php"));
	}


	public function after_switch_theme($theme) {
		// update rewrite rules for custom post types
		flush_rewrite_rules();

		if (isset(PeGlobal::$config["image-sizes"]["thumbnail"])) {
			list($width,$height,$crop) = PeGlobal::$config["image-sizes"]["thumbnail"];
			update_option("thumbnail_size_w",$width);
			update_option("thumbnail_size_h",$height);
			update_option("thumbnail_crop",$crop);
		}

		if (isset(PeGlobal::$config["image-sizes"]["medium"])) {
			list($width,$height,$crop) = PeGlobal::$config["image-sizes"]["medium"];
			update_option("medium_size_w",$width);
			update_option("medium_size_h",$height);
		}

		if (isset(PeGlobal::$config["image-sizes"]["large"])) {
			list($width,$height,$crop) = PeGlobal::$config["image-sizes"]["large"];
			update_option("large_size_w",$width);
			update_option("large_size_h",$height);
		}

		wp_redirect(admin_url("themes.php?page=pe_theme_options"));

	}


	public function enqueueAssets() {
		$this->asset->enqueueAssets();
	}

	public function &__get($what) {
		$runtime =& $this->runtime[$what];
		
		if (!isset($runtime)) {
			$m = "init_$what";
			if (method_exists($this,$m)) {
				$runtime = $this->$m();
			} else {
				throw new Exception("Unknown theme object: $what");
			}
		} 
		return $runtime;
	}

	public function get_template_part($slug,$name = null) {
		$this->template->inside($slug);
		get_template_part($slug,$name);
		$this->template->outside();
	}


	public function getMetaboxConfig($type) {
		do_action("pe_theme_metabox_config_$type");

		$config =& PeGlobal::$config;
		$metaboxes = PeGlobal::$config["metaboxes"];

		if (@$custom =& apply_filters("pe_theme_metabox_$type",$config["metaboxes-$type"])) {
			$keys = array_keys($custom);
			foreach ($keys as $key) {
				$metaboxes[$key] = $custom[$key];
				$where =& $metaboxes[$key]["where"];
				list($orig,$values) = each($where);
				if ($orig != $type) {
					unset($where[$orig]);
					$where[$type] = $values;
				}
			}
		}
		return $metaboxes;

	}

	
	protected function init_header() {
		return new PeThemeHeader();
	}

	protected function init_footer() {
		return new PeThemeFooter($this);
	}

	protected function init_menu() {
		return new PeThemeMenu();
	}

	protected function init_category() {
		return new PeThemeCategory();
	}

	protected function init_sidebar() {
		return new PeThemeSidebar($this);
	}

	protected function init_content() {
		return new PeThemeContent($this);
	}

	protected function init_shortcode() {
		return new PeThemeSCManager($this);
	}

	protected function init_slide() {
		return new PeThemeSlide($this);
	}

	protected function init_widget() {
		return new PeThemeWGManager($this);
	}

	protected function init_asset() {
		return new PeThemeAsset($this);
	}

	protected function init_image() {
		return new PeThemeImage();
	}

	protected function init_utils() {
		return new PeThemeUtils();
	}

	protected function init_browser() {
		return new PeThemeBrowser();
	}

	protected function init_admin() {
		return new PeThemeAdmin($this);
	}

	protected function init_metabox() {
		return new PeThemeMBox($this);
	}

	protected function init_options() {
		return new PeThemeOptions($this);
	}

	protected function init_comments() {
		return new PeThemeComments($this);
	}

	protected function init_data() {
		return new PeThemeData($this);
	}

	protected function init_ngg() {
		return new PeThemeNgg($this);
	}

	protected function init_media() {
		return new PeThemeMedia($this);
	}

	protected function init_gallery() {
		return new PeThemeGallery($this);
	}

	protected function init_slider() {
		return new PeThemeSlider($this);
	}

	protected function init_ptable() {
		return new PeThemePricingTable($this);
	}

	protected function init_staff() {
		return new PeThemeStaff($this);
	}

	protected function init_testimonial() {
		return new PeThemeTestimonial($this);
	}

	protected function init_service() {
		return new PeThemeService($this);
	}

	protected function init_editor() {
		return new PeThemeEditor($this);
	}

	protected function init_video() {
		return new PeThemeVideo($this);
	}

	protected function init_project() {
		return new PeThemeProject($this);
	}

	protected function init_background() {
		return new PeThemeBackground($this);
	}

	protected function init_export() {
		return new PeThemeExport($this);
	}
	
	protected function init_template() {
		return new PeThemeTemplate($this);
	}

	protected function init_meta() {
		return new PeThemeMeta($this);
	}

	protected function init_font() {
		return new PeThemeFont($this);
	}

	protected function init_color() {
		return new PeThemeColor($this);
	}

	protected function init_wpml() {
		return new PeThemeWPML($this);
	}

	public function add_meta_boxes($page,$object) {
		return $this->metabox->add_meta_boxes($page,$object);
	}

	public function save_post($id,$post) {
		return $this->metabox->save_post($id,$post);
	}

	public function admin_menu() {
		return $this->admin->admin_menu();
	}

	public function admin_init() {
		return $this->admin->admin_init();
	}

	public function export_wp() {
		return $this->export->export_wp();
	}

	public function rss2_head() {
		return $this->export->rss2_head();
	}

	public function dbx_post_advanced() {
		return $this->shortcode->admin();
	}

	public function sidebar_admin_setup() {
		return $this->widget->admin();
	}
	
	public function is_plugin_active( $plugin ) {
        return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || $this->is_plugin_active_for_network( $plugin );
	}

	public function is_plugin_active_for_network( $plugin ) {
        if ( !is_multisite() )
			return false;

        $plugins = get_site_option( 'active_sitewide_plugins');
        if ( isset($plugins[$plugin]) )
			return true;

        return false;
	}

	public function pre_get_posts_filter($query) {
		if ($query->is_search) {
			$query->set('post_type',array('post'));
		}
		return $query;
	}

	public function contactForm() {
		$data = array_map('stripslashes_deep',$_POST["data"]);
		$success = false;

		if (count($data) > 0) {
			$from = $to = (@$this->options->contactEmail) ? $this->options->contactEmail : get_bloginfo("admin_email");
			$email_text = "";

			foreach($data as $key => $value){
				if ($value != "") {
					if ($key == "email") {
						$from = $value;
					}
					$email_text.="<br><b>".ucfirst(str_replace("_", " ",$key))."</b> - ".nl2br($value);
				}
			}
			$subject = (@$this->options->contactSubject) ? @$this->options->contactSubject : "Contact from ".get_bloginfo('name');
			$from = "<$from>";

			if (isset($data["author"])) {
				$from = $data["author"]." $from";
			} else {
				$from = "User $from";
			}

			$headers = "From: $from\n" . "MIME-Version: 1.0\n" . "Content-type: text/html; charset=utf-8\n";
			$success = wp_mail($to, $subject, $email_text, $headers);
		}

		$response = json_encode(array("success" => $success,"mail"=>$email_text));
		header( "Content-Type: application/json" );
		echo $response;
		die();
	}

	public function newsletter() {
		$data = array_map('stripslashes_deep',$_POST["data"]);
		$success = false;
		$to = false;

		if (count($data) > 0 || !$data["email"] || !$data["instance"]) {

			if ($data["instance"] === "options") {
				$to = $this->options->get("newsletter");
			} else {
				list($instance,$id) = explode("-","widget_".$data["instance"]);
				$options = get_option($instance);
				if ($options && $options[$id]) {
					$to=$options[$id]["subscribe"];
				}
			}

			if ($to) { 

				$from = "Subscriber <".$data["email"].">";
				$email_text = "subscribe";

				$subject = "Subscribe from ".get_bloginfo('name');
				$headers = "From: $from\n" . "MIME-Version: 1.0\n" . "Content-type: text/html; charset=utf-8\n";
				$success = wp_mail($to, $subject, $email_text, $headers);
			}
		}

		$response = json_encode(array("success" => $success,"mail"=>$email_text));
		header( "Content-Type: application/json" );
		echo $response;
		die();
	}

}

?>