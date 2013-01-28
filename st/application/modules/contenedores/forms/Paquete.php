<?php

class Contenedores_Form_Paquete extends Zend_Form
{

    public function init()
    {
		// Dojo-enable the form:
		Zend_Dojo::enableForm($this);

		$this->setAction('/st_rep/st/public/contenedores/listar/paquete')->setMethod('post');

		$this->setAttrib('id', 'set_form');

		$group = new Zend_Form_Element_hidden('codContenedor');
		$this->addElement($group);
		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Crear Paquete');	 
	}

}

