<?php
namespace orch\V1\Rest\Log;

use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Db\TableGateway\TableGateway;

class LogResource extends AbstractResourceListener
{
    /**
     * @var TableGateway
     */
    protected $reflectionHydratedTableGateway;

    /**
     * @var LogResourceCollection
     */
    protected $logResourceCollection;

    /**
     * @param TableGateway $reflectionHydratedTableGateway
     * @param LogResourceCollection $logResourceCollection
     */
    function __construct(TableGateway $reflectionHydratedTableGateway, LogResourceCollection $logResourceCollection) 
    {
        $this->reflectionHydratedTableGateway = $reflectionHydratedTableGateway;
        $this->logResourceCollection = $logResourceCollection;
    }

    /**
     * Fetch a resource (GET)
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
       return new ApiProblem(405, 'The FETCH(GET) method has not been defined for individual resources');
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for individual resources');
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for individual resources');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The UPDATE(PUT) method has not been defined for individual resources');
    }




    /****************************
     *        COLLECTION
     ***************************/


    /**
     * Fetch all or a subset of resources (GET without id)
     *
     * @param  Laminas\Stdlib\Parameters $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->logResourceCollection->fetchAll($params);
    }

    /**
     * Create a resource (POST)
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        return $this->logResourceCollection->create($data);
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function _not_used_deleteList($data)
    {
        return $this->logResourceCollection->_not_used_deleteList($data);
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function _not_used_patchList($data)
    {
        return $this->logResourceCollection->_not_used_patchList($data);
    }

    /**
     * Replace a collection or members of a collection (PUT)
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function _not_used_replaceList($data)
    {
        return $this->logResourceCollection->_not_used_replaceList($data);
    }
}
