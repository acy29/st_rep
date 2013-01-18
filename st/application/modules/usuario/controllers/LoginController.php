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

        $this->logoutAction();
        $loginForm = new Usuario_Form_Login();
 
        if ($loginForm->isValid($_POST)) {
 
 			//*** defino el adaptador
            $db = Zend_Db_Table::getDefaultAdapter();
            $adapter = new Zend_Auth_Adapter_DbTable(
                $db,
                'users',
                'username',
                'password'
                //'MD5(CONCAT(?, password_salt))'
                );
            //*** valido en la bd el pw y usu
            $username = $this->getRequest()->getParam('username');
            $password = $this->getRequest()->getParam('password');

            $user = new Usuario_Model_Users();
            $rol_id = $user->getRoleId($username);

            //*** autenticacion
            $adapter->setIdentity($username);
            $adapter->setCredential($password);
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);

            //*** parametros op en auth
            $data= array(
                'username' => $username,
                'id_role'  => $rol_id,
                'role'  => $user->getRole($rol_id)
            );

            //*** escribo en la sesion
            $auth->getStorage()->write($data);
            var_dump($auth->getStorage()->read());
             
            if ($result->isValid()) {
                //$this->_helper->FlashMessenger('Successful Login');
                echo "fino";
                //$this->_redirect('/');
                return;
            }else{
            	echo "error";
                $this->_redirect('/');
            }
 
        }
 
    
    }

    public function logoutAction()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $auth = Zend_Auth::getInstance();

        $auth->clearIdentity();
        //$this->_redirect('/');
    }

}



