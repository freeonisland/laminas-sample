<?php

namespace EventSample\Event;

use Laminas\EventManager\Event;

class CustomEvent extends Event
{
    function getName()
    {
        return 'custom-' . $this->name;
    }
}