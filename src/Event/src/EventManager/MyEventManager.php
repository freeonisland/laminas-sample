<?php

namespace Event\EventManager;

use Laminas\EventManager\{EventManager, EventManagerInterface, EventManagerAwareInterface};

class MyEventManager implements EventManagerAwareInterface //set() can include manager
{
    protected $eventManager;

    /*********************
     * EventManagerAware *
     *********************/

    function __construct(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    /**
     * {@inheritDoc}
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
    }

    public function getEventManager()
    {
        return $this->eventManager;
    }



    /****************
     * EventManager *
     ****************/

    public function attach($eventName, callable $listener, $priority = 1)
    {
        echo 'attache to '.$eventName.'________<br/>';
        $this->eventManager->attach($eventName, $listener, $priority);
    }

    public function trigger($eventName, $target = null, $argv = [])
    {
        echo '______________________________!Trigger! '.$eventName.'<br/>';
        $this->eventManager->trigger($eventName, $target, $argv);
    }

    public function triggerEvent(\Laminas\EventManager\Event $event)
    {
        echo '______________________________!Trigger Event! '.$event->getName().'<br/>';
        $this->eventManager->triggerEvent($event);
    }
}