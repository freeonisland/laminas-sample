<?php

namespace Application\Model;

/**
 * @link https://docs.laminas.dev/laminas-db/sql-ddl/#currently-supported-data-types
 */
class Model extends \ArrayObject
{
    /**
     * @var integer {autoincrement}
     */
    protected $id_model;  
     
    /**
     * @var text
     */
    protected $country; 

    /**
     * @var floating
     */
    protected $price; 

    /**
     * @var text
     */
    protected $json; 

    /**
     * @var date 
     */
    protected $date; 

    public function __get(string $name) 
    {
        if ($this->offsetGet($name)) {
            return $this->offsetSet($name);
        }
    }

    public function __set(string $name, $value): void
    {
        // call setNAME() before
        $method = "set".ucfirst($name);
        if (method_exists($this, $method)) {
            $this->{$method}($value);
        } else {
            $this->offsetSet($name, $value);
        }
    }

    public function setDate(string $value = null)
    {
        if (null === $value) {
            $value = date("Y/m/d H:i:s");
        } 
        $this->offsetSet('date', $value);
    }
}