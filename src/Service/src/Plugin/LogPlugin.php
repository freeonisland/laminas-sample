<?php

namespace Service\Plugin;

use Laminas\Mvc\Controller\Plugin\PluginInterface;

class LogPlugin implements \Laminas\Mvc\Controller\Plugin\PluginInterface 
{
    protected $ctrl;

    protected $logService;

    function __construct(\Service\Service\LogService $logService)
    {
        $this->logService = $logService;
    }

    public function setController(\Laminas\Stdlib\DispatchableInterface $controller) 
    {
        $this->ctrl = $controller;
    }

    public function getController()
    {
        return $this->ctrl;
    }

    public function log(string $msg, int $level=0)
    {
        $this->logService->log($msg, $level);
    }
}