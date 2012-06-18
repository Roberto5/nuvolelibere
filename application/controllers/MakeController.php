<?php
require_once 'include/GIFEncoder.class.php';
class MakeController extends Zend_Controller_Action
{

	public function init()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
	}

	public function indexAction()
	{
		$auth=Zend_Auth::getInstance();
		if ($auth->hasIdentity()) $user=$auth->getIdentity()->id;
		else $user=Model_guest::getgid();
		$path=APPLICATION_PATH.'/../upload/'.$user;
		//@todo implementare l'opzione dimensone diversa ad ogni immagine
		if ($_POST['type']=="frame") {// creo i frame
			$form=new Form_Frame();
			if ($form->isValid($_POST)) {
				//rimuovere le vecchie immagini!!
				if ($dp = @opendir($path.'/temp')) {
					while($file = readdir($dp)) {
						if (($file!=".")&&($file!="..")&&is_file($path.'/temp/'.$file)) {
							unlink($path.'/temp/'.$file);
						}
					}
				}
				$data=$form->getValues();
				$vw=array();
				$vh=array();
				//$thumb=new Plugin_thumb(array('path'=>$path,'prop'=>$data['prop'],'w'=>$data['x'],'h'=>$data['y']));
				include_once 'include/thumb/phpthumb.class.php';
				$thumb=new phpthumb();
				include_once 'include/thumb/phpThumb.config.php';
				$PHPTHUMB_CONFIG['cache_directory'] = $path;
				foreach ($data['name'] as $i=>$fileimg) {
					$thumb->iar=$data['prop']!="true";
					$thumb->w=$data['x'];
					$thumb->h=$data['y'];
					$thumb->src=$path.'/'.$fileimg;
					if ($data['dimT']!="true") {
						$thumb->far='x'.$data['posx'][$i].'y'.$data['posy'][$i];
						$thumb->w=$data['dimx'][$i];
						$thumb->h=$data['dimy'][$i];
					}
					else $thumb->far='T';
					$thumb->f='gif';
					$thumb->GenerateThumbnail();
					$delay=$data['delayTot']=="true" ? $data['delayT'] : $data['delay'][$i];
					$thumb->RenderToFile($path."/temp/($delay)file$i.gif");
					/*/$img=$thumb->get($fileimg);
					 ob_start();
					 imagegif($thumb->gdimg_output);
					 //imagedestroy($img);
					 ob_end_clean();*/
					$thumb->resetObject();
				}
				$this->view->output=true;

			}
			else {
				$this->view->output=false;
				$this->view->text=$form->getErrorMessages();
			}
		}
		elseif ($_POST['type']=='scrool') { //scrool
			$form=new Form_Scroll();
			if ($form->isValid($_POST)) {
				//rimuovere le vecchie immagini!!
				if ($dp = @opendir($path.'/temp')) {
					while($file = readdir($dp)) {
						if (($file!=".")&&($file!="..")&&is_file($path.'/temp/'.$file)) {
							unlink($path.'/temp/'.$file);
						}
					}
				}
				$data=$form->getValues();
				
				include_once 'include/thumb/phpthumb.class.php';
				$thumb=new phpthumb();
				include_once 'include/thumb/phpThumb.config.php';
				$PHPTHUMB_CONFIG['cache_directory'] = $path;
				$thumb->iar=$data['prop']!="true";
				$thumb->w=$data['x'];
				$thumb->h=$data['y'];
				$thumb->src=$path.'/'.$data['name'];
				$thumb->f='gif';
				$thumb->far='T';$bool=true;
				$thumb->GenerateThumbnail();
				$thumb->RenderToFile($path.'/temp/base.gif');
				$src=imagecreatefromgif($path.'/temp/base.gif');
				$data['x']=imagesx($src);
				$data['y']=imagesy($src);
				//unlink($path.'/temp/base.gif');
				$coord=new Model_function('SimpleScrool',$data);
				$delay=$data['delay'];
				
				for ($i = 0; $i < $data['nframe']; $i++) {
					$img=imagecreatetruecolor($data['fx'], $data['fy']);
					$c=$coord->get($i);
					imagecopy($img, $src, 0, 0, $c['x'], $c['y'], $data['fx'], $data['fy']);
					$b=imagegif($img,$path."/temp/($delay)file$i.gif");
					imagedestroy($img);
				}
				if ($data['fb']=='true') {
					for ($t = $i-2; $i < $data['nframe']*2-2; $i++,$t--) {
						$img=imagecreatetruecolor($data['fx'], $data['fy']);
						$c=$coord->get($t);
						imagecopy($img, $src, 0, 0, $c['x'], $c['y'], $data['fx'], $data['fy']);
						imagegif($img,$path."/temp/($delay)file$i.gif");
						imagedestroy($img);
					}
				}
				$this->view->text=array($data,$coord->scaley);
				$this->view->output=$bool;
			}
			else {
				$this->view->output=false;
				$this->view->text=$form->getErrors();
			}
		}
		else {//processing
			$data['frameadd']=(int)$_POST['frameadd'];
			$path.='/temp';
			if ($dp = @opendir($path)) {
				while($file = readdir($dp)) {
					if (($file!=".")&&($file!="..")&&is_file($path.'/'.$file)&&($file!="prew.gif")&&(preg_match("/\(\d+\)file\d+\.gif/", $file))) {
						preg_match("/file\d+/", $file,$index);
						$index=str_replace("file","",$index[0]);
						$frames[$index]=$path.'/'.$file;
						preg_match("/\(\d+\)/", $file,$delay);
						$delay=str_replace("(", "", $delay[0]);
						$delay=str_replace(")", "", $delay);
						$framed[]=intval($delay); // Delay in the animation.
					}
					
				}
				$gif = new GIFEncoder($frames,$framed,0,$data['frameadd'],0,0,0,'url');
				$fp=fopen($path.'/prew.gif', "w");
				fwrite($fp, $gif->GetAnimation());
				fclose($fp);
			}
			else $this->_log->notice("cartella ".$path.'inesistente');
		}

	}

}

