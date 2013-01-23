<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

  protected function _initAutoloaders() {

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Orden','basePath'  => APPLICATION_PATH . '/modules/orden'
          ));

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Usuario','basePath'  => APPLICATION_PATH . '/modules/usuario'
          ));

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Acl','basePath'  => APPLICATION_PATH . '/modules/acl'
          ));

         $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Contenedores','basePath'  => APPLICATION_PATH . '/modules/contenedores'
          ));

  }

  protected function _initViewHelpers() { 
      $this->bootstrap('layout');     
       
      $layout = $this->getResource('layout'); 
      $view = $layout->getView(); 
      $view->doctype('XHTML1_STRICT'); 
      $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8'); 

      $view->headTitle('Inusual'); 

      $view->headLink(array('rel'  => 'favicon','href' => '/img/favicon.ico',), 'PREPEND')
            ->appendStylesheet('/st_rep/st/public/css/estilo.css')
            ->prependStylesheet( '/st_rep/st/public/css/ui-lightness/jquery-ui-1.9.2.custom.min.css', 'screen',true,array('id' => 'my_stylesheet'));
            

    	 //$view->headScript()->appendFile('/st_rep/st/public/js/jquery.tools.min.js');
       $view->headScript()->appendFile('/st_rep/st/public/js/jquery.min.js');
    	 //$view->headScript()->appendFile('/st_rep/st/public/js/jquery.dataTables.min.js');
       $view->headScript()->appendFile('/st_rep/st/public/js/jquery-ui-1.9.2.custom.min.js');

       //***helper_cliente cliente buscar
       $view->headScript()->appendFile('/st_rep/st/public/js/clientebuscar.js');
       
    }
  

  protected function _initHelperPath(){

         Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH .'/controllers/helpers');
      }

  protected function _initAutoload() {

         require_once 'Zend/Loader/Autoloader.php';

         $loader = Zend_Loader_Autoloader::getInstance();
         $loader->setFallbackAutoloader(true);
         
     }
   
  protected function _initViewResources() {

         Zend_Layout::startMvc();
     }

  protected function _initResourceLoader(){

    $loader = $this->getResourceLoader();
    $loader->addResourceType('helper', 'helpers', 'Helper');
    $loader->addResourceType('widget', 'widgets', 'Widget');

    return $loader;
    }

}

