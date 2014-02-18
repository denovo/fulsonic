<?php

class PeThemeData {

	public $master;
	public $loop = false;
	public $stack;

	public function __construct($master) {
		$this->master =& $master;
	}

	public function init(&$data,$save = false) {
		if ($data && isset($data->loop) && @is_array($data->loop) && count($data->loop) > 0) {
			$this->loop =& new PeThemeDataLoop($data);
			if ($save) {
				global $post;
				$this->loop->save = true;
			}
		} else {
			$this->loop = false;
		}
	}

	public function set(&$loop) {
		$this->loop =& $loop;
	}

	public function get() {
		$loop = $this->loop;
		$this->loop = false;
		return $loop;
	}

	
	public function create(&$data,$save = false) {
		$this->init($data,$save);
		return $this->get();
	}
	
	public function postSave() {
		global $post,$more;
		$this->stack[] = array($post,$more);
		$more = false;
	}

	public function postSetup(&$item) {
		global $post,$more;
		$post = $item;
		$this->stack[] = array($post,$more);
		setup_postdata($post);
		$more = false;
	}

	public function postReset() {
		global $post,$more;
		list($post,$more) = array_pop($this->stack);
		wp_reset_postdata();
		
	}


	public function createPager($current,$links,$max) {
		if (!is_array($links)) return false;
		$pages = count($links);
		if ($pages < 2) return false;
		$current = $current ? $current-1 : 0;
		$current = min($current,count($links)-1);
		$data =& new StdClass();
		$data->loop = array();

		$start = ($max >= $pages) ? 0 : max(0,$current-intval(($max-1)/2));
		$end = $start+$max;
		if ($end > $pages) {
			$start = max(0,$start-($end-$pages));
			$end = $pages;
		}
		
		for ($p=$start;$p<$end;$p++) {
			$page =& new StdClass();
			$isCurrent = ($current == $p);
			$page->class = $isCurrent ? "active" : "";
			$page->link = $links[$p];
			$page->num = $p+1;
			$data->loop[] =& $page;
		}

		$data->prev = new StdClass();
		$data->prev->link = $current > 0 ? $links[$current-1] : "";
		$data->prev->class = $current > 0 ? "" : "disabled";

		$current++;
		$data->next = new StdClass();
		$data->next->link = $current < $pages ? $links[$current] : "";
		$data->next->class = $current < $pages ? "" : "disabled";
		
		return $this->create($data);
	}

	public function &getTaxOptions($taxonomy) {
		$terms =& get_terms($taxonomy,array("orderby"=>"name"));
		$options = array();
		if (is_array($terms)) {
			foreach ($terms as $term) {
				if ($term->count > 0) { 
					$options["$term->name ($term->count)"] = $term->slug;
				}
			}
		}
		return $options;
	}


}

class PeThemeDataLoop  {
	public $main;
	public $count = 0;
	public $last = 0;
	public $save = false;

	public function __construct($data) {
		$this->main =& $data;
		$this->last = count($data->loop)-1;
	}

	public function &next() {
		if ($this->count <= $this->last) {
			$item =& $this->main->loop[$this->count];
			$item->idx = $this->count;
			if ($this->save) {
				peTheme()->data->postSetup($item);
			}
			$this->count++;
		} else {
			$item = false;
			if ($this->save) {
				peTheme()->data->postReset();
			}
		}
		return $item;
	}


}

?>