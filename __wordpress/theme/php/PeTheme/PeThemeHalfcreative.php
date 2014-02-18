<?php

class PeThemeHalfcreative extends PeThemeController {

	public $preview = array();

	public function __construct() {
		// custom post types
		add_action("pe_theme_custom_post_type",array(&$this,"pe_theme_custom_post_type"));

		// google fonts
		add_filter("pe_theme_font_variants",array(&$this,"pe_theme_font_variants_filter"),10,2);

		// menu
		add_filter("pe_theme_menu_items_wrap_default",array(&$this,"pe_theme_menu_items_wrap_default_filter"));
		add_filter("wp_nav_menu_objects",array(&$this,"wp_nav_menu_objects_filter"),10,2);
		
		// social links
		add_filter("pe_theme_content_get_social_link",array(&$this,"pe_theme_content_get_social_link_filter"),10,4);

		// use prio 30 so gets executed after standard theme filter
		add_filter("the_content_more_link",array(&$this,"the_content_more_link_filter"),30);

		// gallery fields
		add_filter("pe_theme_gallery_image_fields",array(&$this,"pe_theme_gallery_image_fields_filter"));

		// metaboxes
		add_filter("pe_theme_metabox_gallery",array(&$this,"pe_theme_metabox_gallery_filter"));
		add_filter("pe_theme_metabox_video",array(&$this,"pe_theme_metabox_video_filter"));
		add_filter("pe_theme_metabox_page",array(&$this,"pe_theme_metabox_page_filter"));

		// shortcodes default values
		add_filter("pe_theme_shortcode_gallery_defaults",array(&$this,"pe_theme_shortcode_gallery_defaults_filter"),10,2);

		// custom password form
		add_filter("the_password_form",array(&$this,"the_password_form_filter"));
		
	}

	public function the_password_form_filter($form) {

		$replace = sprintf('<div class="control-group"><input name="post_password" type="password" /></div><button id="submit" class="btn btn-info" type="submit" name="submit">%s</button>',__pe("Submit"));
		$form = preg_replace("/<p>.+<\/p>/","",$form);
		$form = str_replace("</form>","$replace</form>",$form);
		return $form;
	}


	public function pe_theme_resized_img_filter($markup,$url,$w,$h) {

		return sprintf('<img class="peLazyLoading" src="%s" data-original="%s" width="%s" height="%s" alt="" />',
					   $this->image->blank($w,$h),
					   $url,
					   $w,
					   $h
					   );
	}


	public function pe_theme_font_variants_filter($variants,$font) {
		$variants="$font:300,400,600";
		/*
		if ($font === "Open Sans") {
			//$variants = "Open Sans:400,600,300&subset=latin,latin-ext";
			$variants = "Open Sans:400,600,300";
		}
		*/
		return $variants;
	}

	public function pe_theme_menu_items_wrap_default_filter($wrapper) {
		return '<ul id="nav" data-mobile="'.__pe('Go To').'">%3$s</ul>';
	}

	public function wp_nav_menu_objects_filter($items,$args) {
		if (is_array($items) && !empty($args->theme_location)) {
			$home = false;

			if (is_page()) {
				if ($this->content->pageTemplate() === "page-home.php") {
					$home = get_page_link(get_the_id());
				}
			}

			foreach ($items as $id => $item) {
				if (!empty($item->post_parent)) {
					if ($item->object === "page") {
						$page = get_page($item->object_id);
						if (!empty($page->post_name)) {
							$parent = get_page_link($item->post_parent);
							$slug = $page->post_name;
							$items[$id]->url = "{$parent}#{$slug}";
						}
					}
				} else if ($item->url === $home) {
					$items[$id]->url .= "#home";
				}
			}
		}
		return $items;
	}


	public function pe_theme_content_get_social_link_filter($html,$link,$domain,$icon) {
		return sprintf('<a href="%s"><i class="icon-%s-circled"></i></a>',$link,strtr($icon,array("linked_in"=>"linkedin")));
	}

	public function the_content_more_link_filter($link) {
		return sprintf('<div><a class="more-link" href="%s">%s</a></div>',get_permalink(),__pe("Continue Reading.."));
	}

