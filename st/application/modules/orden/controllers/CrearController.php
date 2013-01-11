<?php

class Orden_CrearController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form = new Orden_Form_Crear();
      	echo $form;  
    }

	public function guardarAction()
    {
       	$this->_forward('index','crear');
	   	$form = new Orden_Form_Crear();
		if ($form->isValid($_POST)) {
			$values = $form->getValues(); //*** obtengo los valores
			/*unset($values['module']);
			unset($values['controller']);
			unset($values['action']);
			unset($values['submit']);*/
			//$params=array($values['guia'],$values['centro'],$values['cliente'],$values['modelo'],$values['color'],$values['serial'],$values['fecha_compra'],$values['orden_externa'],$values['fecha_orden_externa']);
			$params=array('guia'=>'3',
				'centro'=>'1',
				'cliente'=>'171',
				'modelo'=>'500',
				'color'=>'22',
				'serial'=>'0112480000313546',
				'fecha_compra'=>'2013',
				'orden_externa'=>'666',
				'fecha_orden_externa'=>'2013');
			$orden = new Orden_Model_Orden();
			$id = $orden->Sp_InsertarOS($params	);//*** guardo los registros  
			print_r($id);
			//$this->view->mensaje =  "\"Orden ".$id." creada satisfactoriamente\""; 
			$this->_forward('index');
		}else {}
			//$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\"";   
    }
}

