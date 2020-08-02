<?php

namespace Event\Event;

use Laminas\EventManager\{Event};

/**
 * When a data is inserted in the Database
 */
class CreateDataEvent extends Event
{
    const NAME = 'CreateDataEvent';

    protected $lastInsertId;

    public function getName()
    {
        return self::NAME;
    }

    public function setLastInsertId(int $lastInsertId)
    {
        $this->lastInsertId = $lastInsertId;
    }

    public function getLastInsertId()
    {
        return $this->lastInsertId;
    }
}