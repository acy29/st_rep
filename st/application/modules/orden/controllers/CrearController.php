<?php

class Orden_CrearController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form = new Orden_Form_Crear();
      	  	echo $form;  
    }


}

