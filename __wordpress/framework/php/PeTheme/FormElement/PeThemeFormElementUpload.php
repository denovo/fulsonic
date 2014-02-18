<?php

class PeThemeFormElementUpload extends PeThemeFormElement {

	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.field.upload.js",array(),"pe_theme_field_upload");
		wp_enqueue_script("pe_theme_field_select");
		wp_enqueue_script("thickbox");
		wp_enqueue_script("media-upload");
		wp_enqueue_script("pe_theme_field_upload");
		wp_enqueue_style("thickbox");
	}

	protected function template() {
		$html = <<<EOT
<div class="option option-input">
    <h4>[LABEL]</h4>
    <div class="section">
        <div class="element">
            <input id="[ID]" type="text" value="[VALUE]" name="[NAME]" class="upload [UPCLASS]" />
			<input id="upload_[ID]" class="upload_button" type="button" value="Upload" />
        </div>
        <div class="description">[DESCRIPTION]</div>
    </div>
	</div>
<script type="text/javascript">
jQuery("#[ID]").peFieldUpload();
</script>
EOT;

		return $html;
	}

	protected function addTemplateValues(&$data) {
		$data["[UPCLASS]"]="pepreview";
	}

}

?>
