<?php
return [
    'controllers' => [
        'factories' => [
            'status\\V1\\Rpc\\Ping\\Controller' => \status\V1\Rpc\Ping\PingControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'status.rpc.ping' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/ping',
                    'defaults' => [
                        'controller' => 'status\\V1\\Rpc\\Ping\\Controller',
                        'action' => 'ping',
                    ],
                ],
            ],
            'status.rest.status' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/status[/:status_id]',
                    'defaults' => [
                        'controller' => 'status\\V1\\Rest\\Status\\Controller',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'status.rpc.ping',
            1 => 'status.rest.status',
        ],
    ],
    'api-tools-rpc' => [
        'status\\V1\\Rpc\\Ping\\Controller' => [
            'service_name' => 'ping',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'status.rpc.ping',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'status\\V1\\Rpc\\Ping\\Controller' => 'Json',
            'status\\V1\\Rest\\Status\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'status\\V1\\Rpc\\Ping\\Controller' => [
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
            'status\\V1\\Rest\\Status\\Controller' => [
                0 => 'application/vnd.status.v1+json',
                1 => 'application/hal+json',
                2 => 'application/json',
            ],
        ],
        'content_type_whitelist' => [
            'status\\V1\\Rpc\\Ping\\Controller' => [
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ],
            'status\\V1\\Rest\\Status\\Controller' => [
                0 => 'application/vnd.status.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'api-tools-content-validation' => [
        'status\\V1\\Rpc\\Ping\\Controller' => [
            'input_filter' => 'status\\V1\\Rpc\\Ping\\Validator',
        ],
        'status\\V1\\Rest\\Status\\Controller' => [
            'input_filter' => 'status\\V1\\Rest\\Status\\Validator',
        ],
    ],
    'input_filter_specs' => [
        'status\\V1\\Rpc\\Ping\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'ack',
                'description' => 'Acknowledge with timestamp',
                'error_message' => 'Not acknowledged !',
            ],
        ],
        'status\\V1\\Rest\\Status\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\StringLength::class,
                        'options' => [
                            'max' => '140',
                        ],
                    ],
                ],
                'filters' => [
                    0 => [
                        'name' => \Laminas\Filter\StringTrim::class,
                        'options' => [],
                    ],
                ],
                'name' => 'message',
                'description' => 'Status message between 1 and 40 chars',
                'error_message' => 'No more than 140 chars',
            ],
            1 => [
                'required' => true,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\Regex::class,
                        'options' => [
                            'pattern' => '/^(mwop|andi|zeev)$/',
                        ],
                    ],
                ],
                'filters' => [],
                'name' => 'user',
                'description' => 'The user submitting the status message',
                'error_message' => 'Valid user must be provided',
            ],
            2 => [
                'required' => false,
                'validators' => [
                    0 => [
                        'name' => \Laminas\Validator\Digits::class,
                        'options' => [],
                    ],
                ],
                'filters' => [],
                'name' => 'timestamp',
                'description' => 'The timestamp when the status message was last modified.',
                'error_message' => 'Timstamp must be provided',
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            \status\V1\Rest\Status\StatusResource::class => \status\V1\Rest\Status\StatusResourceFactory::class,
        ],
    ],
    'api-tools-rest' => [
        'status\\V1\\Rest\\Status\\Controller' => [
            'listener' => \status\V1\Rest\Status\StatusResource::class,
            'route_name' => 'status.rest.status',
            'route_identifier_name' => 'status_id',
            'collection_name' => 'status',
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
            'entity_class' => \status\V1\Rest\Status\StatusEntity::class,
            'collection_class' => \status\V1\Rest\Status\StatusCollection::class,
            'service_name' => 'status',
        ],
    ],
    'api-tools-hal' => [
        'metadata_map' => [
            \status\V1\Rest\Status\StatusEntity::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'status.rest.status',
                'route_identifier_name' => 'status_id',
                'hydrator' => \Laminas\Hydrator\ObjectPropertyHydrator::class,
            ],
            \status\V1\Rest\Status\StatusCollection::class => [
                'entity_identifier_name' => 'id',
                'route_name' => 'status.rest.status',
                'route_identifier_name' => 'status_id',
                'is_collection' => true,
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [
            'status\\V1\\Rest\\Status\\Controller' => [
                'collection' => [
                    'GET' => false,
                    'POST' => true,
                    'PUT' => false,
                    'PATCH' => false,
                    'DELETE' => false,
                ],
                'entity' => [
                    'GET' => false,
                    'POST' => false,
                    'PUT' => true,
                    'PATCH' => true,
                    'DELETE' => true,
                ],
            ],
        ],
    ],
];
