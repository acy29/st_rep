<?php

class Contenedores_Model_Contenedor
{
	public function getByCodDestino($codDestino) {
		$contenedores = new Zend_Db_Table('Contenedores');
        $rows = $contenedores->fetchAll(
                $contenedores->select()->where("CodDestino = ?",$codDestino)
        )->toArray();
        return $rows;
	}

	public function getEmpty() {
		$contenedores = new Zend_Db_Table('Contenedores');
        $rows = $contenedores->fetchAll(
                $contenedores->select()->where("CodDestino is Null")
        )->toArray();
        return $rows;
	}

	public function SetCodDestino($codDestino,$CodContenedor) {

		$contenedores = new Zend_Db_Table('Contenedores');
        $data = array(
		   'codDestino' => $codDestino
		);
		$where = array(
		    'CodContenedor = ?' => $CodContenedor
		);
		$contenedores->update($data, $where);
	}

	public function CreatePaquete($CodContenedor) {
		//buscamos el contenedor
		$contenedores = new Zend_Db_Table('Contenedores');
        $rows = $contenedores->fetchAll(
                $contenedores->select()->where("codContenedor = ?",$CodContenedor)
        )->toArray();
        $rows=$rows[0];
		//creamos el paquete
		$db = Zend_Db_Table::getDefaultAdapter();  
		$stmt = $db->query("If Exists (Select CodPaquete from Paquetes Where CodCentro=160 And CodCentroDestino=".$rows["CodDestino"]." And Tipo=1 And Status=1)
							begin
								Raiserror ('Ya existe un paquete destinado al centro de servicio seleccionado', 16, 1)
								return
							end
							else
								Insert Into Paquetes (CodCentro, CodCentroDestino, Tipo, Login, Fecha, Status, Recibido)
								Values (160, ".$rows["CodDestino"].", 1, 'ROSA.JAIMES', GetDate(), 1, 0)
							");
		$stmt2=$db->query("select @@IDENTITY as id");
		$paqueteId= $stmt2->fetch();  
		$paqueteId=$paqueteId["id"];

		//exec sp_InsertPaquete @CodCentroOrigen=160,@CodCentroDestino=167,@Tipo=1,@Login='LESTER.LUGO'
	}

	public function AddOrden($CodOrden) {
		$contenedor=new Contenedores_Model_Contenedor();

		//realizamos la busqueda por codOrden
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                    ->from('vw_ordenes')
                    ->where('CodOrden = ?', $CodOrden);
        $rows = $select->query()->fetchAll();

        //verificamos la existencia de contenedores disponibles
		if(sizeof($contenedor->getByCodDestino($rows[0]["CodCentro"]))>0){
            $contenedorFinal=$contenedor->getByCodDestino($rows[0]["CodCentro"]);
        }else{
            $contenedorFinal=$contenedor->getEmpty();
            $this->SetCodDestino($rows[0]["CodCentro"],$contenedorFinal[0]["CodContenedor"]);
        }

		$contenedores = new Zend_Db_Table('Contenedores_Ordenes');
		$rows = $contenedores->fetchAll(
                $contenedores->select()->where("CodOrden = ?",$CodOrden)
        )->toArray();
        if(sizeof($rows)<1){
	        $data = array(
			   'CodContenedor' => $contenedorFinal[0]["CodContenedor"],
			   'CodOrden' => $CodOrden
			);
			$contenedores->insert($data);
			return "Orden clasificacda con exito";
		}else{
			return "Orden ya ha sido clasificada";
		}
	}

}

