<?php

namespace Application\Model\Fixture;

use Application\Table\AbstractTable;

abstract class AbstractFixture
{
    protected $table;
    protected $adapter;

    private $rows = 10;
    

    function __construct(AbstractTable $table) 
    {
        $this->table = $table;
        $this->adapter = $table->getAdapter();

        $this->insertData();
    }

    function insertData(): void
    {
        foreach (range(0, $this->rows) as $_) {
            $this->generate();
        }
    }

    protected function insertFixture(\ArrayObject $data)
    {
        $this->table->insert((array)$data);
    }

    protected abstract function generate();
}