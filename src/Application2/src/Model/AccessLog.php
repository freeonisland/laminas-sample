<?php

namespace Application\Model;

class AccessLog //extends \ArrayObject
{
    protected $id;   //@int
    protected $user; //@string
    protected $date; //@date

    public function __get(string $name) 
    {
        if (isset($this->name)) {
            return $this->name;
        }
    }

    public function __set(string $name, $value): void
    {
        $this->name = $value;
    }

    public function exchangeArray($data) 
    {
        foreach ($data as $d => $v) {
            $this->$d = $v;
        }
    }
}