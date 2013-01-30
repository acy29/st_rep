<?php

class Zend_Controller_Action_Helper_Contenedores extends Zend_Controller_Action_Helper_Abstract
{
    function printContenedores(){
    	$contenedor = new Zend_Db_Table('Contenedores');
        $rows = $contenedor->fetchAll($contenedor->select()
               ->from(array('c'=>'Contenedores'),array('c.CodContenedor','c.NombreContenedor','c.CodDestino'))
               ->join(array('co'=>'Contenedores_Ordenes'),'co.CodContenedor=c.CodContenedor',
                array())
               ->group(array('c.CodContenedor','c.NombreContenedor','c.CodDestino'))
               )->toArray();
        echo "<ol id='selectable'>";

        $centros = new Zend_Db_Table('CentrosServicio');
        foreach ($rows as $contenedor) {
            $centro = $centros->fetchAll($centros->select()->where("CodCentro = ?",$contenedor["CodDestino"]))->toArray();
        	echo "<li class='ui-state-default'><a class='peque_link' href='listar/details?CodContenedor=".$contenedor["CodContenedor"]."'>".$contenedor["NombreContenedor"]."<br><p class='peque'>".$centro[0]["NombreCentro"]."</p></a></li>";
        }
        echo "</ol>";
    }

    function printContenedoresDetails($codContenedor){
    	$centros = new Zend_Db_Table('Contenedores');
        $contenedor = $centros->fetchAll(
        	$centros->select()->where("codContenedor=?",$codContenedor)
        )->toArray();
        echo "<h2>Contenedor ".$contenedor[0]["NombreContenedor"]."</h2>";
    }


    function printContenedorOrdenes($CodEnvio){

        $db = Zend_Db_Table::getDefaultAdapter();  

        $select = $db->select()
                    ->from('vw_Envios')
                    ->where('CodEnvio = ?', $CodEnvio);
        $rows = $select->query()->fetchAll();

        $cont_envio = '<table style="font-size: small;"><tr><th>Destino</th><td>'.$rows[0]["NombreCentroDestino"].'</td></tr>';
        $cont_envio .= '<tr><th>Envio</th><td>'.$rows[0]["CodEnvio"].'</td></tr>';
        $cont_envio .= '<tr><th>Numero de Guia</th><td>'.$rows[0]["NoGuia"].'</td></tr>';
        $cont_envio .= '<tr><th>Transporte</th><td>'.$rows[0]["NombreTransporte"].'</td></tr>';
        $cont_envio .= '<tr><th>Creado por</th><td>'.$rows[0]["Login"].'</td></tr>';
        $cont_envio .= '<tr><th>Fecha</th><td>'.$rows[0]["CodEnvio"].'</td></tr>';
        $cont_envio .=  '</table>';

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

        $cont_envio .=  '<table style="font-size: 75%;"><tr width="7px"><th>Orden</th><th>Orden Externa</th><th>Marca</th><th>Modelo</th><th>Status</th><th>Observaciones</th><th>Reparacion</th><th>Serial Decimal</th><th>Serial Hexadecimal</th><th>Serial de Salida</th><th>Accesorio</th></tr>';
        foreach ($Ordenes as $orden) {
            $cont_envio .=  '<tr><td>'.$orden['CodOrden'].'</td><td>'.$orden['OrdenExterna'].'</td><td>'.$orden['NombreMarca'].'</td><td>'.$orden['NombreModelo'].'</td><td>'.$orden['NombreStatus'].'</td><td>Observacion</td><td>'.$orden['reparacion'].'</td><td>'.$orden['Serial1'].'</td><td>'.$orden['Serial2'].'</td>';
            if(isset($orden['Serial1Salida'])){
                $cont_envio .=  '<td>'.$orden['Serial1Salida'].'</td>';
            }else{
                $cont_envio .=  '<td>'.$orden['Serial1'].'</td>';
            }
            $cont_envio .=  '<td>'.$orden['accesorios'].'</td></tr>';
        }
        $cont_envio .=  '</table>';
        return $cont_envio;

    }

}
?>