<?php

class Orden_Form_Crear extends Zend_Form
{

    public function init()
    {
		$this->setAction('/st_rep/st/public/orden/crear/guardar')->setMethod('post');

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

		$this->addDisplayGroup(array('origen', 'operadora','cliente'), 'datosi', array("legend" => "Datos Iniciales"));
		
		$group = new Zend_Form_Element_Select('marca');
		$this->addElement($group);
		$group->setLabel('Marca');
		
		$group = new Zend_Form_Element_Select('tecnologia');
		$this->addElement($group);
		$group->setLabel('Tecnologia');
		
		$group = new Zend_Form_Element_Select('modelo');
		$this->addElement($group);
		$group->setLabel('Modelo');
		
		$group = new Zend_Form_Element_Select('color');
		$this->addElement($group);
		$group->setLabel('Color');
		
		$group = new Zend_Form_Element_Text('orden_externa');
		$this->addElement($group);
		$group->setLabel('Orden Externa');
		
		$group = new Zend_Form_Element_Text('fecha_orden_externa');
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Select('tipo_ingreso');
		$this->addElement($group);
		$group->setLabel('Tipo de Ingreso');
		
		$group = new Zend_Form_Element_Text('imei1');
		$this->addElement($group);
		$group->setLabel('Serial 1');
		
		$group = new Zend_Form_Element_Text('imei2');
		$this->addElement($group);
		$group->setLabel('Serial 2');
		
		$group = new Zend_Form_Element_Text('imei3');
		$this->addElement($group);
		$group->setLabel('Serial 3');
		
		$group = new Zend_Form_Element_Text('imei4');
		$this->addElement($group);
		$group->setLabel('Serial 4');
		
		$group = new Zend_Form_Element_Text('imei5');
		$this->addElement($group);
		$group->setLabel('Serial 5');

		//$this->addDisplayGroup(array('imei1', 'imei2','imei3','imei4', 'imei5'), 'seriales', array("legend" => "Seriales"));
		
		$group = new Zend_Form_Element_Text('sintoma');
		$this->addElement($group);
		$group->setLabel('Sintoma');
		
		$group = new Zend_Form_Element_Text('condiciones');
		$this->addElement($group);
		$group->setLabel('Condiciones');
		
		$group = new Zend_Form_Element_Text('garantia');
		$this->addElement($group);
		$group->setLabel('Garantia');

		$datosequipo=$this->addDisplayGroup(array('marca', 'tecnologia','modelo','color', 'orden_externa','fecha_orden_externa'
		,'tipo_ingreso','sintoma', 'condiciones','garantia','seriales','imei1', 'imei2','imei3','imei4', 'imei5'), 'datosequip', array("legend" => "Datos del Equipo"));		
		
		$group = new Zend_Form_Element_Checkbox('taller_externo');
		$this->addElement($group);
		$group->setLabel('El equipo proviene de un taller externo');
		
		$group = new Zend_Form_Element_Select('talleres');
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Checkbox('solo_accesorios');
		$this->addElement($group);
		$group->setLabel('Orden de solo accesorios');
		
		$group = new Zend_Form_Element_Text('imprimir_etiqueta');
		$this->addElement($group);
		$group->setLabel('Imprimir etiqueta');		

		$this->addDisplayGroup(array('taller_externo', 'talleres','solo_accesorios','imprimir_etiqueta'), 'acc', array("legend" => "Accesorios Asociados"));
		
		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Registrar Orden');
		$this->submit->setValue("Registrar Orden");	 


		/*$link = new Zend_Tag_Cloud(array(
		    'tags' => array(
		        array('title' => 'Buscar Clientes', 'weight' => 500, 'params' => array('url' => '/tag/code')),
		        array('title' => 'Zend Framework', 'weight' => 10, 'params' => array('url' => '/tag/zend-framework')),
		    )
		));
 
		// Render the cloud
		echo $link;

		 $this->addDecorator(array('div' => 'HtmlTag'), array('tag' => 'div', 'class' => 'accesorios'));*/
	}
}

