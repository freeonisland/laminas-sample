<?php

namespace Application\Manager;

class ModuleManager
{
    /**
     * from https://github.com/laminas/laminas-modulemanager/issues/7
     */
    protected function loadModuleByName($event)
    {
        $result = $this->getEventManager()->trigger(ModuleEvent::EVENT_LOAD_MODULE_RESOLVE, $this, $event, function ($r) {
            return (is_object($r));
        });

        $module = $result->last();
        if (! is_object($module)) {
            /* @var $event \Zend\ModuleManager\ModuleEvent */

            $addMsg = '';
            // get all the paths and show it!
            if ($event instanceof \Zend\ModuleManager\ModuleEvent) {
                /* @var $config \Zend\Config\Config */
                $config = $event->getConfigListener()->getMergedConfig(true);

                if (isset($event->getParams()['configListener'])) {
                    /* @var $configListener \Zend\ModuleManager\Listener\ConfigListener */
                    $configListener = $event->getParams()['configListener'];

                    if(count($configListener->getOptions()->getModulePaths()) > 0){
                        $possibleModuleFiles = [];
                        foreach ($configListener->getOptions()->getModulePaths() as $path) {
                            $possibleModuleFiles[] = realpath($path) . DIRECTORY_SEPARATOR . $event->getModuleName() . DIRECTORY_SEPARATOR . 'Module.php';
                        }

                        $addMsg .= ' Is your Module.php is available in one of those paths: "' . implode('", "', $possibleModuleFiles) . '"';
                    }
                }
            }

            if (class_exists('Composer\Autoload\ClassLoader')) {
                // composer is active! ... check the path their!
                $addMsg .= ' Did you maybe defined your module in composer.json, but not used the command `composer install -o` ? (then the autoloading will not work)';
            }

            throw new Exception\RuntimeException(sprintf('Module (%s) could not be initialized.' . $addMsg, $event->getModuleName()));
        }

        return $module;
    }
}