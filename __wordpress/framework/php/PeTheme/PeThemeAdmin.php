<?php

class PeThemeAdmin {

	protected $master;
	protected $options;
	protected $form;
	protected $screen;

	public function __construct(&$master) {
		$this->master =& $master;
		$this->options =& $this->master->options->all();
		add_action("current_screen",array(&$this,"current_screen"));
	}

	public function admin_menu() {
		$options_page = add_theme_page(
							   __pe('Theme Options'),   
							   __pe('Theme Options'),
							   'edit_theme_options',
							   'pe_theme_options',
							   array(&$this,"theme_options")
							   );

		$this->registerAssets();
		wp_enqueue_style("pe_theme_admin_icons");


        if ($options_page) {
			add_action("load-$options_page",array(&$this,"page"));
		}

		if ($this->options->updateCheck == "yes" && ($username = $this->master->options->updateUsername) && ($key = $this->master->options->updateAPIKey) ) {
			require_once(PE_FRAMEWORK."/php/lib/pixelentity-theme-update/class-pixelentity-theme-update.php");
			PixelentityThemeUpdate::init($username,$key,apply_filters("pe_theme_author","Pixelentity"));
		}
		
	}

	public function update_check($data) {
		return $this->master->update->update_check($data);
	}


	public function theme_update() {
		$this->master->update->theme_update();
	}


	public function add_non_menu_page($slug,$callback) {
		global $_registered_pages;
		$hookname = get_plugin_page_hookname($slug, '');
		if (!empty($hookname)) {
			add_action($hookname, $callback);
		}
		$_registered_pages[$hookname] = true;
		return $hookname;
	}

	public function admin_init() {
		add_action('wp_ajax_pe_theme_options_save', array(&$this, 'options_save'));
		add_action('wp_ajax_pe_theme_import_demo', array(&$this, 'import_demo'));
		add_action('wp_ajax_pe_theme_import_progress', array(&$this, 'import_progress'));
		add_action('wp_ajax_pe_theme_image_resize',array(&$this,'ajax_image_resize'));		
		add_editor_style(apply_filters("pe_theme_editor_style","framework/css/editor.css"));

		if ($this->options->adminThumbs === "yes") {
			// extra thumbs columns
			add_filter("manage_edit-post_columns",array(&$this,"manage_edit_post_columns_filter"));
			add_filter("manage_edit-gallery_columns",array(&$this,"manage_edit_post_columns_filter"));
			add_filter("manage_edit-project_columns",array(&$this,"manage_edit_post_columns_filter"));
			add_filter("manage_edit-video_columns",array(&$this,"manage_edit_post_columns_filter"));
		}

		// project extra columns
		add_filter("manage_edit-project_columns",array(&$this,"manage_edit_project_columns_filter"));
		add_action("manage_posts_custom_column", array(&$this,"manage_posts_custom_column"),10,2);

		// WPML strings
		add_action("load-wpml-string-translation/menu/string-translation.php",array(&$this,"wpml_register_strings"));

		// add gallery managment
		$this->master->gallery->instantiate();

		if (isset(PeGlobal::$config["additional-media-thumbs"])) {
			add_filter("image_size_names_choose",array(&$this,"image_sizes_names_choose"));
		}

	}

	public function wpml_register_strings() {
		$this->master->wpml->register_strings();
	}

	public function ajax_image_resize() {
		$img = $_REQUEST["img"];
		$w = $_REQUEST["w"];
		$h = $_REQUEST["h"];
		if (!empty($_REQUEST["isID"])) {
			$img = wp_get_attachment_url($img);
		}

		header("Content-Type: application/json");
		echo json_encode(array("resized" => $this->master->image->resize($img,$w,$h)));

		die();
	}

	public function listTags($id,$tax,$custom,$page) {

		$tags = wp_get_post_terms($id,$tax);
		if ( !empty( $tags ) ) {
			$out = array();
			foreach ( $tags as $c ) {
				$out[] = sprintf( '<a href="%s">%s</a>',
								  esc_url(add_query_arg(array($tax => $c->name,"post_type"=>$custom),$page)),
								  esc_html(sanitize_term_field( 'name', $c->name, $c->term_id, 'tag', 'display' ) )
								  );
			}
			echo join( ', ', $out );
		} else {
			echo __pe("No Tags");
		}
	}

