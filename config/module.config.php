<?php

namespace ZF\Doctrine\Repository\Query\Builder;

return [
    'zf-doctrine-repository-plugin' => [
        'aliases' => [
            'queryProvider' => QueryProviderPlugin::class,
        ],
        'factories' => [
            QueryBuilderPlugin::class => QueryBuilderPluginFactory::class,
        ],
    ],
];