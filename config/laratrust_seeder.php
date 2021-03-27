<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'admin' => [
            'admins' => 'c,r,u,d',
            'users' => 'c,r,u,d',
            'profile' => 'r,u'
        ],
        'manager' => [
            'profile' => 'r,u',
        ],
        'receptionist' => [
            'users' => 'c,r,u,d',
        ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
