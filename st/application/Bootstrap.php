<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

  protected function _initAutoloaders() {

          $test_loader = new Zend_Application_Module_Autoloader( array(   'namespace' => 'Modulo1',
                                                                              'basePath'  => APPLICATION_PATH . '/modules/modulo1'
          ));

  }
  
}

