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
		$error=imagecreatetruecolor(200, 50);
		$white=imagecolorallocate($error, 255, 255,255);
		$red=imagecolorallocate($error, 255, 0, 0);
		//@todo implementare l'opzione dimensone diversa ad ogni immagine
		if ($_POST['type']=="frame") {// creo i frame
			
			$form=new Form_Frame();
			if ($form->isValid($_POST)) {
				imagedestroy($error);
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
				$this->view->output='true';

			}
			else {
				imagestring($error, 5, 10, 10, "error data not valid", $red);
				imagegif($error,$file);
				imagedestroy($error);
				$this->view->output='false';
			}
			/*
			 	


			*/
		}
		elseif ($_POST['type']=='scrool') {

		}
		else {//processing
			$data['frameadd']=(int)$_POST['frameadd'];
			$path.='/temp';
			if ($dp = @opendir($path)) {
				while($file = readdir($dp)) {
					if (($file!=".")&&($file!="..")&&is_file($path.'/'.$file)&&($file!="prew.gif")) {
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

