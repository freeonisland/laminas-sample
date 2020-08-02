<?php

namespace Event\Event;

use Laminas\EventManager\{Event};

/**
 * When an order send
 */
class OrderEvent extends Event
{
    const NAME = 'OrderEvent';

    protected $order;

    function __construct(object $order)
    {
        $this->setOrder($order);
    }

    function getName()
    {
        return self::NAME;
    }

    public function setOrder(object $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }
}