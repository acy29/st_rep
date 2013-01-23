<?php

class Orden_CrearController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */

        $contextSwitch = $this->_helper->getHelper('AjaxContext');
        $contextSwitch->addActionContext('newfield', 'html')
                      ->initContext();

        /*$this->view->addHelperPath('Zend/Dojo/View/Helper', 'Zend_Dojo_View_Helper');
        $this->view->dojo()->setLocalPath('../js/dojo/dojo.js')
			->addStyleSheetModule('dijit.themes.tundra');
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer() ;
		$viewRenderer->setView($this->view) ;
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
		
		echo $this->view->dojo();

        /*$this->view->headScript()->appendFile('../js/dojo/dojo.js');
        $this->view->headScript()->appendFile('../js/dojo/parser.js');
        $this->view->headScript()->appendFile('../js/dijit/form/FilteringSelect.js');
        */
    }

	public function newfieldAction() {

		$this->_helper->layout->disableLayout(); 
    	$this->_helper->viewRenderer->setNoRender(TRUE);
    	//echo $this->_getParam('id', null);
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
		$ajaxContext->addActionContext('newfield', 'html')->initContext();

		$id = $this->_getParam('id', null);

		$element = new Zend_Form_Element_TextArea("newName$id");
		$element->setRequired(true)->setLabel('NameAjax');
		//echo $element->__toString();
		$this->view->field = $element->__toString();
		echo $this->view->field;
	}

    public function testAction(){
    	//$this->view->headScript()->appendFile('../../js/jquery.tools.min.js');
    	$form = new Orden_Form_Test();
    	// Form has not been submitted - pass to view and return
    	echo !$this->getRequest()->isPost();
	    if (!$this->getRequest()->isPost()) {
	      $this->view->form = $form;
	      return;
	    }else{
	    }
	     // Form has been submitted - run data through preValidation()
	    $form->preValidation($_POST);

	     // If the form doesn't validate, pass to view and return
	    if (!$form->isValid($_POST)) {
	      $this->view->form = $form;
	      return;
	    }
	     // Form is valid
	    $this->view->form = $form;
    }

    public function tecnologiaAction()
    {
        $centros = new Zend_Db_Table('tecnologias');
        $marca = $this->_getParam('CodMarca');

        $rows = $centros->fetchAll(
				$centros->select()->from(array("t" => "tecnologias"), array("t.CodTecnologia","t.NombreTecnologia"))
                                 ->join(array('mt' => "marcas_tecnologias"),"t.CodTecnologia = mt.CodTecnologia",array())
                                 ->where("t.CodTecnologia in (select mt.CodTecnologia from marcas_tecnologias where mt.CodMarca=$marca)")
                                 ->order('t.NombreTecnologia asc')
        	)->toArray();
        $select= array();
        $index=0;
		foreach ($rows as $rowArray) {
			$select[$index]['name']=$rowArray['CodTecnologia'];
			$select[$index]['label']=$rowArray['CodTecnologia'];
			$index++;
		}
		//$this->_helper->json(array("label"=>"label","identifier"=>"value","items"=>$select));
		$data = new Zend_Dojo_Data('name', $select);

	    $this->_helper->autoCompleteDojo($data);
    }

    //[{"value":1,"label":"CDMA"},{"value":2,"label":"GSM"}]
    //[{value: "aaa", label: "aaa"},{value: "bbb", label: "bbb"}]

    public function indexAction()
    {
        $form = new Orden_Form_Crear();
        /*$this->view->addHeadScript('dojo.require("dijit.form.FilteringSelect");
			dojo.require("dojo.parser");
			dojo.require("dojo.data.ItemFileReadStore");
			dojo.addOnLoad(function () {
				secondSelect=dijit.byId("tecnologia");
				var myStore=new dojo.data.ItemFileReadStore({url:"crear/tecnologia?CodMarca=" + dojo.byId("marca").value });
				aSecondFilteringCache=Array();
	            var gotList = function(items, request) {
		            aSecondFilteringCache[thisValue]=myStore;
		            secondSelect.store=myStore;
		            secondSelect.setValue(items[0].id);
		        }
			});');*/

		/*'dojo.addOnLoad(function () {

			dijit.byId("tecnologia").store = new dojo.data.ItemFileReadStore({url: "crear/tecnologia?CodMarca=" + dojo.byId("marca").value});

			dojo.connect(dijit.byId("marca"), "onChange", function (val) {
				dijit.byId("tecnologia").query.property_1 = val || "*";
			});
		});'*/


        //echo $this->view->headScript();

        /*echo '<script>dojo.addOnLoad(function () {
			    dojo.connect(dijit.byId("marca"), "onChange", function () {
			        dijit.byId("tecnologia").store = new dojo.data.ItemFileReadStore(
			            { url: "crear/tecnologia?CodMarca=" + dijit.byId("marca").value }
			        );
			    });
			});</script>';*/
      	echo $form;  

		//$this->view->adddecorator();
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

