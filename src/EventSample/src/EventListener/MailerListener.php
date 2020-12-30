<?php

namespace EventSample\EventListener;

use Laminas\EventManager\Event;

class MailerListener
{
    function __invoke(Event $e) 
    {
        $event_name = $e->getName(); 
        $target_name = get_class($e->getTarget()); 
        $params = $e->getParams();
        printf("<b>Listener</b>: Send mail \"%s\", to <em>%s</em> at &lt;%s&gt;<br/>",  
            $params['m'], $params['a'], $params['e']
        );
    }
}