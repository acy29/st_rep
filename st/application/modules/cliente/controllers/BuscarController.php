<?php
class Cliente_BuscarController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function clientexcedulaAction()
    {
        //*** no renderiza layout vista
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        if (isset($_GET['cedula'])){

            $clientes = $this->_helper->clientesxCedula->clientesxCedula($_GET['cedula']);
            echo $clientes;
        }else
            $this->view->mensaje =  "\"A Ocurrido un error; POST con errores\""; 

    }

    public function existeclienteAction()
    {
        //*** no renderiza layout vista
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(TRUE);

        if (isset($_GET['cedula'])){

            $cliente =$this->buscar_clientexcedula($_GET['cedula']);
            echo $cliente;
        }else
            $this->view->mensaje =  "\"A Ocurrido un error; POST con errores\""; 
    }

    public function buscar_clientexcedula($cedula)
    {
        $db = new Zend_Db_Table("cliente");
        $cliente = $db->fetchAll($db->select()->where("documento = ?",$cedula))->toArray();
        if(isset($cliente[0]['nombre']))
            return $cliente[0]['nombre']." ".$cliente[0]['apellido'];
        else
            return "";
    }



}

