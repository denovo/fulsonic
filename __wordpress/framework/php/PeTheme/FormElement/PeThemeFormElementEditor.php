<?php

class PeThemeFormElementEditor extends PeThemeFormElementTextArea {

	public function registerAssets() {
		PeTheme()->editor->instantiate();
	}

	protected function jsInit() {
		//return 'window.peThemeCustomEditor && window.peThemeCustomEditor.add(jQuery("#[ID]"));';
		return 'jQuery("#edit_[ID]").click(function () {window.peThemeCustomEditor && window.peThemeCustomEditor.load("[ID]")});';
	}

	protected function template() {
		$msg = sprintf(__pe("%sEdit with the HTML Editor%s"),'<a href="#" id="edit_[ID]" onclick="return window.peThemeCustomEditor.show(\'[ID]\')">','</a>');
		$html = <<<EOT
<div class="option option-textarea">
    <h4>[LABEL]</h4>
    <div class="section">
        <div class="element">
            <textarea class="pe_theme_editor" id="[ID]" name="[NAME]" rows="5" data-name="[DATA_NAME]">[VALUE]</textarea>
			<small>$msg</small>
        </div>
        <div class="description">[DESCRIPTION]</div>
    </div>
</div>
EOT;
		return $html;
	}

}

?>
