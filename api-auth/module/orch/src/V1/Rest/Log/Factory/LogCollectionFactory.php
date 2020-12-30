<?php
namespace orch\V1\Rest\Log\Factory;

use Laminas\Db\Adapter\Adapter;
use Laminas\Paginator\Adapter\DbTableGateway;
use Interop\Container\ContainerInterface;

use orch\V1\Rest\Log\LogCollection;

class LogCollectionFactory
{
    public function __invoke(ContainerInterface $services)
    {
        return new LogCollection(new DbTableGateway(
            $services->get('LogTableGateway'), null, ['timestamp' => 'DESC']
        ));
    }
}