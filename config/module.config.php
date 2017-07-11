<?php

namespace ZF\Doctrine\Repository\Query\Provider;

return [
    'zf-doctrine-repository-plugin' => [
        'aliases' => [
            'queryProvider' => QueryProviderPlugin::class,
        ],
        'factories' => [
            QueryProviderPlugin::class => QueryProviderPluginFactory::class,
        ],
        'shared' => [
            QueryProviderPlugin::class => false,
        ],
    ],
];