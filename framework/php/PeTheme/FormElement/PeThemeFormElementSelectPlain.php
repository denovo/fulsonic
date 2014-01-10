<?php

class PeThemeFormElementSelectPlain extends PeThemeFormElementSelect {
	
	protected function template() {
		$html = <<<EOT
<select id="[ID]" name="[NAME]">
[OPTIONS]
</select>
EOT;
		return $html;
	}

}

?>
