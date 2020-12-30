<?php
namespace orch\V1\Rest\Log\Factory;

use Laminas\Db\Adapter\Adapter;
use Laminas\Db\TableGateway\TableGateway;
use Interop\Container\ContainerInterface;

class LogTableGatewayFactory
{
    public function __invoke(ContainerInterface $services)
    {
        $db = $services->get('config')['db'];
        $table = $db['adapters']['sqlite']['table'] ?: function() { 
            trigger_error("La table d'adapter est introuvable"); 
            return null;
        };
        
        return new TableGateway($table, $services->get('LogDatabaseAdapter'));
    }
}