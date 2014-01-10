<?php

class PeThemeWidgetMenu extends PeThemeWidget {

	public function __construct() {
		$this->name = __pe("Pixelentity - Menu");
		$this->description = __pe("Show a menu");
		$this->wclass = "widget_menu";

		$menus = get_terms("nav_menu",array("hide_empty" => false));

		if ($menus) {
			foreach ( $menus as $menu ) {
				$options[$menu->name] = $menu->term_id;
			}
			$description = __pe("Select a menu");
		} else {
			$options[__pe("No menus have been created yet")] = -1;
			$description = sprintf(__pe('<a href="%s">Create a menu</a>'),admin_url('nav-menus.php'));
		}

		$this->fields = array(
							  "title" => 
							  array(
									"label"=>__pe("Title"),
									"type"=>"Text",
									"description" => __pe("Widget title"),
									"default"=>"Menu widget"
									),
							  "id" =>
							  array(
									"label" => __pe("Menu"),
									"type" => "Select",
									"description" => $description,
									"options" => $options
									)
							  );

		parent::__construct();
	}


	public function widget($args,$instance) {
		$instance = $this->clean($instance);
		extract($instance);

		if (!@$id) return;		
		echo $args["before_widget"];
		if (isset($title)) echo "<h3>$title</h3>";
		echo '<div class="well">';
		peTheme()->menu->showID($id,"sidebar");
		echo "</div>";
		echo $args["after_widget"];
	}


}
?>
