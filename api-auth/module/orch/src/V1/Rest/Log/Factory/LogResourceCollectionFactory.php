<?php
namespace orch\V1\Rest\Log\Factory;

use Interop\Container\ContainerInterface;
use orch\V1\Rest\Log\LogResourceCollection;

class LogResourceCollectionFactory
{
    public function __invoke(ContainerInterface $services)
    {
        return new LogResourceCollection(
            $services->get('LogReflexiveTableGateway'), new \Laminas\Hydrator\ReflectionHydrator
        );
    }
}
