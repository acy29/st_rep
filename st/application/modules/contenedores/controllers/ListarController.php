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
        $CodEnvio=$_GET["CodEnvio"];
        $db = Zend_Db_Table::getDefaultAdapter();  

        $select = $db->select()
                    ->from('vw_Envios')
                    ->where('CodEnvio = ?', $CodEnvio);
        $rows = $select->query()->fetchAll();

        echo'<table style="
    font-size: small;"><tr><th>Destino</th><td>'.$rows[0]["NombreCentroDestino"].'</td></tr>';
        echo'<tr><th>Envio</th><td>'.$rows[0]["CodEnvio"].'</td></tr>';
        echo'<tr><th>Numero de Guia</th><td>'.$rows[0]["NoGuia"].'</td></tr>';
        echo'<tr><th>Transporte</th><td>'.$rows[0]["NombreTransporte"].'</td></tr>';
        echo'<tr><th>Creado por</th><td>'.$rows[0]["Login"].'</td></tr>';
        echo'<tr><th>Fecha</th><td>'.$rows[0]["CodEnvio"].'</td></tr>';
        echo '</table>';

        $stmt = $db->query("SELECT     DAY(vw_EnviosPaquetes.Fecha) AS DAY, MONTH(vw_EnviosPaquetes.Fecha) AS month, YEAR(vw_EnviosPaquetes.Fecha) AS year, vw_Ordenes.CodOrden, 
                      vw_Ordenes.NombreCentro, vw_Ordenes.OrdenExterna, vw_Ordenes.NombreModelo, vw_Ordenes.Serial1, vw_Ordenes.NombreMarca, StatusOS.NombreStatus, 
                      vw_Ordenes.Serial2Salida, vw_Ordenes.Serial1Salida, vw_Ordenes.Serial2, vw_EnviosPaquetes.CodEnvio, vw_EnviosPaquetes.NombreCentro AS Expr1, 
                      vw_EnviosPaquetes.Fecha, vw_EnviosPaquetes.NombreCentroDestino, Paquetes_Ordenes.Login, vw_Ordenes.NombreTipoDevolucion, 
                      dbo.fn_OSAccesoriosString(vw_Ordenes.CodOrden) AS accesorios, dbo.fn_OSReparacionesString(vw_Ordenes.CodOrden) AS reparacion
                    FROM         vw_Ordenes INNER JOIN
                                          Paquetes_Ordenes ON vw_Ordenes.CodOrden = Paquetes_Ordenes.CodOrden INNER JOIN
                                          StatusOS ON vw_Ordenes.CodStatus = StatusOS.CodStatus INNER JOIN
                                          vw_EnviosPaquetes ON Paquetes_Ordenes.CodPaquete = vw_EnviosPaquetes.CodPaquete
                    WHERE     (vw_EnviosPaquetes.CodEnvio =".$CodEnvio.")");
        $Ordenes=$stmt->fetchAll();
        echo '<table style="font-size: 75%;"><tr width="7px"><th>Orden</th><th>Orden Externa</th><th>Marca</th><th>Modelo</th><th>Status</th><th>Observaciones</th><th>Reparacion</th><th>Serial Decimal</th><th>Serial Hexadecimal</th><th>Serial de Salida</th><th>Accesorio</th></tr>';
        foreach ($Ordenes as $orden) {
            echo '<tr><td>'.$orden['CodOrden'].'</td><td>'.$orden['OrdenExterna'].'</td><td>'.$orden['NombreMarca'].'</td><td>'.$orden['NombreModelo'].'</td><td>'.$orden['NombreStatus'].'</td><td>Observacion</td><td>'.$orden['reparacion'].'</td><td>'.$orden['Serial1'].'</td><td>'.$orden['Serial2'].'</td>';
            if(isset($orden['Serial1Salida'])){
                echo '<td>'.$orden['Serial1Salida'].'</td>';
            }else{
                echo '<td>'.$orden['Serial1'].'</td>';
            }
            echo '<td>'.$orden['accesorios'].'</td></tr>';
        }
        echo '</table>';
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