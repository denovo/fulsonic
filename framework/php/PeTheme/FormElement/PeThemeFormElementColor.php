<?php

class PeThemeFormElementColor extends PeThemeFormElement {
	
	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.color.picker.js",array(),"pe_theme_colorpicker");
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.field.color.js",array('pe_theme_colorpicker'),"pe_theme_field_color");
		wp_enqueue_script("pe_theme_field_color");
	}

	protected function template() {
		$msg = sprintf(__pe("Click text box for color picker. %sRestore default%s"),'<a href="#" id="restore_[ID]">','</a>');
		$html = <<< EOT
<div class="option">
    <h4>[LABEL]</h4>
    <div class="section">
        <div class="element">
			<input type="text" name="[NAME]" id="[ID]" value="[VALUE]" data-default="[DEFAULT]" data-name="[DATA_NAME]" class="cp_input" />
			<div id="cp_[ID]" class="cp_box">
			<div style="background-color:[VALUE];background-image:none;border-color:[VALUE];"></div>
			</div>
			<small>$msg</small>
        </div>
        <div class="description">[DESCRIPTION]</div>
    </div>
</div>
	<script type="text/javascript">
jQuery('#[ID]').peFieldColor();
</script>

EOT;
	

return $html;
	}

}

?>
