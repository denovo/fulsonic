<?php

class PeThemeFormElementRadioUI extends PeThemeFormElementRadio {
	
	public function registerAssets() {
		parent::registerAssets();
		wp_enqueue_script("jquery-ui-button");
		wp_enqueue_style("pe_theme_admin_ui");
	}

	protected function template() {
		$html = <<<EOT
<div class="option">
    <h4>[LABEL]</h4>
    <div class="section">
        <div class="element">
<div id="[ID]_buttonset">
[OPTIONS]
</div>
        </div>
        <div class="description">[DESCRIPTION]</div>
    </div>
	</div>
	<script type="text/javascript">
		jQuery(function() {
		jQuery("#[ID]_buttonset").buttonset();
		});
	</script>
EOT;
		return $html;
	}

	protected function addTemplateMarkup(&$buffer,&$options,$value,$id,$name,$single) {
		$count = 0;
		foreach ($options as $label=>$current) {
			$label = $single ? $current : $label;
			$selected = ($current == $value) ? " checked " : "";
			$buffer .=  "<input name=\"$name\" id=\"{$id}_$count\" type=\"radio\" value=\"".esc_attr($current)."\"$selected /><label for=\"{$id}_$count\">".esc_attr($label).'</label>';
			$count++;
		}
	}

}

?>