	public function pe_theme_gallery_image_fields_filter($fields) {
		$save = $fields["save"];
		unset($fields["save"]);
		unset($fields["video"]);
		//unset($fields["ititle"]);
		$fields["link"] = 
			array(
				  "label"=>__pe("Link"),
				  "type"=>"Text",
				  "section"=>"main",
				  "description" => __pe("Optional image link."),
				  "default"=> ""
				  );
		$fields["save"] = $save;
		return $fields;
	}

	public function pe_theme_metabox_gallery_filter($mboxes) {
		$type =& $mboxes["settings"]["content"]["type"];
		$type["options"] = array(__pe("Slider") => "slider");
		$type["default"] = "slider";

		return $mboxes;
	}

	public function pe_theme_metabox_video_filter($mboxes) {
		$video =& $mboxes["video"]["content"];
		unset($video["fullscreen"]);
		unset($video["width"]);
		return $mboxes;
	}

	public function pe_theme_metabox_page_filter($mboxes) {
		$blog =& $mboxes["blog"]["content"];
		unset($blog["layout"]);
		unset($blog["media"]);
		return $mboxes;
	}

	public function pe_theme_shortcode_gallery_defaults_filter($defaults,$atts) {
		extract(shortcode_atts(array("id" => false),$atts));

		switch ($this->gallery->type($id)) {
		case "slider":
			$defaults["size"] = "592x333";
			break;
		}

		return $defaults;
	}


	public function init() {
		parent::init();

		if ($this->options->get("lazyImages") === "yes") {
			add_filter("pe_theme_resized_img",array(&$this,"pe_theme_resized_img_filter"),10,4);
		}
	}


	public function pe_theme_custom_post_type() {
		$this->gallery->cpt();
		$this->video->cpt();
		$this->project->cpt();
		$this->staff->cpt();
	}

