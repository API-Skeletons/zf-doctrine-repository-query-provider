<?php

namespace ZF\Doctrine\Query\Provider;

use ZF\Apigility\Doctrine\Server\Query\Provider\AbstractQueryProvider;
use ZF\Rest\ResourceEvent;

interface QueryProviderAwareInterface
{
    public function getQueryProviderAlias();
    public function setResourceEvent(ResourceEvent $resourceEvent);
    public function getResourceEvent();
    public function setQueryProvider(AbstractQueryProvider $queryProvider);
    public function getQueryProvider();
    public function findWithQueryProvider($id);
#    public function findByWithQueryProvider($array, $sort);
#    public function findAllWithQueryProvider();
}