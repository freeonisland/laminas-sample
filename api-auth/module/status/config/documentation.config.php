<?php
return [
    'status\\V1\\Rest\\Status\\Controller' => [
        'description' => 'Create, manipulate, and retrieve status messages.',
        'collection' => [
            'description' => 'Manipulate list of status',
            'GET' => [
                'description' => 'Retrieve paginated',
            ],
            'POST' => [
                'description' => 'Create a new status',
            ],
        ],
        'entity' => [
            'description' => 'Manipulate and retrieve individual status messages',
            'GET' => [
                'description' => 'Retrieve a status message',
            ],
            'PATCH' => [
                'description' => 'Update',
            ],
            'PUT' => [
                'description' => 'Replace',
            ],
            'DELETE' => [
                'description' => 'Delete',
                'request' => '{
   "message": "Status message between 1 and 140 chars",
   "user": "The user submitting the status message",
   "timestamp": "The timestamp when the status message was last modified."
}',
            ],
        ],
    ],
];
