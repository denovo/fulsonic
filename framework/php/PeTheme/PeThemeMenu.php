<?php

class PeThemeMenu {

	public $defaults;


	public function __construct() {
		$this->defaults = array(
								 'theme_location'  => "",
								 'menu'            => "", 
								 'container'       => "", 
								 'container_class' => "", 
								 'container_id'    => "",
								 'menu_class'      => null, 
								 'menu_id'         => null,
								 'echo'            => true,
								 'fallback_cb'     => false,
								 'before'          => "",
								 'after'           => "",
								 'link_before'     => "",
								 'link_after'      => "",
								 'items_wrap'      => apply_filters("pe_theme_menu_items_wrap",'<ul class="nav">%3$s</ul>'),
								 'walker' => new Walker_Nav_Menu_PE(),
								 'depth'           => 0,
								 'pe_type' => "default"
								 );

		add_filter("wp_nav_menu_objects",array(&$this,"wp_nav_menu_objects_filter"));
	}

	public function getMenuConf($override,$type) {
		switch ($type) {
		case "sidebar":
			$override["items_wrap"] = '<ul class="nav nav-list">%3$s</ul>';
		case "simple":
			$override["depth"] = 1;
			$override["pe_type"] = $type;
		}
		$override["items_wrap"] = apply_filters("pe_theme_menu_items_wrap_$type",empty($override["items_wrap"]) ? $this->defaults["items_wrap"] : $override["items_wrap"]);
		return array_merge($this->defaults,$override);
	}

	public function show($menu,$type = "default") {
		wp_nav_menu($this->getMenuConf(array("theme_location" => $menu),$type));
	}

	public function showID($menu,$type = "default") {
		wp_nav_menu($this->getMenuConf(array("menu" => $menu),$type));
	}

	public function wp_nav_menu_objects_filter($items) {
		$hasChild = array();
		$keys = array_keys($items);
		foreach ($keys as $i) {
			$item =& $items[$i];
			if ($item->menu_item_parent > 0) {
				$hasChild[$item->menu_item_parent] = $item->ID;
			}
			switch ($item->url) {
			case "home":
			case "#home":
				$item->url = home_url();
				if (is_front_page()) {
					$item->classes[] = "current-menu-item";
				}
				break;
			}
		}
		
		$nthLevel = apply_filters("pe_theme_menu_nth_level_icon",'<span class="icon-chevron-right icon-white"></span>',$items);
		$topLevel = apply_filters("pe_theme_menu_top_level_icon",' <b class="caret"></b>',$items);
		foreach ($keys as $i) {
			$item =& $items[$i];
			if (isset($hasChild[$item->ID])) {
				$item->title .= $item->menu_item_parent ? $nthLevel : $topLevel;
				$item->has_child = $hasChild[$item->ID];
			}
		}
		return $items;
	}

}

class Walker_Nav_Menu_PE extends Walker_Nav_Menu {

	function start_lvl(&$output, $depth) {
		$classes = apply_filters("pe_theme_menu_dropdown_menu_class","dropdown-menu",$depth);
		if ($depth > 0) {
			$classes .= " sub-menu";
		}
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"$classes\">\n";
	}

	function start_el(&$output, $item, $depth, $args) {

		switch ($item->url) {
		case "#divider":
			$output .= '<li class="divider">';
			return;
		case "#header":
			$output .= '<li class="nav-header">'.$item->title;
			return;
		}

		if (isset($item->has_child)) {
			$item->classes[] = apply_filters("pe_theme_menu_dropdown_menu_item_class","dropdown",$depth);
		}
		
		if (in_array("current-menu-item",$item->classes)) {
			$item->classes[] = apply_filters("pe_theme_menu_current_menu_item_class","active",$depth);
		}

		if (in_array("current-menu-ancestor",$item->classes) ) {
			$item->classes[] = apply_filters("pe_theme_menu_current_menu_ancestor_class","active",$depth);
		}

		$item->classes = apply_filters("pe_theme_menu_item_classes",$item->classes,$item,$depth);

		parent::start_el($output, $item, $depth, $args);
	}

	function end_el(&$output, $item, $depth) {
		$output .= "</li>\n";
	}
}


?>