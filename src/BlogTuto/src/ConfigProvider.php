<?php

namespace BlogTuto;

use Laminas\Db\{Adapter\AdapterInterface, ResultSet\ResultSet, TableGateway\TableGateway};
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ServiceManager\ServiceManager;

class ConfigProvider
{
    public function __invoke()
    {
        return $this->getServiceConfig();
    }

    /**
     * in module.config.php
     * 
     * 'service_manager' => [
     *      'factories' => [
     *          Table\AlbumTable::class => function (ServiceManager $container) {}
     *          Table\AlbumTable::class => new class () { function __invoke(ServiceManager $services) }
     *      ],
     */
    public function getServiceConfig()
    {
        return [
            'service_manager' => [
                'factories' => [
                    Table\AlbumTable::class => function ( $container) {
                        $dbAdapter = $container->get(AdapterInterface::class);
                        $resultSetPrototype = new ResultSet;
                        $resultSetPrototype->setArrayObjectPrototype(new Model\Album);

                        return new Table\AlbumTable(
                            'album', $dbAdapter, null, $resultSetPrototype
                        );
                    }
                ]
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
}