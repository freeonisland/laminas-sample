<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Event;

use Laminas\ModuleManager\Feature\{ConfigProviderInterface, ControllerPluginProviderInterface};

class Module implements ConfigProviderInterface, ControllerPluginProviderInterface
{
    public function getConfig(): array
    {
        return (new ConfigProvider)();
    }

    /**
     * Expected to return \Laminas\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Laminas\ServiceManager\Config
     */
    public function getControllerPluginConfig()
    {
        return [
            'factories' => [
                'log' => function(\Laminas\ServiceManager\ServiceManager $serviceManager) {
                    return new \Service\Plugin\LogPlugin($serviceManager->get(\Service\Service\LogService::class));
                }
            ]
        ];
    }
    
}