	public function boot() {
		parent::boot();

		PeGlobal::$config["content-width"] = 870;
		PeGlobal::$config["post-formats"] = array("video","gallery");
		PeGlobal::$config["post-formats-project"] = array("video","gallery");

		PeGlobal::$config["image-sizes"]["thumbnail"] = array(120,90,true);
		PeGlobal::$config["image-sizes"]["medium"] = array(472,266,true);
		PeGlobal::$config["image-sizes"]["large"] = array(870,490,true);
		PeGlobal::$config["image-sizes"]["post-thumbnail"] = PeGlobal::$config["image-sizes"]["medium"];
		

		//PeGlobal::$config["nav-menus"]["footer"] = __pe("Footer menu");

		// blog layouts
		PeGlobal::$config["blog"] =
			array(
				  __pe("Grid") => "grid",
				  __pe("List") => ""
				  );

		PeGlobal::$config["widgets"] = 
			array(
				  );

		PeGlobal::$config["shortcodes"] = 
			array(
				  "BS_Slider",
				  "BS_Video"
				  );

		PeGlobal::$config["sidebars"] =
			array(
				  "default" => __pe("Default post/page")
				  );

		PeGlobal::$config["colors"] = 
			array(
				  "color1" => 
				  array(
						"label" => __pe("Primary Color"),
						"selectors" => 
						array(
							  "blockquote p" => "border-color",
							  ".bypostauthor > .comment-body > .comment-author img" => "border-color",
							  ".bypostauthor > .comment-body .fn a" => "color",
							  "[class^='icon-']" => "color",
							  ".comment-body > .span11 > p a" => "color",
							  "#comments-title span" => "color",
							  "#commentform  .comment-notes a" => "color",
							  "#commentform .control-group .required" => "color",
							  "#commentform .form-submit button[type='submit']" => "background-color",
							  "#commentform input[type='text']:focus" => "border-color",
							  "#commentform textarea:focus" => "border-color",
							  "#comments .reply .label:hover" => "background-color",
							  ".fn a" => "color",
							  ".icon:hover" => "color",
							  ".lead a" => "color",
							  ".more-link" => "color",
							  "#nav .selected a" => "color",
							  "nav ul li a:hover" => "color",
							  ".og-details a" => "background-color",
							  ".og-details a " => "border-color",
							  "p > a" => "color",
							  ".pager li > a" => "color",
							  ".pager li > span" => "color",
							  ".pagination ul > li.active > a" => "color",
							  ".pagination ul > li > a:hover" => "color",
							  ".peSlider > div.peCaption h3" => "color",
							  "#portraits li .poste" => "background-color",
							  ".post-body ul li:before" => "color",
							  ".post h3 a:hover" => "color",
							  ".post .post-meta a" => "color",
							  ".post .tags a:hover" => "background-color",
							  "section.contact .inner a" => "color",
							  "section.contact .inner form input[type='email']:focus" => "border-color",
							  "section.contact .inner form input[type='email']:required:valid" => "border-color",
							  "section.contact .inner form input[type='email']:required:valid " => "color",
							  "section.contact .inner form input[type='text']:focus" => "border-color",
							  "section.contact .inner form input[type='text']:required:valid" => "border-color",
							  "section.contact .inner form input[type='text']:required:valid " => "color",
							  "section.contact .inner form .required" => "color",
							  "section.contact .inner form .submit" => "border-color",
							  "section.contact .inner form .submit " => "background-color",
							  "section.contact .inner form .submit:hover" => "background-color",
							  "section.contact .inner form textarea:focus" => "border-color",
							  "section.contact .inner form textarea:required:valid" => "border-color",
							  "section.contact .inner form textarea:required:valid " => "color",
							  "#tab a" => "background-color",
							  ".tweet_list li a:hover" => "border-color",
							  ".tweet_list li a:hover " => "color",
							  ".widget_archive a" => "color",
							  ".widget_calendar tbody td a" => "color",
							  ".widget_categories a" => "color",
							  ".widget_links li a" => "color",
							  ".widget_meta li a" => "color",
							  ".widget_nav_menu li a" => "color",
							  ".widget_pages li a" => "color",
							  ".widget_recent_entries li a" => "color",
							  ".widget_search input[type='text']:focus" => "border-color",
							  ".widget_tag_cloud a:hover" => "background-color"
							  ),
						"default" => "#00aed7"
						)
				  );
		

		PeGlobal::$config["fonts"] = 
			array(
				  "fontHeading" => 
				  array(
						"label" => __pe("Primary Font"),
						"selectors" => 
						array(
								"p",
								"h2",
								"h3",
								".post h3",
								".row ",
								".post .tags a",
								"input",
								"input[type=text]",
								"textarea",
								".widget_tag_cloud a",
								"body",
								"html",
								".lead",
								".roles",
								"section.contact .row",
								"section.contact .inner form input[type='text']",
								"section.contact .inner form input[type='email']",
								"section.contact .inner form textarea",
								"section.contact .inner form .submit",
								".tweet_list .tweet_time a",
								"#ticker ul.tweet_list",
								"#ticker .tweet_list li",
								"footer",
								"header h1",
								"section.portfolio h2",
								".og-details a",
								"section.about h2",
								"#portraits li .poste",
								"section.contact h2",
								"section.contact .inner form label",
								"section.contact .inner h4",
								".peSlider > div.peCaption h3",
								"button",
								
							  ),
						"default" => "Open Sans"
						)
				  );

		

		$options = array();

		if (!defined('PE_HIDE_IMPORT_DEMO') || !PE_HIDE_IMPORT_DEMO) {
			$options["import_demo"] = $this->defaultOptions["import_demo"];
		}

		$options = array_merge($options,
			array(
				  /*
				  "skin" => 
				  array(
						"label"=>__pe("Skin"),
						"type"=>"RadioUI",
						"section"=>__pe("General"),
						"description" => __pe("Select Theme Skin"),
						"options" => array("light","dark"),
						"single" => true,
						"default"=>"light"
						),*/
				  "logo" => 
				  array(
						"label"=>__pe("Header Logo"),
						"type"=>"Upload",
						"section"=>__pe("General"),
						"description" => __pe("This is the main site logo image. The image should be a .png file."),
						"default"=> PE_THEME_URL."/images/logo_small.png"
						),
				  "favicon" => 
				  array(
						"label"=>__pe("Favicon"),
						"type"=>"Upload",
						"section"=>__pe("General"),
						"description" => __pe("This is the favicon for your site. The image can be a .jpg, .ico or .png with dimensions of 16x16px "),
						"default"=> PE_THEME_URL."/favicon.jpg"
						),
				  "customCSS" => $this->defaultOptions["customCSS"],
				  "customJS" => $this->defaultOptions["customJS"],
				  "customColors" => 
				  array(
						"label"=>__pe("Custom Colors"),
						"type"=>"Help",
						"section"=>__pe("Colors"),
						"description" => __pe("In this page you can set alternative colors for the main colored elements in this theme. A primary color change option has been provided. To change the colors used on these primary elements simply write a new hex color reference number into the fields below or use the color picker which appears when the input field obtains focus. Once you have selected your desired colors make sure to save them by clicking the <b>Save All Changes</b> button at the bottom of the page. Then just refresh your page to see the changes.<br/><br/><b>Please Note:</b> Some of the colored elements in this theme may be made from images. It is not possible to change these elements via this page, instead such elements will need to be changed manually by opening the images/icons in an image editing program and manually changing their colors to match your theme's custom color scheme. <br/><br/>To return all colors to their default values at any time just hit the <b>Restore Default</b> link beneath each field."),
						),
				  "googleFonts" =>
				  array(
						"label"=>__pe("Custom Fonts"),
						"type"=>"Help",
						"section"=>__pe("Fonts"),
						"description" => __pe("In this page you can set the typefaces to be used throughout the theme. For each elements listed below you can choose any front from the Google Web Font library. Once you have chosen a font from the list, you will see a preview of this font immediately beneath the list box. The icons on the right hand side of the font preview, indicate what weights are available for that typeface.<br/><br/><strong>R</strong> -- Regular,<br/><strong>B</strong> -- Bold,<br/><strong>I</strong> -- Italics,<br/><strong>BI</strong> -- Bold Italics<br/><br/>When decideing what font to use, ensure that the chosen font contains the font weight required by the element. For example, main headings are bold, so you need to select a new font for these elements which supports a bold font weight. If you select a font which does not have a bold icon, the font will not be applied. <br/><br/>Browse the online <a href='http://www.google.com/webfonts'>Google Font Library</a><br/><br/><b>Custom fonts</b> (Advanced Users):<br/> Other then those available from Google fonts, custom fonts may also be applied to the elements listed below. To do this an additional field is provided below the google fonts list. Here you may enter the details of a font family, size, line-height etc. for a custom font. This information is entered in the form of the shorthand 'font:' CSS declaration, for example:<br/><br/><b>bold italic small-caps 1em/1.5em arial,sans-serif</b><br/><br/>If a font is specified in this field then the font listed in the Google font drop menu above will not be applied to the element in question. If you wish to use the Google font specified in the drop down list and just specify a new font size or line height, you can do so in this field also, however the name of the Google font <b>MUST</b> also be entered into this field. You may need to visit the Google fonts web page to find the exact CSS name for the font you have chosen." )
						),
				  "logoFooter" => 
				  array(
						"label"=>__pe("Footer Logo"),
						"type"=>"Upload",
						"section"=>__pe("Footer"),
						"description" => __pe("This is the footer  logo image. The image should be a .png file."),
						"default"=> PE_THEME_URL."/images/logo_footer.png"
						),
				  "twitter" => 	
				  array(
						"label"=>__pe("Twitter"),
						"type"=>"Text",
						"section"=>__pe("Footer"),
						"default"=>"#"
						),
				  "linkedin" => 	
				  array(
						"label"=>__pe("LinkedIn"),
						"type"=>"Text",
						"section"=>__pe("Footer"),
						"default"=>"#"
						),
				  "facebook" => 	
				  array(
						"label"=>__pe("Facebook"),
						"type"=>"Text",
						"section"=>__pe("Footer"),
						"default"=>"#"
						),
				  "dribbble" => 	
				  array(
						"label"=>__pe("Dribbble"),
						"type"=>"Text",
						"section"=>__pe("Footer"),
						"default"=>"#"
						),
				  "behance" => 	
				  array(
						"label"=>__pe("Behance"),
						"type"=>"Text",
						"section"=>__pe("Footer"),
						"default"=>"#"
						),
				  "contactEmail" => $this->defaultOptions["contactEmail"],
				  "contactSubject" => $this->defaultOptions["contactSubject"],
				  "sidebars" => 
				  array(
						"label"=>__pe("Widget Areas"),
						"type"=>"Sidebars",
						"section"=>__pe("Widget Areas"),
						"description" => __pe("Create new widget areas by entering the area name and clicking the add button. The new widget area will appear in the table below. Once a widget area has been created, widgets may be added via the widgets page."),
						"default"=>""
						),
				  "404content" => 
				  array(
						"label"=>__pe("Content"),
						"type"=>"TextArea",
						"section"=>__pe("Custom 404"),
						"description" => __pe("Content of 404 (not found) page"),
						"wpml" => true,
						"default"=> '<strong>
The Page You Are Looking For Cannot Be Found
</strong>
'
						)

				  ));

		$options = array_merge($options,$this->color->options());
		$options = array_merge($options,$this->font->options());

		$options["lazyImages"] =& $this->defaultOptions["lazyImages"];
		$options["minifyJS"] =& $this->defaultOptions["minifyJS"];
		$options["minifyCSS"] =& $this->defaultOptions["minifyCSS"];

		$options["adminThumbs"] =& $this->defaultOptions["adminThumbs"];
		$options["mediaQuick"] =& $this->defaultOptions["mediaQuick"];
		$options["mediaQuickDefault"] =& $this->defaultOptions["mediaQuickDefault"];

		$options["updateCheck"] =& $this->defaultOptions["updateCheck"];
		$options["updateUsername"] =& $this->defaultOptions["updateUsername"];
		$options["updateAPIKey"] =& $this->defaultOptions["updateAPIKey"];

		$options["adminLogo"] =& $this->defaultOptions["adminLogo"];
		$options["adminUrl"] =& $this->defaultOptions["adminUrl"];
		
		PeGlobal::$config["options"] =& apply_filters("pe_theme_options",$options);

		$galleryMbox = 
			array(
				  "title" => __pe("Slider"),
				  "type" => "GalleryPost",
				  "priority" => "core",
				  "where" =>
				  array(
						"post" => "gallery"
						),
				  "content" =>
				  array(
						"id" => PeGlobal::$const->gallery->id,
						"width" =>
						array(
							  "label"=>__pe("Width"),
							  "type"=>"Text",
							  "description" => __pe("Leave empty to use default width."),
							  "default"=> ""
							  ),
						"height" =>
						array(
							  "label"=>__pe("Height"),
							  "type"=>"Text",
							  "description" => __pe("Leave empty to avoid image cropping. When empty, all the (original) images must have the same size for the slider to work correctly."),
							  "default"=> "333"
							  ),
						)
				  );

		$bgMbox = 
			array(
				  "title" => __pe("Settings."),
				  "priority" => "core",
				  "where" =>
				  array(
						"post" => "page-home"
						),
				  "content" =>
				  array(
						"logo" => 
						array(
							  "label"=>__pe("Logo"),
							  "type"=>"Upload",
							  "description" => __pe("The image should be a .png file."),
							  "default"=> PE_THEME_URL."/images/logo_header.png"
							  ),
						"background" => 
						array(
							  "label"=>__pe("Background"),
							  "type"=>"Upload",
							  "description" => __pe("Background images."),
							  "default"=> PE_THEME_URL."/images/home-bg.jpg"
							  ),
						"headlines" => 
						array(
							  "label"=>__pe("Headlines"),
							  "type"=>"Links",
							  "sortable" => true,
							  "description" => __pe("Add one or more headlines to be shown above the home backgaround."),
							  "default"=>
							  array(
									__pe("We are Design"),
									__pe("We are Code"),
									__pe("We are Video"),
									__pe("We are Friendly"),
									__pe("We are what you need")
									)
							  ),
						"label" => 
						array(
							  "label"=>__pe("Label Text"),
							  "type"=>"Text",
							  "description" => __pe("If empty, hides the label."),
							  "default"=> __pe("See what we do")
							  ),
						"url" => 
						array(
							  "label"=>__pe("Label Url"),
							  "type"=>"Text",
							  "default"=> "#portfolio"
							  )
						)
				  );


		$projectMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Project Link"),
				  "priority" => "core",
				  "where" => 
				  array(
						"post" => "all",
						),
				  "content"=>
				  array(
						"label" => 	
						array(
							  "label"=>__pe("Label"),
							  "type"=>"Text",
							  "description" => __pe("Optional project link label."),
							  "default"=>__pe("Visit website")
							  ),
						"url" => 	
						array(
							  "label"=>__pe("Url"),
							  "type"=>"Text",
							  "description" => __pe("Optional project link url, leave empty to hide."),
							  "default"=>""
							  )
						)
				  );

	
		$staffMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Staff"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-staff",
						),
				  "content"=>
				  array(
						"subtitle" => 	
						array(
							  "label"=>__pe("Subtitle"),
							  "type"=>"Text",
							  "default"=>'The most important thing to us is <br>building products people love.'
							  ),
						"members" => 
						array(
							  "label"=>__pe("Staff"),
							  "type"=>"Links",
							  "options" => $this->staff->option(),
							  "description" => __pe("Add one or more staff member."),
							  "sortable" => true,
							  "default"=> array()
							  ),
						)
				  );

		$defaultInfo = <<<EOL
