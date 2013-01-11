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


		$link = new Zend_Tag_Cloud(array(
		    'tags' => array(
		        array('title' => 'Buscar Clientes', 'weight' => 500, 'params' => array('url' => '/tag/code')),
		        array('title' => 'Zend Framework', 'weight' => 10, 'params' => array('url' => '/tag/zend-framework')),
		    )
		));
 
		// Render the cloud
		echo $link;

		 $this->addDecorator(array('div' => 'HtmlTag'), array('tag' => 'div', 'class' => 'accesorios'));

		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Save');
		$this->submit->setValue("Save");

}
}

