<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace EventSample;

use Laminas\ModuleManager\Feature\{ConfigProviderInterface, ControllerProviderInterface};

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

class Module implements ConfigProviderInterface, ControllerProviderInterface
{
    public function getConfig() : array
    {
        $config = array_merge(
            $this->getControllerConfig(),
            $this->getViewManagerConfig()
        );
        return $config;
    }

    public function getControllerConfig(): array 
    {
        return [
            'controllers' => [
                'aliases' => [
                    'event' => Controller\EventController::class
                ]
            ]
        ];
    }

    public function getViewManagerConfig(): array
    {
        return [
            'view_manager' => [
               'template_path_stack' => [
                    __DIR__ . '/../view',
                ],
            ],
        ];
    }
}