<h4>Where to meet</h4>
<br />
<p>1000 Bruxelles</p>
<p>Avenue Saint Pierre, 82</p>
<p>BELGIUM</p>

<h4>New business</h4>
<br />
<p><a href="#">stuff@halfcreative.be</a></p>

<h4>Employement</h4>
<br/>
<p><a href="#">needmoney@halfcreative.be</a></p>
EOL;

		$contactMbox = 
			array(
				  "type" =>"",
				  "title" =>__pe("Contact Options"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-contact",
						),
				  "content"=>
				  array(
						"subtitle" => 	
						array(
							  "label"=>__pe("Subtitle"),
							  "type"=>"Text",
							  "default"=>sprintf('We\'re currently accepting new client projects.<br>Think we might help? We\'d love to hear from you.',"\n")
							  ),
						"info" => 	
						array(
							  "label"=>__pe("Info"),
							  "type"=>"TextArea",
							  "description" => __pe("Contact Info."),
							  "default"=> $defaultInfo
							  ),
						"msgOK" => 	
						array(
							  "label"=>__pe("Mail Sent Message"),
							  "type"=>"TextArea",
							  "description" => __pe("Message shown when form message has been sent without errors"),
							  "default"=>'<strong>Yay!</strong> Message sent.'
							  ),
						"msgKO" => 	
						array(
							  "label"=>__pe("Form Error Message"),
							  "type"=>"TextArea",
							  "description" => __pe("Message shown when form message encountered errors"),
							  "default"=>'<strong>Error!</strong> See marked fields.'
							  )
						)
				  );

		
		$portfolioMbox =& PeGlobal::$const->portfolio->metabox;
		unset($portfolioMbox["content"]["pager"]);
		unset($portfolioMbox["content"]["filterable"]);
		unset($portfolioMbox["content"]["columns"]);

		$portfolioMbox["content"] = 
			array_merge(
						array(
							  "subtitle" => 	
							  array(
									"label"=>__pe("Subtitle"),
									"type"=>"Text",
									"description" => __pe("Subtitle text."),
									"default"=> 'See also great stuff on <a href="#">Behance</a>.'
									)
							  ),
						$portfolioMbox["content"]
						);


		PeGlobal::$config["metaboxes-post"] = 
			array(
				  "video" => PeGlobal::$const->video->metaboxPost,
				  "sidebar" => PeGlobal::$const->sidebar->metabox,
				  "gallery" => $galleryMbox
				  );

		PeGlobal::$config["metaboxes-page"] = 
			array(
				  
				  "bg" => $bgMbox,
				  "sidebar" => array_merge(PeGlobal::$const->sidebar->metabox,array("where"=>array("post"=>"page-blog, page-portfolio"))),
				  "blog" => array_merge(PeGlobal::$const->blog->metabox,array("where"=>array("post"=>"page-blog"))),
				  "staff" => $staffMbox,
				  "portfolio" => $portfolioMbox,
				  "contact" => $contactMbox
				  );


		PeGlobal::$config["metaboxes-project"] = 
			array(
				  "project" => $projectMbox,
				  "gallery" => $galleryMbox,
				  "video" => PeGlobal::$const->video->metaboxPost
				  );

	}

	public function pre_get_posts_filter($query) {
		if ($query->is_search) {
			$query->set('post_type',array('post'));
		}

		/*
		if (is_tax("prj-category") && !empty($query->query_vars["prj-category"])) {
			$query->set('posts_per_page',16);
		}
		*/

		return $query;
	}

	protected function init_asset() {
		return new PeThemeHalfcreativeAsset($this);
	}
}

?>
