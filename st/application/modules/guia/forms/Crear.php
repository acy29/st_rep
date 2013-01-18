<?php

class Guia_Form_Crear extends Zend_Form
{

    public function init()
    {	

		
    $this->setAction('/st_rep/st/public/guia/crear/guardar')->setMethod('post');

		$this->setAttrib('class', 'Guia_form');

		$centros = new Zend_Db_Table('centrosservicio');
        $rows = $centros->fetchAll(
        	$centros->select()->where("Activo=1")
        	)->toArray();
        $select= array();
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodCentro']]=$rowArray['NombreCentro'];
		}
		$group = new Zend_Form_Element_Select('origen');
		$group->setLabel('Origen');
		$group->setMultiOptions($select);
		//$group->setLabel('Origen');
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));

		$this->addElement($group);

		
		$group = new Zend_Form_Element_Text('numero');
		$this->addElement($group);
		$group->setLabel('Numero*');		
		$group->setRequired(true);
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		
		$transportes = new Zend_Db_Table('Transportes');
        $rows = $transportes->fetchAll(
        	$transportes->select()->where("Activo=1")
        	)->toArray();
        $select= array();
		foreach ($rows as $rowArray) {
			$select[$rowArray['CodTransporte']]=$rowArray['NombreTransporte'];
		}

		$group = new Zend_Form_Element_Select('transporte');
		$this->addElement($group);
		$group->setLabel('Transporte');
		$group->setMultiOptions($select);
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		
		$group = new Zend_Form_Element_Text('peso');
		$this->addElement($group);
		$group->setLabel('Peso declarado*');
		$group->setRequired(true);
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));
		
		$group = new Zend_Form_Element_Text('cantidad');
		$this->addElement($group);
		$group->setLabel('Cantidad declarada*');
		$group->setRequired(true);
		$group->setDecorators(array(
                   'ViewHelper',
                   'Description',
                   'Errors',
                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                   array('Label', array('tag' => 'td')),
                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
           ));

		$this
			->addDisplayGroup(array('origen', 'numero','transporte','peso','cantidad'), 'guia',array('legend'=>'Incluir nueva guia'));

		$this
			->guia
			->setDecorators(array(
	               'FormElements',
	               array(array('data'=>'HtmlTag'),array('tag'=>'table')),
	               //array(array('data'=>'HtmlTag'),array('tag'=>'table')),
	               //array('legend',array('tag'=>'table')),
	               'Fieldset'
	        ));
		$submit = new Zend_Form_Element_Submit('submit');
		$this->addElement($submit);
		$submit->setLabel('Actualizar');
		$submit->setDescription("*Requerido");
		$submit->setDecorators(array(
               'ViewHelper',
               'Description',
               'Errors', 
               array('Description', array('escape'=>false,'tag'=>'div','style'=> 'color:red;font-weight:bold;float:left',)),
       ));


    }

    /*public function __construct($option=null)

   {



       parent::__construct($option);

  

       $this->setMethod('post');

  

       $username=$this->CreateElement('text','username')

  

                       ->setLabel('User Name:');

  

       $username->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

           ));

  

       $password=$this->CreateElement('text','password')

  

                       ->setLabel('Password');

  

       $password->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td')),

                   array('Label', array('tag' => 'td')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

       ));

  

       $submit=$this->CreateElement('submit','submit')

  

                       ->setLabel('Login');

  

       $submit->setDecorators(array(

  

               'ViewHelper',

               'Description',

               'Errors', array(array('data'=>'HtmlTag'), array('tag' => 'td',

               'colspan'=>'2','align'=>'center')),

               array(array('row'=>'HtmlTag'),array('tag'=>'tr'))

  

       ));

  

       $this->addElements(array(

  

               $username,

               $password,

               $submit

  

       ));

  

       $this->setDecorators(array(

  

               'FormElements',

               array(array('data'=>'HtmlTag'),array('tag'=>'table')),

               'Form'

  

       ));



   }*/



}

