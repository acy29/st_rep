<?php
class Zend_View_Helper_HiUser extends Zend_View_Helper_Abstract
{

	/*
	*build 'Hola. 'usuario' '
	*/
	public function HiUser(){
		$auth =  Zend_Auth::getInstance();
		$hi = "";
		if ($auth->hasIdentity()) {
			$user= $auth->getStorage()->read();
	    	$hi = "<p class='username_login'>Hola <span style='color:#9F2'>". $user['username']."</span></p>";
	    }
	        return $hi;
	 }
}
 
 
?>