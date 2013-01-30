<?php

class Contenedores_Form_Paquete extends Zend_Form
{

    public function init()
    {
		$this->setAction('/st_rep/st/public/contenedores/listar/paquete')->setMethod('post');

		$this->setAttrib('id', 'set_form');

		$group = new Zend_Form_Element_hidden('codContenedor');
		$this->addElement($group);

		$group = new Zend_Form_Element_Text('NoGuia');
		$group->addValidator('NotEmpty', false, array('messages'=>'No puede ser vacio'));
		$group ->setLabel("Numero de Guia");
		$this->addElement($group);

		$group = new Zend_Form_Element_Text('Observaciones');
		$group->addValidator('NotEmpty', false, array('messages'=>'No puede ser vacio'));
		$group ->setLabel("Observaciones");
		$this->addElement($group);

		$transportes = new Zend_Db_Table('Transportes');
        $rows = $transportes->fetchAll(
        	$transportes->select()->order('NombreTransporte')
        	)->toArray();
        $select= array();
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodTransporte']]=$rowArray['NombreTransporte'];
		}
		$group = new Zend_Form_Element_Select('Transporte');
		$group ->setLabel("Tipo de Transporte");
		$group->setMultiOptions($select);
		$this->addElement($group);

		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Crear Paquete');	 
	}

}

