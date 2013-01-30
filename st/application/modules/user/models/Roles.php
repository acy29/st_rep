<?php
/**
 * Login_Model_Roles
 *  
 * @author Enrico Zimuel (enrico@zimuel.it)
 */
class Login_Model_Roles extends Zend_Db_Table_Abstract
{
    protected $_name = 'roles';
    protected $_primary = 'id';
    protected $_dependentTables = array('Users','Permissions');
    /**
     * getRoles
     * 
     * @return object
     */
    public function getRoles() {
    	return $this->fetchAll(null,'id');
    }
    /**
     * getParentRole
     *
     * @param integer $role
     * @return integer|boolean
     */
    public function getParentRole($role) {
        $select= $this->select('id_parent')
                      ->from(array('r'=>'roles'))
                      ->where('r.id=?',$role);
        $record= $this->fetchRow($select);
        if (!empty($record['id_parent'])) {
            return $record['id_parent'];
        }
        return false;
    }

    public function getRole($role) {
        $select= $this->select('*')
                      ->from(array('r'=>'roles'))
                      ->where('r.id=?',$role);
        $record= $this->fetchRow($select);
        if (!empty($record)) {
            return $record;
        }
        return false;
    }

    public function getMensajeRole($role) {
        $select= $this->select('mensaje')
                      ->from(array('r'=>'roles'))
                      ->where('r.id=?',$role);
        $record= $this->fetchRow($select);
        if (!empty($record['mensaje'])) {
            return $record['mensaje'];
        }
        return false;
    }

    public function cambiarMsg($mensaje,$rol) {
        $this->update(array("mensaje"=>$mensaje),"id ='".$rol."'");
    }

}