<?php

class Core_Model_CentrosservicioMapper
{
	
	protected $_dbTable;
 
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
 
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Core_Model_DbTable_Centrosservicio');
        }
        return $this->_dbTable;
    }
 
    public function save(Core_Model_Centrosservicio $centrosservicio)
    {
        $data = array(
            'email'   => $centrosservicio->getEmail(),
            'comment' => $centrosservicio->getComment(),
            'created' => date('Y-m-d H:i:s'),
        );
 
        if (null === ($id = $centrosservicio->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }
    }
 
    public function find($id, Core_Model_Centrosservicio $centrosservicio)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
        $centrosservicio->setId($row->id)
                  ->setEmail($row->email)
                  ->setComment($row->comment)
                  ->setCreated($row->created);
    }
 
    public function fetchAll()
    {
    	return $this->getDbTable()->fetchAll();
        /*$resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Core_Model_Centrosservicio();
            $entry->setId($row->id)
                  ->setEmail($row->email)
                  ->setComment($row->comment)
                  ->setCreated($row->created);
            $entries[] = $entry;
        }
        return $entries;*/
    }

}

