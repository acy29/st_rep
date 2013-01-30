<?php

class Login_LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function loginAction()
    {
        $form = new Login_Form_Login();
      	echo $form;  
        //$this->_helper->layout()->disableLayout();
    }

    public function authenticateAction()
    {

        $this->_helper->viewRenderer->setNoRender(TRUE);
        $auth = Zend_Auth::getInstance();
        $auth->clearIdentity();

        $loginForm = new Login_Form_Login();
 
        if ($loginForm->isValid($_POST)) {
 
 			//*** define the adapter
            $db = Zend_Db_Table::getDefaultAdapter();
            $adapter = new Zend_Auth_Adapter_DbTable(
                $db,
                'Usuarios',
                'Login',
                'Pwd'
                //'MD5(CONCAT(?, password_salt))'
                );
            //*** valid in bd the pw and usu
            $username = $this->getRequest()->getParam('username');
            $password = $this->getRequest()->getParam('password');

            $user = new Login_Model_Users();
            //$rol_id = $user->getRoleId($username);

            //*** autenticacion
            $adapter->setIdentity($username);
            $adapter->setCredential($password);
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);

            if ($result->isValid()) {
                $this->view->msj_notification = "autenticaci&#243;n exitosa!";
                echo "exito la autenticacion";

                //*** param op in auth
                $data= array(
                    'username' => $username,
                    //'id_role'  => $rol_id,
                    //'role'  => $user->getRole($rol_id)
                );

                //*** write in secion
                $auth->getStorage()->write($data);
               // $this->_redirect('index/white');
            }else{
                $this->view->msj_error =  "fallo la autenticacion";
                $this->_redirect('login/login/login');
            }
 
        }
    }

    public function logoutAction()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $auth = Zend_Auth::getInstance();

        $auth->clearIdentity();
        $this->view->mesage = "fallo la autenticacion";
        $this->_redirect('login/login/login');
    }

}



