<?php

class Contenedores_IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
		$form = new Contenedores_Form_Agregar();
      	echo $form; 
    }

    public function searchAction()
    {
        //pintamos el formulario    
        $form = new Contenedores_Form_Agregar();
        echo $form; 

        //obtenemos el parametro de busqueda
    	$search=$_POST["search"];

        //realizamos la busqueda ya sea por codOrden o por Serial1
    	$db = Zend_Db_Table::getDefaultAdapter();
        try{
            $select = $db->select()
                        ->from('vw_ordenes')
                        ->where('CodOrden = ?', $search);
            $rows = $select->query()->fetchAll();
            if( sizeof($rows)<1){
                $select = $db->select()
                            ->from('vw_ordenes')
                            ->where("Serial1 =?",$search);
                $rows = $select->query()->fetchAll();
                if( sizeof($rows)<1){
                    return;
                }else{
                $search=$rows[0]["CodOrden"];
            }
            }else{
                $search=$rows[0]["CodOrden"];
            }
        }catch (Zend_Exception $e) {
            $select = $db->select()
                        ->from('vw_ordenes')
                        ->where("Serial1 =?",$search);
            $rows = $select->query()->fetchAll();
            if( sizeof($rows)<1){

                return;
            }else{
                $search=$rows[0]["CodOrden"];
            }
        }

        //buscamos los accesorios de la orden
        $stmt = $db->query("Select dbo.fn_OSAccesoriosString ($search) as accesorios");
        $accesorios=$stmt->fetch();  

        //imprimimos la orden consultada
        $this->_helper->PrintOrdenes->printOrdenes($rows[0],$accesorios["accesorios"]);
        $contenedor=new Contenedores_Model_Contenedor();
        if(sizeof($contenedor->getByCodDestino($rows[0]["CodCentro"]))>0){
            $contenedorFinal=$contenedor->getByCodDestino($rows[0]["CodCentro"]);
            $this->view->msj_confirm= "Coloque la orden en el contenedor ".$contenedorFinal[0]["CodContenedor"];
            $form = new Contenedores_Form_CrearPaquete();
            echo $form; 
        }else{
            $contenedorFinal=$contenedor->getEmpty();
            if(sizeof($contenedorFinal)<1){
                $this->view->msj_error_op= "No hay contenedores disponibles, vacie uno e intente de nuevo";
            }else{
                $this->view->msj_confirm= "Coloque la orden en el contenedor ".$contenedorFinal[0]["CodContenedor"];
                $form = new Contenedores_Form_CrearPaquete();
                echo $form; 
            }
        }
    }

    public function postAction()
    {
        //obtenemos el parametro de busqueda
        $CodOrden=$_POST["codOrden"];

        //agregamos la orden al contenedor
        $contenedor=new Contenedores_Model_Contenedor();
        $msj_notification=$contenedor->AddOrden($CodOrden);
        $this->_redirect("contenedores/index?msj_notification=$msj_notification");
    }

}







