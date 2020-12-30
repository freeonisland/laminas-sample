<?php

namespace EventSample\EventListener;

use Laminas\EventManager\Event;

class DisplayListener 
{
    function __invoke(Event $e) 
    {
        $event_name = $e->getName(); 
        $target_name = get_class($e->getTarget()); 
        $params_json = json_encode($e->getParams());
         
        printf("<b>Listener</b>: Event \"%s\" of class \"%s\" is called with parameters %s<br/>",  
            $event_name, $target_name, $params_json
        );
    }
}