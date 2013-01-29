<?php
	class Contenedores_Form_CrearPaquete extends Zend_Form
	{
  	public function init() {
         // Dojo-enable the form:
      Zend_Dojo::enableForm($this);

      $this->setAction('/st_rep/st/public/contenedores/index/post')->setMethod('post');

      $this->setAttrib('id', 'set_form');
      
      $group = new Zend_Form_Element_hidden('codOrden');
      $group->setDecorators(array(
                     'ViewHelper',
                     'Description',
                     'Errors',
                     array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                     array('Label', array('tag' => 'td')),
                     array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
             ));
      $this->addElement($group);
  	}
	}
?>