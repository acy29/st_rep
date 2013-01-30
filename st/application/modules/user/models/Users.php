<?php

class User_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';
    protected $_primary = 'username';

    public function getRoleId($username) {

    	$result= $this->find($username);
    	if (!empty($result)) {
    		return $result[0]['id_role'];
    	}

    }

    public function getRole($rol_id){

        $db = new Zend_Db_Table("roles");
        $result = $db->fetchAll($db->select()->where("id = ?",intval($rol_id)))->toArray();

        if (!empty($result)) {
            return $result[0]['role'];
        }

    }

    public function cambiarPass($password,$username) {
        $this->update(array("password"=>$password),"username ='".$username."'");
    }


}
