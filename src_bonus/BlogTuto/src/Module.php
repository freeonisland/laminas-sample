<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace BlogTuto;

use Laminas\Db\{Adapter\AdapterInterface, ResultSet\ResultSet, TableGateway\TableGateway};
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ServiceManager\ServiceManager;

class Module
{
    /**
     * Auto-called by Laminas framework
     */
    /**
     * Multiples ways to provide configurations:
     * 
     *      - config/module.config.php
     *      - in Module.php
     *      - or with ConfigProvider.php (like mezzio)
     */
    public function getConfig() : array
    {
        $configProvider = new ConfigProvider;
        return array_merge($configProvider(), include __DIR__ . '/../config/module.config.php');
    }
    /**
     * 'controllers' => [
     *      'factories' => [
     *          Controller\IndexController::class => InvokableFactory::class,
     *      ],
     */
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlbumController::class => function (ServiceManager $container) {
                    return new Controller\AlbumController(
                        $container->get(Table\AlbumTable::class)
                    );
                },
                /*
                 * No need Controller\BlogController::class because auto-loader
                 */
            ]
        ];
    }

     /**
     * Autoload by Laminas
     */
    /**
     * 'service_manager' => [
     *      'factories' => [
     *          Table\AlbumTable::class => function (ServiceManager $container) {}
     *          Table\AlbumTable::class => new class () { function __invoke(ServiceManager $services) }
     *      ],
     */
    public function getServiceConfig()
    {
        /**
         * Inside ConfigProvider
         */
        /*return [
            'factories' => [
                Table\AlbumTable::class => function (ServiceManager $container) {}
                Table\AlbumTable::class => new class () { function __invoke(ServiceManager $services) }
            ],
        ];*/
    }
}
