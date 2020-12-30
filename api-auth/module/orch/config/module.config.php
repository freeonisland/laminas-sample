<?php
return [
    'controllers' => [
        'abstract_factories' => [],
        'factories' => [
            'orch\\V1\\Rpc\\Mag\\Controller' => \orch\V1\Rpc\Mag\MagControllerFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            'LogDatabaseAdapter' => \orch\V1\Rest\Log\Factory\LogDatabaseAdapterFactory::class,
            'LogTableGateway' => \orch\V1\Rest\Log\Factory\LogTableGatewayFactory::class,
            'LogReflexiveTableGateway' => \orch\V1\Rest\Log\Factory\LogReflexiveTableGatewayFactory::class,
            \orch\V1\Rest\Log\LogResource::class => \orch\V1\Rest\Log\Factory\LogResourceFactory::class,
            \orch\V1\Rest\Log\LogResourceCollection::class => \orch\V1\Rest\Log\Factory\LogResourceCollectionFactory::class,
            \orch\V1\Rest\Log\LogCollection::class => \orch\V1\Rest\Log\Factory\LogCollectionFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'orch.rest.log' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/log[/:log_id]',
                    'defaults' => [
                        'controller' => 'orch\\V1\\Rest\\Log\\Controller',
                    ],
                ],
            ],
            'orch.rest.orch' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/orch[/:orch_id]',
                    'defaults' => [
                        'controller' => 'orch\\V1\\Rest\\Orch\\Controller',
                    ],
                ],
            ],
            'orch.rpc.mag' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/mag',
                    'defaults' => [
                        'controller' => 'orch\\V1\\Rpc\\Mag\\Controller',
                        'action' => 'mag',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'orch.rest.log',
            1 => 'orch.rest.orch',
            2 => 'orch.rpc.mag',
        ],
    ],
    'api-tools-rest' => [
        'orch\\V1\\Rest\\Log\\Controller' => [
            'controller_class' => \orch\V1\Rest\Log\Controller\LogController::class,
            'listener' => \orch\V1\Rest\Log\LogResource::class,
            'route_name' => 'orch.rest.log',
            'route_identifier_name' => 'log_id',
            'collection_name' => 'log',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PUT',
                2 => 'PATCH',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \orch\V1\Rest\Log\LogEntity::class,
            'collection_class' => \orch\V1\Rest\Log\LogCollection::class,
            'service_name' => 'log',
        ],
        'orch\\V1\\Rest\\Orch\\Controller' => [
            'listener' => 'orch\\V1\\Rest\\Orch\\OrchResource',
            'route_name' => 'orch.rest.orch',
            'route_identifier_name' => 'orch_id',
            'collection_name' => 'orch',
            'entity_http_methods' => [
                0 => 'GET',
                1 => 'PATCH',
                2 => 'PUT',
                3 => 'DELETE',
            ],
            'collection_http_methods' => [
                0 => 'GET',
                1 => 'POST',
            ],
            'collection_query_whitelist' => [],
            'page_size' => 25,
            'page_size_param' => null,
            'entity_class' => \orch\V1\Rest\Orch\OrchEntity::class,
            'collection_class' => \orch\V1\Rest\Orch\OrchCollection::class,
            'service_name' => 'orch',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'orch\\V1\\Rest\\Log\\Controller' => 'HalJson',
            'orch\\V1\\Rest\\Orch\\Controller' => 'HalJson',
            'orch\\V1\\Rpc\\Mag\\Controller' => 'Documentation',
        ],
        'accept_whitelist' => [
            'orch\\V1\\Rest\\Log\\Controller' => [
                0 => 'application/vnd.orch.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'orch\\V1\\Rest\\Orch\\Controller' => [
                0 => 'application/vnd.orch.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
            'orch\\V1\\Rpc\\Mag\\Controller' => [
                0 => 'application/xhtml+xml',
                1 => 'application/text+xml',
                2 => 'text/xml',
                3 => 'application/xml',
            ],
        ],
        'content_type_whitelist' => [
            'orch\\V1\\Rest\\Log\\Controller' => [
                0 => 'application/vnd.orch.v1+json',
                1 => 'application/json',
            ],
            'orch\\V1\\Rest\\Orch\\Controller' => [
                0 => 'application/vnd.orch.v1+json',
                1 => 'application/json',
            ],
            'orch\\V1\\Rpc\\Mag\\Controller' => [
                0 => 'application/xhtml+xml',
                1 => 'application/text+xml',
                2 => 'text/xml',
                3 => 'application/xml',
            ],
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \orch\V1\Rest\Log\LogEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'orch.rest.log',
                'route_identifier_name' => 'log_id',
                'hydrator' => \Laminas\Hydrator\ReflectionHydrator::class,
            ],
            \orch\V1\Rest\Log\LogCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'orch.rest.log',
                'route_identifier_name' => 'log_id',
                'is_collection' => true,
            ],
            \orch\V1\Rest\Orch\OrchEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'orch.rest.orch',
                'route_identifier_name' => 'orch_id',
                'hydrator' => \Laminas\Hydrator\ArraySerializable::class,
            ],
            \orch\V1\Rest\Orch\OrchCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'orch.rest.orch',
                'route_identifier_name' => 'orch_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools' => [
        'db-connected' => [
            'orch\\V1\\Rest\\Orch\\OrchResource' => [
                'adapter_name' => 'sqlite',
                'table_name' => 'orch',
                'hydrator_name' => \Laminas\Hydrator\ArraySerializable::class,
                'controller_service_name' => 'orch\\V1\\Rest\\Orch\\Controller',
                'entity_identifier_name' => 'id',
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'orch\\V1\\Rest\\Orch\\Controller' => [
            'input_filter' => 'orch\\V1\\Rest\\Orch\\Validator',
        ],
        'orch\\V1\\Rest\\Log\\Controller' => [
            'input_filter' => 'orch\\V1\\Rest\\Log\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'orch\\V1\\Rest\\Orch\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'Message',
                'description' => 'Messages',
                'field_type' => 'string',
                'error_message' => 'message must be filled',
            ],
        ],
        'orch\\V1\\Rest\\Log\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'min' => '10',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'message',
                'description' => 'Message from logs',
                'error_message' => 'Wrong text',
            ],
        ],
    ],
    'api-tools-rpc' => [
        'orch\\V1\\Rpc\\Mag\\Controller' => [
            'service_name' => 'mag',
            'http_methods' => [
                0 => 'POST',
                1 => 'GET',
            ],
            'route_name' => 'orch.rpc.mag',
        ],
    ],
];
