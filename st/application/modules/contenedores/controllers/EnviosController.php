<?php

class Contenedores_EnviosController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        
    }

    public function jsonAction()
    {
        $this->_helper->layout->disableLayout();
        echo $this->_helper->AllViewEnvios->allviewenvios();
    }


}







