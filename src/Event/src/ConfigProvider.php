<?php

namespace Event;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

/**
 * Config provider require Config-aggregator
 */
class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'view_manager' => $this->getCustomViewConfig(),
            'router' => $this->getCustomRouterConfig()
        ];
    }

    public function getCustomViewConfig()
    {
        return [ #view_manager =>
            'template_path_stack' => [
                __DIR__ . '/../view',
            ]
        ];
    }
    
    public function getCustomRouterConfig()
    {
        $event = [
            'type'    => Literal::class,
            'options' => [
                'route'    => '/event',
                'defaults' => [
                    'controller' => Controller\EventController::class,
                    'action'     => 'index',
                ],
                
            ],
        ];

        $mvcevent = [
            'type'    => Literal::class,
            'options' => [
                'route'    => '/mvcevent',
                'defaults' => [
                    'controller' => Controller\MvcEventController::class,
                    'action'     => 'index',
                ],
                
            ],
        ];

        return [  #router =>
            'routes' => [
                'event' => $event,
                'mvcevent' => $mvcevent
            ]
        ];
    }
}