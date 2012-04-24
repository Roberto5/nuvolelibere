<?php
class Plugin_thumb {
	private $w=150;
	private $h=150;
	private $prop=true;
	private $path;
	private $frameprop=false;
	function __construct($config) {
		$this->path=APPLICATION_PATH.'/../upload';
		if (is_array($config)) {
			foreach ($config as $key => $value) {
				$this->$key=$value;
			}
		}
		elseif (is_string($config)) $this->path.='/'.$config;
	}
	function  set($config) {
		if (is_array($config)) {
			foreach ($config as $key => $value) {
				$this->$key=$value;
			}
		}
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
				imagejpeg($thumb,$this->path."/thumb".$file,90);
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
		$wf=$w=$this->w;
		$hf=$h=$this->h;
		$size=getimagesize($this->path."/".$file);
		if ($this->prop=='true') {
			$ratio=$size[0]/$size[1];
			if ($ratio>1) $h=intval($w/$ratio);
			else $w=intval($h*$ratio);
		}
		if ($this->frameprop) {
			$wf=$w;
			$hf=$h;
		}
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
		//$img=new Imagick();
		//$img->resizeimage($columns, $rows, $filter, $blur)
		$thumb = imagecreatetruecolor($wf, $hf);
		$black=imagecolorallocate($thumb, 0, 0, 0);
		imagecolortransparent($thumb,$black);
		imagecopyresampled($thumb, $image, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
		//imagecopyresized($thumb, $image, 0, 0, 0, 0, $w, $h, $size[0], $size[1]);
		imagedestroy($image);
		//imageantialias($thumb, true);
		
		return $thumb;
	}
}
?>