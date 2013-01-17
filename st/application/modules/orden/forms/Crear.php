<?php

class Orden_Form_Test extends Zend_Dojo_Form
{

    public function init()
    {
		// Dojo-enable the form:
        Zend_Dojo::enableForm($this);

		$this->setAction('/st_rep/st/public/orden/crear/guardar')->setMethod('post');

		$this->setAttrib('class', 'Orden_this');

		$centros = new Zend_Db_Table('centrosservicio');
        $rows = $centros->fetchAll(
        	$centros->select()->where("Activo=1")->where("Externo=0")->order('NombreCentro')
        	)->toArray();
        $select= array();
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodCentro']]=$rowArray['NombreCentro'];
		}
		$group = new Zend_Form_Element_Select('origen');
		$group->setLabel('Origen');
		$group->setMultiOptions($select);
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		

		$operadoras = new Zend_Db_Table('operadoras');
        $rows = $operadoras->fetchAll(
        	$operadoras->select()->order('NombreOperadora')
        	)->toArray();
        $select= array();
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodOperadora']]=$rowArray['NombreOperadora'];
		}
		$group = new Zend_Form_Element_Select('operadora');
		$group->setMultiOptions($select);
		$group->setLabel('Operadora');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('cliente');
		$group->setLabel('Cliente');	
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);

		$this->addDisplayGroup(array('origen', 'operadora','cliente'), 'datosi', array("legend" => "Datos Iniciales"));

		$this
			->datosi
			->setDecorators(array(
	               'FormElements',
	               array(array('data'=>'HtmlTag'),array('tag'=>'table')),
	               //array(array('data'=>'HtmlTag'),array('tag'=>'table')),
	               //array('legend',array('tag'=>'table')),
	               'Fieldset'
	        ));

		$marcas = new Zend_Db_Table('marcas');
        $rows = $marcas->fetchAll(
        	$marcas->select()->order('NombreMarca')
        	)->toArray();
        $select= array();
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodMarca']]=$rowArray['CodMarca'];
		}

		$group = new Zend_Dojo_Form_Element_ComboBox('marca');
		$group->setLabel('Marca');
		$group->setMultiOptions($select);
		/*$group->setAttrib('onchange','
			dojo.require("dijit.form.FilteringSelect");
			dojo.require("dojo.parser");
			dojo.require("dojo.data.ItemFileReadStore");
			dojo.xhrGet({
				url: "crear/tecnologia",
				content: { CodMarca:marca.value } ,
				load: function(data, ioArgs) {
					console.warn(data);
				},
				error: function(data,ioArgs) {
					console.warn("error");
				}
            });');*/	
		$group->setDecorators(array(
                   'DijitElement',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Dojo_Form_Element_FilteringSelect('tecnologia');
		$group->setLabel('Tecnologia');
		$group->setAutocomplete(true)
		    ->setRequired(true);
		//$group->setAttrib('store','{"identifier":"CodTecnologia","items":[{"CodTecnologia":1,"NombreTecnologia":"CDMA"},{"CodTecnologia":2,"NombreTecnologia":"GSM"}],"label":"NombreTecnologia"}');
		//$group->setAttrib('dojoType','dijit.form.FilteringSelect');
		$group->setStoreId('suburbsStore');
		$group->setStoreType('dojo.data.ItemFileReadStore');
		$group->setStoreParams(array('url' =>"crear/tecnologia" ));
		$group->setDijitParam('searchAttr', 'name');
		$group->setDecorators(array(
                   'DijitElement',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		/*$group->setAttrib('onLoad','dojo.addOnLoad(function () {

			dijit.byId("tecnologia").store = new dojo.data.ItemFileReadStore({url: "crear/tecnologia?CodMarca=" + dojo.byId("marca").value});
				dojo.connect(dijit.byId("marca"), "onChange", function (val) {
					dijit.byId("tecnologia").query.CodTenoclogia = val || "*";
				});

			});');*/
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Select('modelo');
		$group->setLabel('Modelo');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Select('color');
		$group->setLabel('Color');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('orden_externa');
		$group->setLabel('Orden Externa');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('fecha_orden_externa');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Select('tipo_ingreso');
		$group->setLabel('Tipo de Ingreso');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('imei1');
		$group->setLabel('Serial 1');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('imei2');
		$group->setLabel('Serial 2');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('imei3');
		$group->setLabel('Serial 3');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('imei4');
		$group->setLabel('Serial 4');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('imei5');
		$group->setLabel('Serial 5');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);

		//$this->addDisplayGroup(array('imei1', 'imei2','imei3','imei4', 'imei5'), 'seriales', array("legend" => "Seriales"));
		
		$group = new Zend_Form_Element_Text('sintoma');
		$group->setLabel('Sintoma');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('condiciones');
		$group->setLabel('Condiciones');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('garantia');
		$group->setLabel('Garantia');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);

		$datosequipo=$this->addDisplayGroup(array('marca', 'tecnologia','modelo','color', 'orden_externa','fecha_orden_externa'
		,'tipo_ingreso','sintoma', 'condiciones','garantia','seriales','imei1', 'imei2','imei3','imei4', 'imei5'), 'datosequip', array("legend" => "Datos del Equipo"));		

		$this
			->datosequip
			->setDecorators(array(
	               'FormElements',
	               array(array('data'=>'HtmlTag'),array('tag'=>'table')),
	               //array(array('data'=>'HtmlTag'),array('tag'=>'table')),
	               //array('legend',array('tag'=>'table')),
	               'Fieldset'
	        ));
		
		$group = new Zend_Form_Element_Checkbox('taller_externo');
		$group->setLabel('El equipo proviene de un taller externo');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$marcas = new Zend_Db_Table('centrosservicio');
        $rows = $marcas->fetchAll(
        	$marcas->select()->where('Externo=1')->order('NombreCentro')
        	)->toArray();
        $select= array();
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodCentro']]=$rowArray['NombreCentro'];
		}

		$group = new Zend_Form_Element_Select('talleres');
		$group->setMultiOptions($select);
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Checkbox('solo_accesorios');
		$group->setLabel('Orden de solo accesorios');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);
		
		$group = new Zend_Form_Element_Text('imprimir_etiqueta');
		$group->setLabel('Imprimir etiqueta');		
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		$this->addElement($group);

		$this->addDisplayGroup(array('taller_externo', 'talleres','solo_accesorios','imprimir_etiqueta'), 'acc', array("legend" => "Accesorios Asociados"));
		
		$this
			->acc
			->setDecorators(array(
	               'FormElements',
	               array(array('data'=>'HtmlTag'),array('tag'=>'table')),
	               'Fieldset'
	        ));
		//$this->addDecorator(array('div' => 'HtmlTag'), array('tag' => 'div', 'class' => 'accesorios'));
		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Registrar Orden');
		$this->submit->setValue("Registrar Orden");	 
		/*$this->setAttrib('onLoad','dojo.addOnLoad(function () {
			dijit.byId("tecnologia").store = new dojo.data.ItemFileReadStore({url: "crear/tecnologia?CodMarca=" + dojo.byId("marca").value});
				dojo.connect(dijit.byId("marca"), "onChange", function (val) {
					dijit.byId("tecnologia").query.property_1 = val || "*";
				});
			});');*/
	}
}

