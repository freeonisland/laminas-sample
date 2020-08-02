<?php

namespace Event\Listener;

use Laminas\EventManager\EventInterface;
use Service\Service\LogService;

class LogListener
{
    protected $logService;

    // ... assume events definition from above
    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    public function __invoke(EventInterface $event)
    {
        $name = $event->getName();
        $params = $event->getParams();

        $this->logService->log(sprintf(
            'LOG LISTENER: Handled event "%s", with parameters %s<br/>',
            $name,
            json_encode($params)
        ));
    }

}
