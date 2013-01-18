<?php

class Zend_Controller_Action_Helper_ClientesxCedula extends Zend_Controller_Action_Helper_Abstract
{

    function dibujarBuscador(){
        $dialog = "<div id='clientesxcedula' title='Clientes que tienen en su ci'></div>";
        return $dialog;

    }

    //*** me devuelve una tabla con las cedulas encontradas
    function clientesxcedula($cedula)
    {
        if(is_numeric($cedula)) {

            $db = new Zend_Db_Table("cliente");
            $ci = "%".$cedula."%";
            $cliente = $db->fetchAll($db->select()->where("documento LIKE ?",$ci))->toArray();

            if(isset($cliente[0]['nombre'])){//*** me devolvio algo la consulta

                $dialog = "<div>"
                            ."<table class='display' cellspacing='0' cellpadding='3' width='100%' style='width: 0px;''>"
                            ."<thead><tr><td>Nombre</td>"
                            ."<td>Cedula</td><td></td></tr></thead><tbody>";


                $i=1;
                foreach ($cliente as $c)
                {
                    $dialog .= "<tr>"
                                ."<td>".$c['nombre']." ".$c['apellido']."</td>"
                                ."<td>".$c['documento']."</td>"
                                ."<td><a class='tabla_cliente' href='javascript:agregarcliente($i)' >Agregar</a></td>"
                              ."</tr>";
                    $i++;
                }
                $dialog .= "</tbody></table></div>";
                return $dialog;
            }else
                return "";

        }
}

}