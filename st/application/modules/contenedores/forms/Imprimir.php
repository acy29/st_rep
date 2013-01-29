<?php

class Contenedores_Form_Imprimir extends Zend_Form
{

    public function init()
    {

		$this->setAction('/st_rep/st/public/contenedores/listar/imprimir')->setMethod('GET');
		$this->setAttrib('target', '_blank');

		$group = new Zend_Form_Element_hidden('CodEnvio');
		$this->addElement($group);

		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Imprimir');	 
	}

}

