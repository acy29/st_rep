<?php

class Login_Form_Login extends Zend_Form
{

    public function init()
    {
        $this->setMethod('post')->setAction('authenticate');
 
        $this->addElement(
            'text', 'username', array(
                'label' => 'Usuario:',
                'required' => true,
                'filters'    => array('StringTrim'),
            ));
 
        $this->addElement('password', 'password', array(
            'label' => 'Contracena:',
            'required' => true,
            ));
 
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Autenticar',
            ));
 
    }


}

