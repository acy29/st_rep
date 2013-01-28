<?php

class Contenedores_ListarController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
    	$this->_helper->Contenedores->printContenedores();
    }

    public function paqueteAction()
    {
        $codContenedor=$_POST["codContenedor"];
        $contenedor=new Contenedores_Model_Contenedor();
        try{
            $paqueteId=$contenedor->CreatePaquete($codContenedor);
            echo "Paquete Creado con exito!";
            echo $paqueteId["id"];
        }catch(Zend_Exception $e){
            echo $e->getMessage();
        }

    }

    public function detailsAction()
    {
    	//obtenemos el id del contenedor del cual queremos ver sus detalles
    	$codContenedor=$_GET["CodContenedor"];
    	$this->_helper->Contenedores->printContenedoresDetails($codContenedor);
    	$centros = new Zend_Db_Table('Ordenes');
        $equipos = $centros->fetchAll(
        	$centros->select()
				->from(array("o" => "Ordenes"), array("o.*"))
				->join(array('ce' => "Contenedores_Ordenes"),"ce.CodOrden = o.CodOrden",array())
				->where("o.CodOrden in (select ce.CodOrden from Contenedores_Ordenes where ce.CodContenedor=$codContenedor)")
        	)->toArray();
        echo '<div id="accordion">';
        foreach ($equipos as $contenedor) {
            //realizamos la busqueda por codOrden
            $db = Zend_Db_Table::getDefaultAdapter();
            $select = $db->select()
                        ->from('vw_ordenes')
                        ->where('CodOrden = ?', $contenedor["CodOrden"]);
            $rows = $select->query()->fetchAll();
	        //buscamos los accesorios de la orden
	        $stmt = $db->query("Select dbo.fn_OSAccesoriosString (".$contenedor["CodOrden"].") as accesorios");
       		$accesorios=$stmt->fetch(); 	
        	//imprimimos la orden consultada

            echo '<h3>Cod Orden '.$rows[0]['CodOrden'].'</h3>';
            echo '<div><p>';
        	$this->_helper->PrintOrdenes->printOrdenes($rows[0],$accesorios["accesorios"]);
            echo '</p></div>';
        }
        echo '</div>';
        $form = new Contenedores_Form_Paquete();
        $form->codContenedor->setValue($codContenedor);
        echo $form; 
    }

}