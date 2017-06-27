<?php

namespace ZF\Doctrine\Query\Provider;

use ZF\Apigility\Doctrine\Server\Query\Provider\AbstractQueryProvider;
use ZF\Rest\ResourceEvent;

trait QueryProviderAwareTrait
{
    protected $resourceEvent;
    protected $queryProvider;

    /**
     * When null is returned the QueryProvider functionality
     * will not be loaded in the repository by the factory.
     */
    public function getQueryProviderAlias()
    {
        return;
    }

    public function setResourceEvent(ResourceEvent $resourceEvent)
    {
        $this->resourceEvent = $resourceEvent;

        return $this;
    }

    public function getResourceEvent()
    {
        return $this->resourceEvent;
    }

    public function setQueryProvider(AbstractQueryProvider $queryProvider)
    {
        $this->queryProvider = $queryProvider;

        return $this;
    }

    public function getQueryProvider()
    {
        return $this->queryProvider;
    }

    public function findWithQueryProvider($id, array $parameters = null)
    {
        $queryBuilder = $this->getQueryProvider()->createQuery(
            $this->getResourceEvent(),
            $this->_entityName,
            $parameters
        );

        $queryBuilder->andWhere('row.id = :id')->setParameter('id', $id);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
#    public function findByWithQueryProvider($array, $sort);
#    public function findAllWithQueryProvider();
}