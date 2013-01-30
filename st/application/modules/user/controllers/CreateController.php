<?php

class User_CreateController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
         $form = new User_Form_Create();
      	 echo $form;  
    }

    public function postAction()
    {
         $form = new User_Form_Create();
      	 echo $form;  
    }

}



