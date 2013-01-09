<?php

class Orden_Form_Crear extends Zend_Form
{

    public function init()
    {
		$this->setAction('/Ordenes/CrearOrden')->setMethod('post');

		$this->setAttrib('class', 'Orden_form');

		$group = new Zend_Form_Element_Select('origen');
		$this->addElement($group);
		$group->setLabel('Origen');
		
		$group = new Zend_Form_Element_Select('operadora');
		$this->addElement($group);
		$group->setLabel('Operadora');
		
		$group = new Zend_Form_Element_Text('cliente');
		$this->addElement($group);
		$group->setLabel('Cliente');		

		$this->addDisplayGroup(array('origen', 'operadora','cliente'), 'groups', array("legend" => "Datos Iniciales"));

		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Save');
		$this->submit->setValue("Save");
    }


}

