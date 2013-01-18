<?php

class Core_Model_Centrosservicio
{

	protected $_NombreCentro;
    protected $_CodCentro;
 
    public function __construct(array $options = null)
    {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }
 
    public function __set($name, $value)
    {
        $method = 'set' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Centrosservicio property');
        }
        $this->$method($value);
    }
 
    public function __get($name)
    {
        $method = 'get' . $name;
        if (('mapper' == $name) || !method_exists($this, $method)) {
            throw new Exception('Invalid Centrosservicio property');
        }
        return $this->$method();
    }
 
    public function setOptions(array $options)
    {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            }
        }
        return $this;
    }

    public function setNombreCentro($NombreCentro)
    {
        $this->_NombreCentro = (string) $NombreCentro;
        return $this;
    }
 
    public function getNombreCentro()
    {
        return $this->_NombreCentro;
    }

    public function setCodCentro($CodCentro)
    {
        $this->_CodCentro = (string) $CodCentro;
        return $this;
    }
 
    public function getCodCentro()
    {
        return $this->_CodCentro;
    }
}

