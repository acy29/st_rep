<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

  protected function _initAutoloaders() {

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Orden','basePath'  => APPLICATION_PATH . '/modules/orden'
          ));

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Usuario','basePath'  => APPLICATION_PATH . '/modules/usuario'
          ));

  }

  protected function _initViewHelpers() { 
       $this->bootstrap('layout');     
       
      $layout = $this->getResource('layout'); 
       $view = $layout->getView(); 
       $view->doctype('XHTML1_STRICT'); 
       $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8'); 
       
       $view->headTitle('SI'); 
      
       //$view->headLink()->setStylesheet('../css/jquery.toastmessage.css');
	   //$view->headLink()->setStylesheet('../css/estilo.css');       
       
    	 $view->headScript()->appendFile('../js/jquery.tools.min.js');
    	 $view->headScript()->appendFile('../js/jquery.dataTables.min.js');
    }
  
}

