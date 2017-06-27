<?php

namespace ZF\Doctrine\Query\Provider;

use ZF\Apigility\Doctrine\Server\Query\Provider\AbstractQueryProvider;
use ZF\Rest\ResourceEvent;
use Doctrine\ORM\QueryBuilder;

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

    public function findOneByWithQueryProvider(array $filters, array $sort = null, $limit = null, $offset = null, $parameters = null)
    {
        $queryBuilder = $this->getQueryProvider()->createQuery(
            $this->getResourceEvent(),
            $this->_entityName,
            $parameters
        );

        $this->applyFindByParameters($queryBuilder, $filters, $sort, $limit, $offset);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function findByWithQueryProvider(array $filters, array $sort = null, $limit = null, $offset = null, $parameters = null)
    {
        $queryBuilder = $this->getQueryProvider()->createQuery(
            $this->getResourceEvent(),
            $this->_entityName,
            $parameters
        );

        $this->applyFindByParameters($queryBuilder, $filters, $sort, $limit, $offset);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findAllWithQueryProvider($parameters = null)
    {
        $queryBuilder = $this->getQueryProvider()->createQuery(
            $this->getResourceEvent(),
            $this->_entityName,
            $parameters
        );

        return $queryBuilder->getQuery()->getResult();
    }

    private function applyFindByParameters(
        QueryBuilder $queryBuilder,
        array $filters,
        array $sort = null,
        $limit = null,
        $offset = null
    ) {
        foreach ($filters as $field => $value) {
            $queryBuilder->andWhere($queryBuilder->expr()->eq('row.' . $field, $value));
        }

        if ($sort) {
            foreach ($sort as $field => $direction) {
                $queryBuilder->addOrderBy('row.' . $field, $direction);
            }
        }

        if ($offset) {
            $queryBuilder->setFirstResult($offset);
        }

        if ($limit) {
           $queryBuilder->setMaxResults($limit);
        }
    }
}