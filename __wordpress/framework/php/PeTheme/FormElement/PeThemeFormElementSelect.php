<?php

class PeThemeFormElementSelect extends PeThemeFormElement {

	public function registerAssets() {
		parent::registerAssets();
		PeThemeAsset::addScript("framework/js/admin/jquery.theme.field.select.js",array(),"pe_theme_field_select");
		wp_enqueue_script("pe_theme_field_select");
	}
	
	protected function template() {
		$html = <<<EOT
<div class="option option-select">
    <h4>[LABEL]</h4>
    <div class="section">
        <div class="element">
			<div class="select_wrapper">
				<select id="[ID]" name="[NAME]" class="select" data-name="[DATA_NAME]">
					[OPTIONS]
				</select>
			</div>
        </div>
        <div class="description">[DESCRIPTION]</div>
    </div>
</div>
<script type="text/javascript">[SCRIPT]</script>
EOT;
		return $html;
	}

	protected function jsInit() {
		return 'jQuery("#[ID]").peFieldSelect();';
	}

	protected function getOptionList($options) {
		$buffer = "";
		if (isset($this->data["single"])) {
			$single = $this->data["single"];
		} else {
			$single = false;
		}
		if (isset($this->data["value"])) {
			$value = $this->data["value"];
		} else {
			$value = $this->data["default"];
		}
		foreach ($options as $label=>$current) {
			$label = $single ? $current : $label;
			$selected = ($current == $value) ? " selected " : "";
			$buffer .= "<option $selected value=\"".esc_attr($current).'">'.esc_attr($label).'</option>';
		}
		return $buffer;
	}

	protected function addTemplateValues(&$data) {
		$data['[SCRIPT]'] = str_replace("[ID]",$data['[ID]'],$this->jsInit());
		$options =& $this->data["options"];
		$buffer =& $data["[OPTIONS]"];
		$buffer = "";
		if (!is_array($options) || count($options) == 0) return;
		if (isset($this->data["groups"])) {
			foreach ($options as $group => $optgroup) {
				$buffer .= '<optgroup label="'.esc_attr($group).'">'.$this->getOptionList($optgroup).'</optgroup>';
			}
		} else {
			$buffer .= $this->getOptionList($options);
		}
	}

}

?>
