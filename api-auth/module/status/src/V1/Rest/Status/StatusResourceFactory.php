<?php
namespace status\V1\Rest\Status;

use StatusLib\Mapper;
use Laminas\ServiceManager\ServiceManager;

class StatusResourceFactory
{
    public function __invoke(ServiceManager $services)
    {
        return new StatusResource($services->get(Mapper::class));
    }
}
