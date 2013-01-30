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

    public function imprimirAction()
    {

        $this->_helper->layout->disableLayout();
        $CodEnvio=$_GET["CodEnvio"];
        echo $this->_helper->Contenedores->printContenedorOrdenes($CodEnvio);

    }

    public function paqueteAction()
    {
        $codContenedor=$_POST["codContenedor"];
        $NoGuia=$_POST["NoGuia"];
        $Observaciones=$_POST["Observaciones"];
        $Transporte=$_POST["Transporte"];
        $contenedor=new Contenedores_Model_Contenedor();
        try{
            $respuesta=$contenedor->CreatePaquete($codContenedor,$NoGuia,$Observaciones,$Transporte);
            if(is_numeric($respuesta)){
                echo 'El envio '.$respuesta.' se ha creado exitosamente, el contenedor ahora esta disponible';
                $form= new Contenedores_Form_Imprimir();
                $form->CodEnvio->setValue($respuesta);
                echo $form;
            }else{
                //ha ocurrido un error
                echo $respuesta;
            }
        }catch(Zend_Exception $e){
            echo $e->getMessage();
        }

    }

    public function allpackageAction()
    {
        $codContenedor=$_POST["codContenedor"];
        $NoGuia=$_POST["NoGuia"];
        $Observaciones=$_POST["Observaciones"];
        $Transporte=$_POST["Transporte"];
        $contenedor=new Contenedores_Model_Contenedor();
        try{
            $respuesta=$contenedor->CreatePaquete($codContenedor,$NoGuia,$Observaciones,$Transporte);
            if(is_numeric($respuesta)){
                echo 'El envio '.$respuesta.' se ha creado exitosamente, el contenedor ahora esta disponible';
                $form= new Contenedores_Form_Imprimir();
                $form->CodEnvio->setValue($respuesta);
                echo $form;
            }else{
                //ha ocurrido un error
                echo $respuesta;
            }
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