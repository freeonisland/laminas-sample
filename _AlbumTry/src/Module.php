<?php

declare(strict_types=1);

namespace AlbumTry;

class Module
{
    public function getConfig(): array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        /*
  $table,
        AdapterInterface $adapter,
        $features = null,
        ResultSetInterface $resultSetPrototype = null,
        Sql $sql = null
        */
        return [
            'factories' => [
                Gateway\AlbumGateway::class => function($container) {
                    $resultSetPrototype = new \Laminas\Db\ResultSet\ResultSet;
                    return new Gateway\AlbumGateway(
                        new \Laminas\Db\TableGateway\TableGateway(
                            'album',
                            $container->get(\Laminas\Db\Adapter\AdapterInterface::class),
                            null, 
                            $resultSetPrototype->setArrayObjectPrototype(new Entity\AlbumEntity)
                        )
                    ); 
                }
            ]
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\EditController::class => function($container) {
                    return new Controller\EditController(
                        $container->get(Gateway\AlbumGateway::class)
                    );
                }
            ]
        ];
    }
}