<?php

class PeThemeImage {

	protected $wp_upload;
	protected $blanks = array();

	public function __construct() {
		$this->wp_upload = wp_upload_dir();
		$this->wp_upload = $this->wp_upload["basedir"]."/";
	}

	public function &blank($w,$h) {
		$key = "{$w}x{$h}";
		if (isset($this->blanks[$key])) {
			return $this->blanks[$key];
		}

		$external = "/img/blank/$key.gif";

		if (file_exists(PE_THEME_PATH.$external)) {
			// a blank img exists with the requested size
			$this->blanks[$key] = PE_THEME_URL.$external;
		} else {
			// create blank img
			$image = imagecreate($w, $h);
			imagesavealpha($image, true);
			imagecolortransparent($image, imagecolorallocatealpha($image, 0, 0, 0, 0));
			ob_start();
			imagegif($image);
			$this->blanks[$key] = "data:image/gif;base64,".base64_encode(ob_get_clean());
			imagedestroy($image);
		}

		return $this->blanks[$key];
	}

	public function image_resize($file,$width,$height,$crop) { // compatibilty wrapper for 3.4, >= 3.5 use wp_get_image_editor
		if (function_exists("wp_get_image_editor")) {
			// WP 3.5
			$editor = wp_get_image_editor($file);
			$editor->resize($width,$height,$crop);
			$dest_file = $editor->generate_filename();
			$editor->save($dest_file);
			return $dest_file;
		} else {
			// WP 3.4 and below
			return image_resize($file,$width,$height,$crop); // WP 3.4 and below
		}
	}


	public static function makeBWimage($file,$dest) {
		//$image = wp_load_image($file);
		$image = imagecreatefromstring( file_get_contents( $file ) );
		$res = imagefilter($image,IMG_FILTER_GRAYSCALE);
		$res = $res && imagejpeg($image,$dest);
		imagedestroy($image);
		return $res;
	}

	public function blackwhite_filter($meta) {
		if (!isset($meta) || !is_array($meta) || count($meta) == 0) {
			return $meta;
		}
		$base = dirname($this->wp_upload.$meta["file"]);
		$thumbs = array_keys(PeGlobal::$config["image-sizes"]);

		if (isset($meta["sizes"])) {
			$sizes =& $meta["sizes"];
		}

		foreach ($thumbs as $thumb) {
			if (substr($thumb,-3,3) == "-bw") {
				$normal = substr($thumb,0,strlen($thumb)-3);
				if (isset($sizes) && isset($sizes[$normal])) {
					$bwthumb = array_merge($sizes[$normal]);
				} else {
					$bwthumb = array("file" => wp_basename($meta["file"]), "width" => $meta["width"], "height" => $meta["height"]);
				}
				$file = "$base/{$bwthumb['file']}";
				$dest = preg_replace('/\.\w+$/', "-bw.jpg", $file);
				if (!isset($seen[$file])) {
					$seen[$file] = true;
					$this->makeBWimage($file,$dest);
				}
				$bwthumb["file"] = wp_basename($dest);
				$meta["sizes"][$thumb] = $bwthumb;
			}
		}

		return $meta;
	}

