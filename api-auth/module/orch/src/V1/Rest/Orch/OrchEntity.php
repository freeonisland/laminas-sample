<?php
namespace orch\V1\Rest\Orch;

use ArrayObject;

class OrchEntity extends ArrayObject
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $message;

    /**
     * @var datetime
     */
    public $date;
}
