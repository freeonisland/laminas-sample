<?php
namespace orch\V1\Rest\Log\Factory;

use Interop\Container\ContainerInterface;
use orch\V1\Rest\Log\LogResource;
use orch\V1\Rest\Log\LogResourceCollection;

class LogResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        return new LogResource(
            $services->get('LogReflexiveTableGateway'), $services->get(LogResourceCollection::class)
        );
    }
}
