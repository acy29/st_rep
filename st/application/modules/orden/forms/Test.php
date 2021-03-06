<?php
	class Orden_Form_Test extends Zend_Form
	{
	public function init() {
       
       	$this->setMethod('post');
	    $this->addElement('hidden', 'id', array(
	      'value' => 1
	    ));
	   
	    $this->addElement('text', 'name', array(
	      'required' => true,
	      'label'    => 'Name',
	      'order'    => 2,
	    ));
	   
	    $this->addElement('button', 'addElement', array(
	      'label' => 'Add',
	      'order' => 91
	    ));
	   
	    $this->addElement('button', 'removeElement', array(
	      'label' => 'Remove',
	      'order' => 92
	    ));
	   
	    // Submit
	    $this->addElement('submit', 'submit', array(
	      'label' => 'Submit',
	      'order' => 93
	    ));
	}
 
  /**
   * After post, pre validation hook
   *
   * Finds all fields where name includes 'newName' and uses addNewField to add
   * them to the form object
   *
   * @param array $data $_GET or $_POST
   */
  public function preValidation(array $data) {
  	var_dump($data);
 
    // array_filter callback
    function findFields($field) {
      // return field names that include 'newName'
      if (strpos($field, 'newName') !== false) {
        return $field;
      }
    }
   
    // Search $data for dynamically added fields using findFields callback
    $newFields = array_filter(array_keys($data), 'findFields');
   var_dump($newFields);

    foreach ($newFields as $fieldName) {
      // strip the id number off of the field name and use it to set new order
      $order = ltrim($fieldName, 'newName') + 2;
      $this->addNewField($fieldName, $data[$fieldName], $order);
    }
  }
 
  /**
   * Adds new fields to form
   *
   * @param string $name
   * @param string $value
   * @param int    $order
   */
  public function addNewField($name, $value, $order) {
   
    $this->addElement('textarea', $name, array(
      'required'       => true,
      'label'          => 'Name',
      'value'          => $value,
      'order'          => $order
    ));
  }
	}
?>