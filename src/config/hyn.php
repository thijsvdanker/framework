<?php

return [
    'packages' => [
        'multi-tenant' => [
            'description'      => 'Multi tenancy for Laravel 5.1+',
            'service-provider' => 'Laraflock\MultiTenant\MultiTenantServiceProvider',
        ],
        'management-interface' => [
            'description'      => 'Interface for managing webserver and multi tenancy',
            'service-provider' => 'HynMe\ManagementInterface\ManagementInterfaceServiceProvider',
        ],
        'webserver' => [
            'description'      => 'Integration into and generation of configs for webservices',
            'service-provider' => 'HynMe\Webserver\WebserverServiceProvider',
        ],
    ],
];
