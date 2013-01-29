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

	public function CreatePaquete($CodContenedor,$NoGuia,$Observaciones,$Transporte) {
		//buscamos el contenedor
		$contenedores = new Zend_Db_Table('Contenedores');
		try{
	        $rows = $contenedores->fetchAll(
	                $contenedores->select()->where("codContenedor = ?",$CodContenedor)
	        )->toArray();
	        $rows=$rows[0];
			//creamos el paquete y valimos que no exista un paquete abierto con el mismo destino
			$db = Zend_Db_Table::getDefaultAdapter();  
			$db->beginTransaction();
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
			$CodPaquete= $stmt2->fetch();  
			$CodPaquete=$CodPaquete["id"];
	    	
	    	//asociamos las ordenes con los paquetes
	    	$centros = new Zend_Db_Table('Ordenes');
	        $ordenes = $centros->fetchAll(
		    	$centros->select()
					->from(array("o" => "Ordenes"), array("o.*"))
					->where("o.CodOrden in (select ce.CodOrden from Contenedores_Ordenes ce where ce.CodContenedor=".$CodContenedor.")")
		    	)->toArray();
	        $paquetes_Equipos = new Zend_Db_Table('Paquetes_Equipos');
	        foreach ($ordenes as $orden) {
	        	$data = array('CodPaquete'=>$CodPaquete,
				           'CodEquipo'=>$orden['CodEquipo'],
				           'Login'=>'ROSA.JAIMES',
				           'Recibido'=>0,
				           'CodAlmacen'=>3,
				           'CodStatus'=>12,);
				$paquetes_Equipos->insert($data);
	        }
	        //creamos el envio
	        $sql="declare @p1 int;EXECUTE sp_InsertEnvio @p1 output,160,".$rows["CodDestino"].",'ROSA.JAIMES' ";
			$stmt3 = $db->query($sql);
			$stmt4=$db->query("select @@IDENTITY as id");
			$CodEnvio= $stmt4->fetch();  
			$CodEnvio=$CodEnvio["id"];

			//asociamos los paquete con el envio
			$stmt5 = $db->query("exec sp_InsertEnvioPaquete ".$CodEnvio.",".$CodPaquete);

			// actualizamos el envio con numero de guia y el tipo de transporte
			$stmt6 = $db->query("exec sp_UpdateEnvio ".$CodEnvio.",".$Transporte.",".$NoGuia.",".$Observaciones.",'ROSA.JAIMES'");

			//limpiamos el contenedor de ordenes
			$contenedores = new Zend_Db_Table('Contenedores_Ordenes');
	        $ordenes = $contenedores->delete("CodContenedor=".$CodContenedor);

	        //limpiamos el destino del contenedor
	        $contenedores = new Zend_Db_Table('Contenedores');
	        $data = array(
			   'codDestino' => NULL
			);
			$where = array(
			    'CodContenedor = ?' => $CodContenedor
			);
			$contenedores->update($data, $where);

			$db->commit();
			return $CodEnvio;
		}catch(Zend_Exception $e){
			//en caso de error, regresos los cambios
			$db->rollBack();
            return $e->getMessage();
        }
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

