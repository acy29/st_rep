<?php

class User_Form_Create extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post')->setAction('create/post');
 
        $this->addElement(
            'text', 'username', array(
                'label' => 'Usuario:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));
 
        $this->addElement('password', 'password', array(
            'label' => 'Contraceña:',
            'required' => true,
            ));
 
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Crear',
            ));
 
    }


}