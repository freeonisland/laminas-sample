<?php
namespace orch\V1\Rest\Log;

class LogEntity extends \ArrayObject
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $message;

    /**
     * @var datetime
     */
    private $date;

    public function __construct()
    {
        /**
         * default value
         */
        $this->date = (new \DateTime)->format("Y-m-d H:m");
    }
}
