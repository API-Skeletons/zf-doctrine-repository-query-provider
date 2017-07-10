<?php

namespace ZFTest\Doctrine;

return [
    'service_manager' => [
        'factories' => [
            Authentication\AuthenticationPostListener::class =>
                Authentication\AuthenticationPostListenerFactory::class,
        ],
    ],
    'doctrine' => [
        'driver' => [
            'test_driver' => [
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\XmlDriver',
                'paths' => [
                    0 => __DIR__ . '/orm',
                ],
            ],
            'orm_default' => [
                'class' => 'Doctrine\\ORM\\Mapping\\Driver\\DriverChain',
                'drivers' => [
                    'ZFTest\\Doctrine\\Entity' => 'test_driver',
                ],
            ],
        ],
    ],
];
