<?php

class Zend_Controller_Action_Helper_PrintOrdenes extends Zend_Controller_Action_Helper_Abstract
{
    function printOrdenes($orden,$Accesorios){
    	echo 	"<table>".
	    			"<tr>".
		    			"<td>Codigo</td><td>".$orden["CodOrden"]."</td>".
	    			"</tr>".
		    		"<tr>".
		    			"<td>Tipo</td><td>".$orden["NombreTipoEquipo"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Cliente</td><td>".$orden["CodCliente"]." ".$orden["NombreCliente"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Operadora</td><td>".$orden["NombreOperadora"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Marca</td><td>".$orden["NombreMarca"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Modelo</td><td>".$orden["NombreModelo"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Serial 1</td><td>".$orden["Serial1"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Fecha de creacion</td><td>".$orden["FechaRegistro"]->format('d-m-Y')."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Orden Externa</td><td>".$orden["OrdenExterna"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Fecha orden externa</td><td>".$orden["FechaOrdenExterna"]->format('d-m-Y')."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Fecha de compra</td><td>".$orden["FechaCompra"]->format('d-m-Y')."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Status de la orden</td><td>".$orden["NombreStatusOS"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Status del equipo</td><td>".$orden["NombreStatusEquipo"]."</td>".
	    			"</tr>".
	    			"<tr>".
		    			"<td>Accesorios</td><td>".$Accesorios."</td>".
	    			"</tr>".
    			"</table>";
    }
}
?>