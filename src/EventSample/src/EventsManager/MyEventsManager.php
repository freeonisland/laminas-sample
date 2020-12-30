<?php

namespace EventSample\EventsManager;

use Laminas\EventManager\EventManager;

class MyEventsManager extends EventManager //share, trigger, attach, detach, prototype
{
    function trigger($eventName, $target = null, $argv = [])
    {
        echo " - MyEventsManager: trigger->($eventName)<br/>";
        return parent::trigger($eventName, $target, $argv);
    }
}