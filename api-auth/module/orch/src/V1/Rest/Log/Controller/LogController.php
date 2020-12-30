<?php
namespace orch\V1\Rest\Log\Controller;

use orch\V1\Rest\Log\LogEntity;
use Laminas\ApiTools\Rest\RestController;
use Laminas\Hydrator\ReflectionHydrator;

class LogController extends RestController
{ 
    /**
     * Laminas\Hydrator\ReflexionHydrator;
     */
    protected $reflexionHydrator;

    /**
     * Constructor
     *
     * Allows you to set the event identifier, which can be useful to allow multiple
     * instances of this controller to react to different sets of shared events.
     *
     * @param  null|string $eventIdentifier
     */
    public function __construct($eventIdentifier = null)
    {
        if (null !== $eventIdentifier) {
            $this->eventIdentifier = $eventIdentifier;
        }

        $this->reflexionHydrator = new ReflectionHydrator;
    }

    /**
     * Create a new entity
     *
     * @param  array $data
     * @return Response|ApiProblem|ApiProblemResponse|HalEntity
     */
    public function create($data)
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException(sprintf('Invalid data provided to %s, must be an array', __METHOD__));
        }

        $logEntity = $this->reflexionHydrator->hydrate($data, new LogEntity);

        return parent::create($logEntity);
    }
}

