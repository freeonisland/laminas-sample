<?php

declare(strict_types=1);

namespace Application\Listener;

use Laminas\Mvc\MvcEvent;

class MenuViewListener 
{
    public function __invoke(MvcEvent $e)
    {
        $app = $e->getApplication();
        $service = $app->getServiceManager();
        $event = $app->getMvcEvent();
        $match = $event->getRouteMatch();

        if (!$match) {
            $e->getViewModel()->setVariable('menu', []);
            return;
        }

        // Remove other modules modules
        $modules = ($service->get("ModuleManager")->getModules()); 
        array_walk($modules, function($v, $k) use (&$modules) {
            if(preg_match('/^Laminas|LmConsole/', $v)) {
                unset($modules[$k]);
            }
        });

        $configs = [];
        foreach($modules as $module) {
            $configs = array_merge_recursive($configs, $service->get("ModuleManager")->getModule($module)->getConfig());
        }
       
        $routes = $configs['router']['routes'];
        $ctrls = $configs['controllers']['aliases'];

        $menu = [
            'home' => '/'
        ];
        foreach($ctrls as $ctrl => $class) {
            $menu[$ctrl] = $ctrl;
        }

        // Avoid to display menu on Rest
        $c_match = strtolower($match->getParams()['controller']);
        $a_match = strtolower($match->getParams()['action']);

        //if (false !== strpos($c_match,'Rest') || false !== strpos(strtolower($c_match),'access')) {
        if (!preg_match('/rest|access/', $c_match)) {
            return;
        }
        if (!preg_match('/json/', $a_match)) {
            return;
        }

        // send menu
        $e->getViewModel()->setVariable('menu', $menu);
    }
}