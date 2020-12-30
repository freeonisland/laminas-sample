<?php

namespace EventSample\EventListener;

use Laminas\EventManager\Event;

class LoggingListener
{
    function __invoke(Event $e) 
    {
        $event_name = $e->getName(); 
        $target_name = get_class($e->getTarget()); 
        $message_to_log = json_encode($e->getParams());
         
        printf("<b>Listener</b>: Logging \"%s\" writed at %s<br/>",  
            //$event_name, $target_name, 
            $message_to_log, date("H:i"), 
        );
    }
}