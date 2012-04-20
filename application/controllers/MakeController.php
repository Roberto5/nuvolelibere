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
		if ($_POST['type']=="frame") {
			$file=$path.'/prew.gif';
			$form=new Form_Frame();
			if ($form->isValid($_POST)) {
				imagedestroy($error);
				$data=$form->getValues();
				$vw=array();
				$vh=array();
				$thumb=new Plugin_thumb(array('path'=>$path,'prop'=>$data['prop'],'w'=>$data['x'],'h'=>$data['y']));
				foreach ($data['name'] as $i=>$fileimg) {
					$img=$thumb->get($fileimg);
					ob_start();
					imagegif($img);
					imagedestroy($img);
					$frames[]=ob_get_contents();
					$framed[]=$data['delayTot']=="true" ? $data['delayT'] : $data['delay'][$i]; // Delay in the animation.
					ob_end_clean();
				}
				$gif = new GIFEncoder($frames,$framed,0,$data['frameadd'],0,0,0,'bin');
				$fp=fopen($file, "w");
				fwrite($fp, $gif->GetAnimation());
				fclose($fp);
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
		else {

		}

	}

}

