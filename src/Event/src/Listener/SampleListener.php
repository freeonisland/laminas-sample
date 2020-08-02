<?php

namespace Event\Listener;

use Laminas\EventManager\EventInterface;

class SampleListener
{
    // ... assume events definition from above

    public function __invoke(EventInterface $e)
    {
        $event = $e->getName();
        $params = $e->getParams();
        
        printf(
            'SAMPLE LISTENER: Handled event "%s", with parameters %s<br/>',
            $event,
            json_encode($params)
        );
    }

    /*public function bar($baz, $bat = null)
    {
        $params = compact('baz', 'bat');
        $this->getEventManager()->trigger(__FUNCTION__, $this, $params);
    }*/

}
