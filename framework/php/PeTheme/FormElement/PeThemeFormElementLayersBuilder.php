<?php

class PeThemeFormElementLayersBuilder extends PeThemeFormElement {

	public function registerAssets() {
		parent::registerAssets();
	}
	
	protected function template() {
		$home = home_url();
		$img = peTheme()->content->get_origImage();
		$size = __pe("Size");
		$change = __pe("Change Image");

		$html = <<<EOT
<div class="option option-input option-layersbuilder" id="[ID]">
	<div class="pe_layer_builder_preview">
		<iframe id="pe_layer_builder_iframe" width="[W]" height="[H]" data-home="$home" data-img="$img" data-w="[W]" data-h="[H]"></iframe>
		<div class="pe_layer_builder_preview_size">
			<label for="[ID]">$size</label><input id="[ID]" type="text" value="[VALUE]" name="[NAME]" data-name="[DATA_NAME]"/>
			<input type="button" class="ob_button pe_sidebar_new" value="$change">
		</div>
	</div>
</div>
EOT;

		return $html;
	}

	protected function addTemplateValues(&$data) {
		list($w,$h) = split("x",$data["[VALUE]"]);

		$data["[W]"] = $w;
		$data["[H]"] = $h;

	}

}

?>