	public function manage_edit_post_columns_filter($cols) {
		$cb = $cols["cb"];
		unset($cols["cb"]);
		$cols = array_merge(
							array(
								  "cb" => $cb,
								  "icon" => ""
								  ),
							$cols
							);
		return $cols;
	}

	public function manage_edit_project_columns_filter($cols) {
		$date = $cols["date"];
		unset($cols["date"]);
		$cols["pe_project_tags"] = __pe("Tags");
		$cols["date"] = $date;
		return $cols;
	}

	public function manage_posts_custom_column($column_name,$id) {
		switch ($column_name) {
		case "icon":
			echo get_the_post_thumbnail($id,array(80,80));
			break;
		case "pe_project_tags":
			$this->listTags($id,"prj-category","project","edit.php");
			break;
		}
	}
	
	public function image_sizes_names_choose($image_sizes) {
		return array_merge($image_sizes,PeGlobal::$config["additional-media-thumbs"]);
	}

	public function page() {
		wp_enqueue_script("pe_theme_admin");
		do_action("pe_theme_admin_options");
		
		$this->form =& new PeThemeAdminForm($this,"pe_theme_options",PeGlobal::$config["options"],$this->options);
		$this->form->build();
	}

	public function registerAssets() {
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.utils.js",array(),"pe_theme_utils");
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.admin.js",array('jquery','jquery-ui-core','jquery-ui-tabs', 'jquery-ui-sortable','pe_theme_utils'),"pe_theme_admin");
		PeThemeAsset::addStyle("framework/css/ui/jquery-ui-1.8.17.custom.css",NULL,"pe_theme_admin_ui");
		PeThemeAsset::addStyle("framework/css/customadminicons.css",array(),"pe_theme_admin_icons");
		PeThemeAsset::addStyle("framework/css/admin.css",array("pe_theme_admin_ui","pe_theme_admin_icons"),"pe_theme_admin");
	
	}
	
	public function options_save() {
		if (!$_POST || !wp_verify_nonce($_POST['pe_theme_form_nonce'],PE_THEME_NAME."_form")) {
			$result = json_encode( array("options" => Array(),"ok"=>false));
		} else {

			// this is needed to convert window-style line feeds to unix format, without doing so
			// all serialized values will breaks once exported into xml file
			array_walk_recursive($_POST["pe_theme_options"],array("PeThemeUtils","dos2unix"));

			$options = array_map('stripslashes_deep',$_POST["pe_theme_options"]);
			$this->master->options->save($options);
			$this->options =& $options;
			$result = json_encode( array("options" => $options,"ok"=>true));
		}
		header("Content-Type: application/json");
		echo $result;
		die();
	}

	// sets post formats according to custom post type
	public function current_screen($screen) {
		if (!$screen) return;
		if (!@$screen->post_type) return;
		$config =& PeGlobal::$config;
		if (isset($config["post-formats-".$screen->post_type]) ) {
			add_theme_support("post-formats",$config["post-formats-".$screen->post_type]);
		}
	}
	
	public function theme_options() {
		echo '<div class="wrap"><div id="icon-themes" class="icon32"><br /></div><h2>'.__pe("Theme Options").'</h2>';
		$this->form->render();
		echo "</div>";
		do_action("pe_theme_admin_options_render");
	}

	public function import_demo() {
		if (!$_POST || !@$_POST['nonce'] || !wp_verify_nonce($_POST['nonce'],"pe_theme_import_demo")) {
			$result = json_encode(array("ok"=>false,"message" => __pe("You don't have sufficient permissions")));
		} else {
			$result = $this->master->export->importDemo();
			$result = json_encode(array("ok"=>$result));
		}
		header("Content-Type: application/json");
		echo $result;
		die();
	}

	public function import_progress() {
		$progress = $this->master->export->progress();
		$result = json_encode($progress);
		header("Content-Type: application/json");
		echo $result;
		die();
	}

}

?>
