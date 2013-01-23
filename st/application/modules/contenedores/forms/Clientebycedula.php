<?php

class Orden_Form_Clientebycedula extends Zend_Form
{

    public function init()
    {
        $form = new Zend_Form();

        $group = new Zend_Form_Element_Hidden('cliente');
		$form->addElement($group);

		echo $form;
    }


}

