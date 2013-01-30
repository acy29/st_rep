<?php

class Contenedores_Form_Agregar extends Zend_Form
{

    public function init()
    {
		// Dojo-enable the form:
    Zend_Dojo::enableForm($this);

		$this->setAction('/st_rep/st/public/contenedores/index/search')->setMethod('post');
		
		$group = new Zend_Form_Element_Text('search');
		//$group->setRequired(true);
		$group->addValidator('NotEmpty', false, array('messages'=>'No puede ser vacio'));
		$group->setLabel('Serial o Numero de Orden');	

		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);

		$this->addDisplayGroup(array('search'), 'acc', array("legend" => "Busqueda"));
		
		$this
			->acc
			->setDecorators(array(
	               'FormElements',
	               array(array('data'=>'HtmlTag'),array('tag'=>'table')),
	               'Fieldset'
	        ));
		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Buscar');	 
	}

}

