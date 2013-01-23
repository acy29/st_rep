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

	public function SetCodDestino($codDestino) {
		$contenedores = new Zend_Db_Table('Contenedores');
        $rows = $contenedores->fetchAll(
                $contenedores->select()->where("CodDestino is Null")
        )->toArray();
        echo $rows[0];
	}

}

