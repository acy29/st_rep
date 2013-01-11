<?php

class Usuario_LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         $form = new Usuario_Form_Login();
      	 echo $form;  
    }

    public function loginAction()
    {


    	$db = Zend_Db_Table::getDefaultAdapter();


 		//$stmt = $db->query("select * from users");


 
        $loginForm = new Usuario_Form_Login();
 
        if ($loginForm->isValid($_POST)) {
 
 			//*** defino el adaptador
            $adapter = new Zend_Auth_Adapter_DbTable(
                $db,
                'users',
                'username',
                'password'
                //'MD5(CONCAT(?, password_salt))'
                );
 
            $adapter->setIdentity($loginForm->getValue('username'));
            $adapter->setCredential($loginForm->getValue('password'));
 
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
 
            if ($result->isValid()) {
                //$this->_helper->FlashMessenger('Successful Login');
                echo "fino";
                //$this->_redirect('/');
                return;
            }else{
            	echo "error";
            }
 
        }
 
        $this->view->loginForm = $loginForm;
 
    
    }


}



