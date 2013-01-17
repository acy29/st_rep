<?php

class Guia_CrearController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        

        $centros = new Zend_Db_Table('centrosservicio');
        $rows = $centros->fetchAll();
        //echo($centros->findById(171));

		/*$rows = $centros->fetchAll(
    		$centros->select('NombreCentro','CodCentro')
		        ->order('CodCentro ASC')
	        );*/

		$form = new Guia_Form_Crear();
		echo $form;
        //print_r($rows->toArray());
      	//echo $result;
    }

    public function guardarAction()
    {
       	$this->_forward('index','crear');
	   	$form = new Guia_Form_Crear();
		if ($form->isValid($_POST)) {
			echo '!?';
			$values = $form->getValues(); //*** obtengo los valores
			//print_r($values);
			$params=array(
				'CodCentro'=>$values['origen'],
				'NoGuia'=>$values['numero'],
				'CodTransporte'=>$values['transporte'],
				'Peso'=>$values['peso'],
				'Cantidad'=>$values['cantidad'],
				'Login'=>'ROSA.JAIMES',
				'CodGuia'=>0);

			$orden = new Guia_Model_Guia();
			$id = $orden->Sp_InsertarGuia($params);//*** guardo los registros  
			//print_r($id);
			//$this->view->mensaje =  "\"Orden ".$id." creada satisfactoriamente\""; 
			$this->_forward('index');
		}else {
			$this->_forward('index');
		}
			//$this->view->mensaje =  "\"A Ocurrido un error; cliente no encontrado\"";   
    }


}