	/**
	 * Title		: Aqua Resizer
	 * Description	: Resizes WordPress images on the fly
	 * Version	: 1.1.3
	 * Author	: Syamil MJ
	 * Author URI	: http://aquagraphite.com
	 * License	: WTFPL - http://sam.zoy.org/wtfpl/
	 * Documentation	: https://github.com/sy4mil/Aqua-Resizer/
	 *
	 * @param string $url - (required) must be uploaded using wp media uploader
	 * @param int $width - (required)
	 * @param int $height - (optional)
	 * @param bool $crop - (optional) default to soft crop
	 * @param bool $single - (optional) returns an array if false
	 * @uses wp_upload_dir()
	 * @uses image_resize_dimensions()
	 * @uses image_resize()
	 *
	 * @return str|array
	 */
	public function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {
		
		//validate inputs
		if(!$url OR !$width ) return false;
		
		//define upload path & dir
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		
		//check if $img_url is local
		//if(strpos( $url, home_url() ) === false) return false;
		if(strpos( $url, $upload_url ) === false) return false;
		
		//define path of image
		$rel_path = str_replace( $upload_url, '', $url);
		$img_path = $upload_dir . $rel_path;
		
		//check if img path exists, and is an image indeed
		if( !file_exists($img_path) OR !getimagesize($img_path) ) return false;
		
		//get image info
		$info = pathinfo($img_path);
		$ext = $info['extension'];
		list($orig_w,$orig_h) = getimagesize($img_path);
		
		//get image size after cropping
		$dims = image_resize_dimensions($orig_w, $orig_h, $width, $height, $crop);
		$dst_w = $dims[4];
		$dst_h = $dims[5];
		
		//use this to check if cropped image already exists, so we can return that instead
		$suffix = "{$dst_w}x{$dst_h}";

		$dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
		$destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";
		
		//if orig size is smaller
		if($width >= $orig_w) {
			
			if(!$dst_h) :
				//can't resize, so return original url
				$img_url = $url;
			$dst_w = $orig_w;
			$dst_h = $orig_h;
			
			else :
				//else check if cache exists
				if(file_exists($destfilename) && getimagesize($destfilename)) {
					$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
				} 
			//else resize and return the new resized image url
				else {
					$resized_img_path = $this->image_resize( $img_path, $width, $height, $crop );
					$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
					$img_url = $upload_url . $resized_rel_path;
					
				}
			
			endif;
			
		}
		//else check if cache exists
		elseif(file_exists($destfilename) && getimagesize($destfilename)) {
			$img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
		} 
		//else, we resize the image and return the new resized image url
		else {
			$resized_img_path = $this->image_resize( $img_path, $width, $height, $crop );
			$resized_rel_path = str_replace( $upload_dir, '', $resized_img_path);
			$img_url = $upload_url . $resized_rel_path;
		}
		
		//return the output
		if($single) {
			//str return
			$image = $img_url;
		} else {
			//array return
			$image = array (
							0 => $img_url,
							1 => $dst_w,
							2 => $dst_h
							);
		}
		
		$this->bwMode = false;
		return $image;
	}

	public function resize($url,$w,$h = null) {
		return $this->aq_resize($url,$w,$h,true,false);
	}

	public function resizedImg($url,$w,$h = null) {
		if (!$url) return;
		$result = $this->resize($url,$w,$h);
		if (!$result) return;
		list($url,$w,$h) = $result;

		return apply_filters("pe_theme_resized_img","<img alt=\"\" width=\"$w\" height=\"$h\" src=\"$url\"/>",$url,$w,$h);
	}

	public function resizedImgUrl($url,$w,$h = null) {
		return $this->aq_resize($url,$w,$h,true,true);
	}

	public function bw($url) {
		if(!$url) return "";
		
		//define upload path & dir
		$upload_info = wp_upload_dir();
		$upload_dir = $upload_info['basedir'];
		$upload_url = $upload_info['baseurl'];
		
		//check if $img_url is local
		if(strpos( $url, home_url() ) === false) return $url;
		
		//define path of image
		$rel_path = str_replace( $upload_url, '', $url);
		$img_path = $upload_dir . $rel_path;
		
		//check if img path exists, and is an image indeed
		if( !file_exists($img_path) OR !getimagesize($img_path) ) return "";
		
		//get image info
		$info = pathinfo($img_path);
		$ext = $info['extension'];

		$dst_rel_path = str_replace( '.'.$ext, '', $rel_path);
		$destfilename = "{$upload_dir}{$dst_rel_path}-bw.jpg";

		if (file_exists($destfilename) && getimagesize($destfilename)) {
			$url = "{$upload_url}{$dst_rel_path}-bw.jpg";
		} else {
			try {
				if (@$this->makeBWimage($img_path,$destfilename)) {
					$url = "{$upload_url}{$dst_rel_path}-bw.jpg";
				}
			} catch(Exception $e) {
			}
		}

		return $url;
	}



}

?>