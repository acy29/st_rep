<?php

class Usuario_Model_Usuario
{
 	protected $_name = 'users';
    protected $_primary = 'username';
    
	protected $_referenceMap    = array(
        'Role' => array(
            'columns'           => 'id_role',
            'refTableClass'     => 'Roles',
            'refColumns'        => 'id'
        ));
        
    /**
     * Check if a username is a Ldap user
     * 
     * @param string $username
     * @return boolean
     */
    public function isLdapUser($username) {
    	if (empty($username)) {
    		return false;
    	}
    	$select= $this->select()->where('username = ?', $username)
    							->where('ldap = true');
    	$result= $this->fetchRow($select);						
		return !empty($result);		
    }
    /**
     * Get the role Id of a user
     * 
     * @param string $username
     * @return integer|boolean
     */
    public function getRoleId($username) {
    	if (empty($username)) {
    		return false;
    	}
    	$result= $this->find($username);
    	if (!empty($result)) {
    		return $result[0]['id_role'];
    	}
    	return false;
    }

    public function getCodSalaSituacional($username) {
    	if (empty($username)) {
    		return false;
    	}
    	$result= $this->find($username);
    	if (!empty($result)) {
    		return $result[0]['cod_salasituacional'];
    	}
    	return false;
    }

    public function getCodComando($username) {
        if (empty($username)) {
            return false;
        }
        $result= $this->find($username);
        if (!empty($result)) {
            return $result[0]['cod_comando'];
        }
        return false;
    }

    public function cambiarPass($password,$username) {
        $this->update(array("password"=>$password),"username ='".$username."'");
    }

}

