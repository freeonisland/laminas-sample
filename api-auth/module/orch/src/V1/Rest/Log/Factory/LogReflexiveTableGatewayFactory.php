<?php
namespace orch\V1\Rest\Log\Factory;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ReflectionHydrator;
use Interop\Container\ContainerInterface;

use orch\V1\Rest\Log\LogEntity;

/**
 * use Laminas\ApiTools\Configuration\ConfigResource;
 * need "laminas-api-tools/api-tools-configuration": "*",
 * $config = new ConfigResource;
*/
class LogReflexiveTableGatewayFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $db = $services->get('config')['db'];
        $table = $db['adapters']['sqlite']['table'] ?: function() { 
            trigger_error("La table d'adapter est introuvable"); 
            return null;
        };

        $rTableGateway = new TableGateway(
            $table, $services->get('LogDatabaseAdapter'), null, 
            new HydratingResultSet(new ReflectionHydrator, new LogEntity));
        
        return $rTableGateway;
    }
}