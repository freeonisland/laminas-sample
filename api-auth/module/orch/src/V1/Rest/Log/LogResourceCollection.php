<?php
namespace orch\V1\Rest\Log;

use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Hydrator\ReflectionHydrator;

class LogResourceCollection extends AbstractResourceListener
{
    protected $reflectionHydratedTableGateway;
    protected $reflexionHydrator;

    function __construct(TableGateway $reflectionHydratedTableGateway, ReflectionHydrator $reflexionHydrator) 
    {
        $this->reflectionHydratedTableGateway = $reflectionHydratedTableGateway;
        $this->reflexionHydrator = $reflexionHydrator;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  Laminas\Stdlib\Parameters $params
     * @return ApiProblem|mixed
     */
     /* return resultSet
     * 0 => '__construct',
        1 => 'setObjectPrototype',
        2 => 'getObjectPrototype',
        3 => 'setHydrator',
        4 => 'getHydrator',
        5 => 'current',
        6 => 'toArray',
        7 => 'initialize',
        8 => 'buffer',
        9 => 'isBuffered',
        10 => 'getDataSource',
        11 => 'getFieldCount',
        12 => 'next',
        13 => 'key',
        14 => 'valid',
        15 => 'rewind',
        16 => 'count',
     */
    public function fetchAll($params = [])
    {
        /*
         * Used with Table (reflectionHydrator)
         * return Laminas\\Db\\ResultSet\\HydratingResultSet
         */
        $resultSet = $this->reflectionHydratedTableGateway->select();
        if (!$resultSet->getObjectPrototype() instanceof LogEntity) { #LogEntity
            return new ApiProblem(500, "Le resultat n'est pas valide");
        }
        return $resultSet->toArray();

        #_fetchAll_methods_specific_tutorial() -> keep for knowledge
    }

    /**
     * Create a resource (POST)
     *
     * @param  mixed $data
     * @return LogEntity
     */
    public function create($logEntity)
    {
        if (!$logEntity instanceOf LogEntity) {
            throw new \InvalidArgumentException(sprintf('Invalid data provided to %s, must be an instance of LogEntity', __METHOD__));
        }

        //$logEntity = $this->reflexionHydrator->hydrate((array)$data, new LogEntity);
        $logEntityData = $this->reflexionHydrator->extract($logEntity);

        $inserted = $this->reflectionHydratedTableGateway->insert($logEntityData);
        $lastInsertedId = $this->reflectionHydratedTableGateway->getLastInsertValue();
        
        $resultSet = $this->reflectionHydratedTableGateway->select(['id'=>$lastInsertedId]); #Laminas\Db\ResultSet\HydratingResultSet 

        if ($inserted<=0) {
            throw new \DomainException('Insert operation failed', 500);
        }
  
        //return $resultSet->current()->getArrayCopy(); #if HAL is ArraySerializableHydrator
        return $resultSet->current(); #if HAL is ReflexionHydrator
    }





/*
     * use Laminas\Db\TableGateway\TableGateway;
        use Laminas\ApiTools\ApiProblem\ApiProblem;
        use Laminas\ApiTools\Rest\AbstractResourceListener;
        use Laminas\ApiTools\ContentNegotiation\ViewModel;

        use Laminas\Db\Adapter\Driver\ResultInterface;

        use Laminas\Db\ResultSet\HydratingResultSet;
        use Laminas\Hydrator\ReflectionHydrator;
     */
    protected function _fetchAll_methods_specific_tutorial()
    {
        /*
         * Used with Table (reflectionHydrator)
         * return #'Laminas\\Db\\ResultSet\\ResultSet'
         */
        $resultSet = $this->tableGateway->select(); 
        return $resultSet->toArray();

        /*
         * Adapter, Used with reflectionHydrator
         */
        $statement = $this->adapter->createStatement('SELECT * FROM orch');
        $statement->prepare($parameters);
        $result = $statement->execute(); //Laminas\\Db\\Adapter\\Driver\\Pdo\\Result

        if ($result instanceof ResultInterface && $result->isQueryResult()) {
            $resultSet = new HydratingResultSet(new ReflectionHydrator, new LogEntity);
            $resultSet->initialize($result);
        }
        return $resultSet->toArray();
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function _not_used_deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE LIST method has not been defined for collections');
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function _not_used_patchList($data)
    {
        return new ApiProblem(405, 'The PATCH LIST method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function _not_used_replaceList($data)
    {
        return new ApiProblem(405, 'The (REPLACE LIST)PUT method has not been defined for collections');
    }
}
