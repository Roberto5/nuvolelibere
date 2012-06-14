<?php

class RegController extends Zend_Controller_Action
{

	public function init()
	{
		/* Initialize action controller here */
	}

	public function indexAction()
	{
		$messRegisterMail=file_get_contents(APPLICATION_PATH.'/language/'.$this->_t->getLocale().'.txt');
		$site='<a href="'.URL.'">'.SITE.'</a>';
		$messRegisterMail=str_replace("{SITE}", $site, $messRegisterMail);
		$form = new Form_Register();
		$form->setAction($this->view->url(array('controller' => 'reg')).($_GET['test']?'?test=1':''));
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$this->view->send = true;
			if ($form->isValid($_POST)) {
				$this->view->type = 1;
				$this->view->text = $this->_t->_("REG_SUCC").'<br>'.$this->_t->_("CTRL_MAIL");
				$post = $form->getValues();
				$conf = Zend_Registry::get("config");
				$code = genrandpass();
				$active=($conf->email->validation ? 0 : 1 );
				//ID 	username 	user_pass 	user_mail 	user_active 	user_code 	des_user
				$messRegisterMail=str_replace("{USER}", $post['username'], $messRegisterMail);
				$messRegisterMail=str_replace("{LINK}", URL.$this->view->url(array('controller'=>'reg','action'=>'active','code'=>$code)), $messRegisterMail);
				$data = array('username' => $post['username'],
						'password' => md5($post['password']), 'email' => $post['email'],
						'active' => $active, 'code' => md5($code));
				Model_user::register($data);
				if ($_GET['test']) $this->view->text.="<div>$messRegisterMail</div>";
				if ($conf->email->active) {
					$sender = new Zend_Mail();
					$sender->addTo($post['email'])
					->setFrom(WEBMAIL, SITO)
					->setBodyHtml($messRegisterMail)
					->setBodyText($messRegisterMail)
					->setSubject($this->_t->_("Conferma E-mail di registrazione"))
					->send();
				}
			} else {
				$this->view->type = 2;
				$this->view->form->populate($_POST);
			}
		}
	}
	public function activeAction() {
		$code=$this->_getParam('code');
		$code=$code? md5($code):null;
		$user=new Model_user(0,$code);
		$this->_log->debug(print_r($user->data,true));
		if ($user->data && ($user->data->code_time+86400)<time()) {
			$auth=Zend_Auth::getInstance();
			$data=new stdClass();
			$data->uid=$user->data->uid;
			$data->username=$user->data->username;
			$auth->getStorage()->write($data);
			$this->view->text=$this->_t->_("SUC_ACTIV");
			$user->updateU(array('active'=>1,'code'=>''));
		}
		else {
			$this->view->text=$this->_t->_("ERR_ACTIV");
			$this->view->type=2;
		}
	}
	public function resendAction() {
		$messRegisterMail=file_get_contents(APPLICATION_PATH.'/language/'.$this->_t->getLocale().'.txt');
		$user=new Model_user(0,$this->_getParam('code'));
		if ($user->data) {
			$this->view->email=$user->data['email'];
			if ($this->getRequest()->isPost()) {
				$valid=new Zend_Validate_EmailAddress();
				$valid=new Zend_Validate();
				$valid->addValidator(new Zend_Validate_EmailAddress())->addValidator(new Zend_Validate_Db_NoRecordExists(array('table' => PREFIX.'user', 'field' => 'email')));
				if ($valid->isValid($_POST['email']) || $_POST['email']==$user->data['email']) {
					$code=genrandpass();
					$user->updateU(array('email'=>$_POST['email'],'code'=>md5($code)));
					$conf = Zend_Registry::get("config");$messRegisterMail=file_get_contents(APPLICATION_PATH.'/language/'.$this->_t->getLocale().'.txt');
						$site='<a href="'.URL.'">'.SITE.'</a>';
						$messRegisterMail=str_replace("{SITE}", $site, $messRegisterMail);
						$messRegisterMail=str_replace("{USER}", $user->data['username'], $messRegisterMail);
						$messRegisterMail=str_replace("{LINK}", URL.$this->view->url(array('controller'=>'reg','action'=>'active','code'=>$code)), $messRegisterMail);
						//echo $messRegisterMail;
					if ($conf->email->active) {
						$sender = new Zend_Mail();
						$sender->addTo($_POST['email'])
						->setFrom(WEBMAIL, SITO)
						->setBodyHtml($messRegisterMail)
						->setBodyText($messRegisterMail)
						->setSubject($this->_t->_("Conferma E-mail di registrazione"))
						->send();
					}
					$this->view->text=$this->_t->_("CTRL_MAIL");
					$this->view->succes=true;
				}
				else {
					$this->view->error=true;
					$this->view->text=$valid->getMessages();
				}
			}
		}
		else {
			$this->view->error=true;
			$this->view->text=$this->_t->_('ERRORE');
		}
	}
}

