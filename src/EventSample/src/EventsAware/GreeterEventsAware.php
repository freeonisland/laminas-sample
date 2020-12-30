<?php

namespace EventSample\EventsAware;

use Laminas\EventManager\EventManagerAwareInterface;
use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\EventManagerAwareTrait;
use Laminas\EventManager\EventManager;

use EventSample\Event\CustomEvent;

/**
 * The aware interface 
 *  - can provide and use events via ONE event manager
 */
class GreeterEventsAware implements EventManagerAwareInterface //setEM, getEM
{
    /**
     * $events (aka EventManager)
     */
    protected $events;

    /*
     * Can use trait to set and get events
     use EventManagerAwareTrait;
     */
    
    /**
     * setEventManager
     */
    function setEventManager(EventManagerInterface $events)
    {
        // Can use events->setIdentifiers( __CLASSNAME__, get_called_class() ) too!
        $this->events = $events;
        return $this;
    }

    /**
     * getEventManager
     * Create new one if not exists
     */
    function getEventManager(): EventManager
    {
        if (null === $this->events) {
            $this->setEventManager(new \EventSample\EventsManager\MyEventsManager);
        }
        return $this->events;
    }

    function trigger_three(string $message)
    {
        printf ("Aware: Launch \"%s\" from %s<br/>", $message, substr(strrchr(__CLASS__, '\\'), 1));

        // trigger the event
        // trigger(name, target, params)
        $this->getEventManager()->trigger('display', $this, ['param1', $message]); 
        $this->getEventManager()->trigger('mail', $this, ['a'=>'administrator', 'e'=>'email@mail.com', 'm'=>$message]); 
        $this->getEventManager()->trigger('log', $this, [$message]); 
    }

    /**
     * @return \Laminas\EventManager\ResponseCollection
     */
    function trigger_greet(string $message)
    {
        printf ("Aware: Launch \"%s\" from %s<br/>", $message, substr(strrchr(__CLASS__, '\\'), 1));

        // trigger the event
        // trigger(name, target, params)
        $myevent = new CustomEvent('custom_name', $this, ['param']);
        $this->getEventManager()->triggerEvent($myevent); 

        return $this->getEventManager()->trigger('event_triggered_within_class', $this, ['param1', $message]); 
    }
}