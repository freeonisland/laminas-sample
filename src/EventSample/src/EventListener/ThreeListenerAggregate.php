<?php

namespace EventSample\EventListener;

use Laminas\EventManager\Event;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;

class ThreeListenerAggregate implements ListenerAggregateInterface
{
    use ListenerAggregateTrait; //detach() method

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $events->attach('*', new DisplayListener, 5); 
        $events->attach('mail', new MailerListener);
        $events->attach('log', new LoggingListener, 3);
    }
}