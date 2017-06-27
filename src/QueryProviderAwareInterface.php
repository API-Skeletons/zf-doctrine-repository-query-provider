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
    public function findOneByWithQueryProvider(array $filters, array $sort = null, $limit = null, $offset = null, $parameters = null);
    public function findByWithQueryProvider(array $filters, array $sort = null, $limit = null, $offset = null, $parameters = null);
    public function findAllWithQueryProvider($parameters = null);
}