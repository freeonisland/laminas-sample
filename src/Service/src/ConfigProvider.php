<?php

namespace Service;

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
       
        return [  #router =>
            'routes' => [
            
                'service' => [
                    'type'    => Literal::class,
                    'options' => [
                        'route'    => '/service',
                        'defaults' => [
                            'controller' => Controller\ServiceController::class,
                            'action'     => 'index',
                        ],
                        
                    ],
                ]
            ]
        ];
    }
}