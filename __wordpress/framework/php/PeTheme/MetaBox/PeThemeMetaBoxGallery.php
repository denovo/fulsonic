<?php

class PeThemeMetaBoxGallery extends PeThemeMetaBox {

	protected function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript(
								"framework/js/admin/jquery.theme.metabox.gallery.js",
								array(
									  'jquery',
									  'jquery-ui-core',
									  'jquery-ui-tabs',
									  'jquery-ui-sortable',
									  'jquery-ui-dialog',
									  'wpdialogs',
									  'wpdialogs-popup',
									  //'wplink',
									  'jquery-ui-progressbar',
									  'pe_theme_metabox'
									  ),
								"pe_theme_metabox_gallery"
								);		
	}

	public function getClasses($type) {
		$c = peTheme()->options->mediaQuick == "yes" ? "" : "pe_no_quick";
		return "pe_mbox_gallery $c ".parent::getClasses($type);
	}

	protected function requireAssets() {
		wp_enqueue_script("pe_theme_metabox_gallery");
		wp_enqueue_style("wp-jquery-ui-dialog");
	}

	public function render($post) {
		parent::render($post);
	}


}

?>
