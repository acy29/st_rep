<?php

class Orden_CrearController extends Zend_Controller_Action
{

    public function init()
    {

    }

	public function tecnologiaAction() {
		$this->_helper->layout->disableLayout(); 
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    	//buscamos las tecnologias asociadas al id de la marca
    	$centros = new Zend_Db_Table('tecnologias');
        $marca = $this->_getParam('CodMarca');

        $rows = $centros->fetchAll(
				$centros->select()->from(array("t" => "tecnologias"), array("t.CodTecnologia","t.NombreTecnologia"))
                                 ->join(array('mt' => "marcas_tecnologias"),"t.CodTecnologia = mt.CodTecnologia",array())
                                 ->where("t.CodTecnologia in (select mt.CodTecnologia from marcas_tecnologias where mt.CodMarca=".$this->_getParam('CodMarca', null).")")
                                 ->order('t.NombreTecnologia asc')
        	)->toArray();
        //creo el arreglo de options
        $select= array();
        $select[0]='(Seleccione una tecnologia)';
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodTecnologia']]=$rowArray['NombreTecnologia'];
		}
        //cambiamos el contexto de la funcion a AJAX
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
		$ajaxContext->addActionContext('tecnologia', 'html')->initContext();

		//creo el elemento select 'tecnologia' y lo inicializo con la lista de resultados
		$element = new Zend_Form_Element_Select("tecnologia");
		$element->setRequired(true)->setLabel('Tecnologia');
		$element->setMultiOptions($select);
		$element->setAttrib('onChange','
          ajaxModeloField();');
		$element->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));

		//devulevo el documento
		$this->view->field = $element->__toString();
		echo $this->view->field;
	}


	public function modeloAction() {
		$this->_helper->layout->disableLayout(); 
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    	//buscamos las tecnologias asociadas al id de la marca
    	$centros = new Zend_Db_Table('modelos');
        $marca = $this->_getParam('CodMarca', null);
        $tecnologia = $this->_getParam('CodTecnologia', null);

        $rows = $centros->fetchAll(
				$centros->select()->from(array("m" => "modelos"), array("m.CodModelo","m.NombreModelo"))
                                 ->where("CodMarca=".$marca)
                                 ->where("CodTecnologia=".$tecnologia)
                                 ->order('m.NombreModelo asc')
        	)->toArray();
        //creo el arreglo de options
        $select= array();
        $select[0]='(Seleccione una modelo)';
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodModelo']]=$rowArray['NombreModelo'];
		}
        //cambiamos el contexto de la funcion a AJAX
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
		$ajaxContext->addActionContext('modelo', 'html')->initContext();

		//creo el elemento select 'tecnologia' y lo inicializo con la lista de resultados
		$element = new Zend_Form_Element_Select("modelo");
		$element->setRequired(true)->setLabel('Modelo');
		$element->setMultiOptions($select);
		$element->setAttrib('onChange','
          ajaxColorField();');
		$element->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));

		//devulevo el documento
		$this->view->field = $element->__toString();
		echo $this->view->field;
	}

	public function colorAction() {
		$this->_helper->layout->disableLayout(); 
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    	//buscamos las tecnologias asociadas al id de la marca
    	$centros = new Zend_Db_Table('colores');
        $modelo = $this->_getParam('CodModelo', null);

        $rows = $centros->fetchAll(
				$centros->select()->from(array("c" => "colores"), array("c.CodColor","c.NombreColor"))
                                 ->join(array('mc' => "modelos_colores"),"c.CodColor = mc.CodColor",array())
                                 ->where("c.CodColor in (select mc.CodColor from modelos_colores where mc.CodModelo=".$this->_getParam('CodModelo', null).")")
                                 ->order('c.NombreColor asc')
        	)->toArray();
        //creo el arreglo de options
        $select= array();
        $select[0]='(Seleccione una Color)';
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodColor']]=$rowArray['NombreColor'];
		}
        //cambiamos el contexto de la funcion a AJAX
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
		$ajaxContext->addActionContext('color', 'html')->initContext();

		//creo el elemento select 'tecnologia' y lo inicializo con la lista de resultados
		$element = new Zend_Form_Element_Select("color");
		$element->setRequired(true)->setLabel('Color');
		$element->setMultiOptions($select);
		$element->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));

		//devulevo el documento
		$this->view->field = $element->__toString();
		echo $this->view->field;
	}

    public function indexAction()
    {
        $form = new Orden_Form_Crear();
      	echo $form;  
    }

    public function postAction()
    {
    	$form = new Orden_Form_Crear();
    	if (!$this->getRequest()->isPost()) {
	      $this->view->form = $form;
	      echo $this->view->form;
	      return;
	    }else{
	    }
	     // Form has been submitted - run data through preValidation()
	    //var_dump($_POST);
	    $form->preValidation($_POST);
	     // If the form doesn't validate, pass to view and return
	    if (!$form->isValid($_POST)) {
	      $this->view->form = $form;
	      echo $this->view->form;  
	      return;
	    }else{
	    	$this->view->form = $form;
	    	echo $this->view->form; 
	    }

       	/*$this->_forward('index','crear');
	   	$form = new Orden_Form_Crear();
		if ($form->isValid($_POST)) {
			$values = $form->getValues(); //*** obtengo los valores
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
		*/
    }
}







