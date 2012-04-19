<?php
/**
 * guest
 * 
 * @author pagliaccio
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_guest extends Zend_Db_Table_Abstract {
	static $gid;
	static function getgid() {
		return self::$gid ? self::$gid : self::$gid=md5($_SERVER['HTTP_USER_AGENT'].$_SERVER['REMOTE_ADDR']);
	}

}