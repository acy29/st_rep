<?php

class Orden_Model_Orden
{
	public function Sp_InsertarOS($params) {
		$db = Zend_Db_Table::getDefaultAdapter();  
		$spParams = $params;  
		//$stmt = $db->query("EXEC sp_InsertarOS(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $spParams);  
		var_dump($spParams);
		//print_r($spParams);
		//$values['guia'],$values['centro'],$values['cliente'],$values['modelo'],$values['color'],$values['serial'],$values['fecha_compra'],$values['orden_externa'],$values['fecha_orden_externa']
		//echo "EXECUTE sp_InsertarOS ".$spParams['guia'].",".$spParams['centro'].",160,".$spParams['cliente'].",null,1,".$spParams['modelo'].",".$spParams['color'].",1,".$spParams['serial'].",'','','','',".$spParams['fecha_compra'].",0,0,0,0,0,null,null,0,0,'','','',0,".$spParams['orden_externa'].",".$spParams['fecha_orden_externa'].",18,'REGULAR',1,0,0,'ROSA.JAIMES' ";
		//sp_InsertarOS(3,1,160,171,null,1,500,22,1,0112480000313546,'','','','',1,0,0,0,0,0,null,null,0,0,'','','',0,666,01-01-2013,18,'REGULAR',1,0,0,'ROSA.JAIMES')

		$stmt = $db->query("DECLARE @CodOrden int;EXECUTE sp_InsertarOS @CodOrden OUTPUT,".$spParams['guia'].",".$spParams['centro'].",160,".$spParams['cliente'].",null,1,".$spParams['modelo'].",".$spParams['color'].",1,".$spParams['serial'].",'','','','','',0,0,0,0,0,null,null,0,0,'','','',0,".$spParams['orden_externa'].",'',18,'REGULAR',1,0,0,'ROSA.JAIMES' ");
		/*
		$stmt = $this->db->prepare("EXECUTE sp_InsertarOS(".$spParams['guia'].",".$spParams['centro'].",160,".$spParams['cliente'].",null,1,".$spParams['modelo'].",".$spParams['color'].",1,".$spParams['serial'].",'','','','',".$spParams['fecha_compra'].",0,0,0,0,0,null,null,0,0,'','','',0,".$spParams['orden_externa'].",".$spParams['fecha_orden_externa'].",18,'REGULAR',1,0,0,'ROSA.JAIMES');");
		$stmt = $this->db->prepare("EXECUTE usp_myproc ?, ?");
		$stmt->bindParam(1, 'mystr', PDO::PARAM_STR);
		$stmt->bindParam(2, 'mystr2', PDO::PARAM_STR);
		$rs = $stmt->execute();
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		*/
		//$stmt = $db->query("select * from crear_rol(?,?)", $spParams);  
		  
		//Fetches a row from the result set  
		return $stmt->fetch();   
		  
		//Returns an array containing all of the result set rows  
		//return $stmt->fetchAll();  
		  
	}

}
?>