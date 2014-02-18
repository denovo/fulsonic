<?php

class PeThemeConstantPortfolio {
	public $metabox;

	public function __construct() {
		$this->metabox = 
			array(
				  "title" =>__pe("Portfolio"),
				  "priority" => "core",
				  "where" => 
				  array(
						"page" => "page-portfolio",
						),
				  "content"=>
				  array(
						"columns" =>
						array(
							  "label"=>__pe("Columns"),
							  "type"=>"Select",
							  "description" => __pe("Specify the layout arrangement of columns for the project items. "),
							  "options" => apply_filters("pe_theme_portfolio_layouts",
							  array(
									__pe("Single column (no grid)")=>1,
									__pe("2 Columns")=>2,
									__pe("3 Columns")=>3,
									__pe("4 Columns")=>4,
									__pe("6 Columns")=>6
									)),
							  "default"=>apply_filters("pe_theme_portfolio_default_layout",3),
							  ),
						"filterable" => 
						array(
							  "label"=>__pe("Allow Filtering"),
							  "type"=>"RadioUI",
							  "description" => __pe("Specify if the project filter keywords are shown in this page. "),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"yes"
							  ),
						"count" =>
						array(
							  "label" => __pe("Max Project"),
							  "type" => "Text",
							  "description" => __pe("Maximum number of project to show, leave empty for unlimited."),
							  "default" => "",
							  ),
						"pager" => 
						array(
							  "label"=>__pe("Paged Result"),
							  "type"=>"RadioUI",
							  "description" => __pe("Display a pager when more posts are found than specified in the 'Maximum' field. "),
							  "options" => PeGlobal::$const->data->yesno,
							  "default"=>"no"
							  ),
						"id" => 
						array(
							  "label"=>__pe("Selection"),
							  "type"=>"Links",
							  "description" => __pe("Using this control, you can manually pick individual projects to be included in the portfolio. If you also want projects to be shown in the same order as listed here, make sure no 'tag' is selected in the next field."),
							  "sortable" => true,
							  "options"=> peTheme()->project->option()
							  ),
						"tags" =>
						array(
							  "label" => __pe("Only Include Projects With The Following Tags"),
							  "type" => "Tags",
							  "taxonomy" => "prj-category",
							  "description" => __pe("Only include projects in this page based on specific keywords/tags. "),
							  "default" => ""
							  ),
						)
				  );
	}
	
}

?>