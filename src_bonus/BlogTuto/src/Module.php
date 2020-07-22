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

class Module
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Table\AlbumTable::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet;
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album);
                    return new Table\AlbumTable(
                        'album', $dbAdapter, null, $resultSetPrototype
                    );
                },
                Table\BlogTable::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet;
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Album);
                    return new Table\AlbumTable(
                        'album', $dbAdapter, null, $resultSetPrototype
                    );
                }
            ]
        ];

        /*
         * for gateway inside
         */
        /*return [
            'factories' => [
                Table\AlbumTable::class => function ($container) {
                    $tableGateway = $container->get(Table\AlbumTableGateway::class);
                    return new Table\AlbumTable($tableGateway);
                },
                Table\AlbumTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet;
                    $resultSetPrototype->setArrayObjectPrototype(new Entity\Album);
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                }
            ]
        ];*/
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\AlbumController::class => function ($container) {
                    return new Controller\AlbumController(
                        $container->get(Table\AlbumTable::class)
                    );
                },
                Controller\BlogController::class => function ($container) {
                    return new Controller\BlogController;
                }
            ]
        ];
    }
}
