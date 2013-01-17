<?php
	
class Guia_Model_Guia
{
	public function Sp_InsertarGuia($params) {
		$db = Zend_Db_Table::getDefaultAdapter();  
		//$db = Zend_DB::factory($config->db);
		//$db = Zend_Db_Table::getDefaultAdapter()

		$spParams = $params;  

		$conn=$db->getConnection();

		$tsql_callSP = "{CALL sp_UpdateGuia( ?,".$params['CodCentro'].",160,'".$params['NoGuia']."',".$params['CodTransporte'].",".$params['Peso'].",".$params['Cantidad'].",'".$params['Login']."')}";
		echo $tsql_callSP;
		$CodGuia=0;
		$paramsql = array(
			//array($employeeId, SQLSRV_PARAM_IN),
			array($CodGuia, SQLSRV_PARAM_INOUT)
		    );
		var_dump($conn);
		/* Execute the query. */
		$stmt3 = sqlsrv_query($conn,$tsql_callSP, $paramsql);
		if( $stmt3 === false )
		{
		     echo "Error in executing statement.\n";
		     die( print_r( sqlsrv_errors(), true));
		}

		/* Display the value of the output parameter $vacationHrs. */
		sqlsrv_next_result($stmt3);
		echo "Guia>".$CodGuia;

		/*Free the statement and connection resources. */
		//sqlsrv_free_stmt( $stmt3);
		//sqlsrv_close( $conn);		  
	}

}

