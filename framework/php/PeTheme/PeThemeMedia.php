<?php

class PeThemeMedia {

	public $master;
	public $args = array();

	public function __construct($master) {
		$this->master =& $master;
	}

	public function size() {
		$n = func_num_args(); 
		if ($n) {
			if ($n === 3) {
				$a = func_get_args();
				$this->args[] = $this->getSize($a[0],$a[1],$a[2]);
			} else {
				$this->args[] = func_get_args();
			}
		} else {
			return array_pop($this->args);
		}
	}


	public function width($w) {
		return $this->prop(0,$w);
	}

	public function height($h) {
		return $this->prop(1,$h);
	}

	public function prop($idx,$def) {
		$last = count($this->args)-1;
		return $last >= 0 ? $this->args[$last][$idx] : $def;
	}

	public function getSize($obj,$w,$h) {
		$w = !empty($obj->width) ? $obj->width : $w; 
		$h = isset($obj->height) ? $obj->height : $h; 
		return array($w,$h);
	}


}

?>