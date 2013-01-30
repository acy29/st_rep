<?php

class Zend_Controller_Action_Helper_AllViewEnvios extends Zend_Controller_Action_Helper_Abstract
{
    //*** me devuelve una json con todos los envios
    function allviewenvios()
    {
        $db = Zend_Db_Table::getDefaultAdapter();  
        $select = $db->select()
                    ->from(array('ve' => 'vw_Envios'),
                    array("NoGuia","NombreCentroDestino","CodEnvio","Fecha","NombreTransporte"));

        $rows = $select->query()->fetchAll();
        $date;
        foreach($rows as $entry) {
            $x[] = array($entry['Fecha'],$entry['CodEnvio'],$entry['NoGuia'], $entry['NombreCentroDestino'],$entry['NombreTransporte']);
        }
       // $this->view->json = json_encode(array("aaData" => $x));

        return json_encode(array("aaData" =>$x));

    }

}