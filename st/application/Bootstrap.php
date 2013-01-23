<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

  /*
  *the modules
  */
  protected function _initAutoloaders() {

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Orden','basePath'  => APPLICATION_PATH . '/modules/orden'
          ));

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'User','basePath'  => APPLICATION_PATH . '/modules/user'
          ));

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Acl','basePath'  => APPLICATION_PATH . '/modules/acl'
          ));

          $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Login','basePath'  => APPLICATION_PATH . '/modules/login'
          ));


  }
/*
*Cargo los js css y layout
*/

  protected function _initViewHelpers() { 
      $this->bootstrap('layout');     
       
      //***layout
      $layout = $this->getResource('layout'); 
      $view = $layout->getView(); 

      $view->doctype('XHTML1_STRICT'); 
      $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8'); 
       
      $view->headTitle('SI'); 

      //*** the css here
      $view->headLink(array('rel'  => 'favicon','href' => '/img/favicon.ico',), 'PREPEND')
            ->appendStylesheet('/st_rep/st/public/css/estilo.css')
            ->prependStylesheet( '/st_rep/st/public/css/ui-lightness/jquery-ui-1.9.2.custom.min.css', 'screen',true,array('id' => 'my_stylesheet'));
            
       //*** the js here
       $view->headScript()->appendFile('/st_rep/st/public/js/jquery.tools.min.js');
       $view->headScript()->appendFile('/st_rep/st/public/js/jquery.dataTables.min.js');
       $view->headScript()->appendFile('/st_rep/st/public/js/jquery-ui-1.9.2.custom.min.js');

       $view->headScript()->appendFile('/st_rep/st/public/js/mesage/jquery.noty.js');
       $view->headScript()->appendFile('/st_rep/st/public/js/mesage/topRight.js');
       $view->headScript()->appendFile('/st_rep/st/public/js/mesage/topCenter.js');
       $view->headScript()->appendFile('/st_rep/st/public/js/mesage/default.js');
       $view->headScript()->appendFile('/st_rep/st/public/js/mesage/mesage.js');
       

       //***helper_cliente cliente buscar
       $view->headScript()->appendFile('/st_rep/st/public/js/clientebuscar.js');
       
    }
  

 /* protected function _initHelperPath(){

         Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/controllers/helpers');
      }*/

  protected function _initAutoload() {

      //*** load the preDispacher
      $front = Zend_Controller_Front::getInstance();
      $front->registerPlugin(new Zend_Controller_Plugin_CheckAccess());
    }

  
  protected function _initViewResources() {

     //Zend_Layout::startMvc();
     }

  /*
  *load Helper
  */
  protected function _initResourceLoader(){

    $loader = $this->getResourceLoader();
    $loader->addResourceType('helper', 'helpers', 'Helper');
    $loader->addResourceType('widget', 'widgets', 'Widget');

    return $loader;
    }

}

