<?php
class Plugin_thumb {
	private $w=150;
	private $h=150;
	private $prop=true;
	private $path;
	function __construct($config) {
		$this->path=APPLICATION_PATH.'/../upload';
		if (is_array($config)) {
			foreach ($config as $key => $value) {
				$this->$key=$value;
			}
		}
		elseif (is_string($config)) $this->path.='/'.$config;
	}
	/**
	 * create a file thumb
	 * @param String $file
	 */
	function create($file) {
		$thumb=$this->get($file);
		$type=strtolower(strrchr($file, '.'));
		switch ($type) {
			case '.jpeg':
			case '.jpg':
				imagejpeg($thumb,$this->path."/thumb".$file);
			break;
			case '.gif':
				imagegif($thumb,$this->path."/thumb".$file);
			break;
			case '.png':
				imagepng($thumb,$this->path."/thumb".$file);
			break;
			default:
				Zend_Registry::get('log')->err('image extension wrong '.$type);
				return null;
			break;
		}
	}
	/**
	 * get a img
	 * @param String $file
	 * @return resource image
	 */
	function get($file) {
		$size=getimagesize($this->path."/".$file);
		$ratio=$size[0]/$size[1];
		$w=$this->w;
		$h=$this->h;
		if ($ratio>1) $h=intval($w/$ratio);
		else $w=intval($h*$ratio);
		
		$type=strtolower(strrchr($file, '.'));
		switch ($type) {
			case '.jpeg':
			case '.jpg':
				$image=imagecreatefromjpeg($this->path."/".$file);
			break;
			case '.gif':
				$image=imagecreatefromgif($this->path."/".$file);
			break;
			case '.png':
				$image=imagecreatefrompng($this->path."/".$file);
			break;
			default:
				Zend_Registry::get('log')->err('image extension wrong '.$type);
				return null;
			break;
		}
		$thumb = imagecreatetruecolor($w, $h);
		imagecopyresized($thumb, $image, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
		imagedestroy($image);
		return $thumb;
	}
}
?>