<?php
namespace orch\V1\Rest\Log\Factory;

use Laminas\Db\Adapter\Adapter;
use Interop\Container\ContainerInterface;

class LogDatabaseAdapterFactory
{
    public function __invoke(ContainerInterface $services)
    {
        return new Adapter($services->get('config')['db']['adapters']['sqlite']);
    }
}