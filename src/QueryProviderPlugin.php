<?php

namespace ZF\Doctrine\Repository\Query\Provider;

use Doctrine\ORM\QueryBuilder;
use ZF\Apigility\Doctrine\Server\Query\Provider\AbstractQueryProvider;
use ZF\Doctrine\Repository\Plugin\PluginInterface;
use ZF\Rest\ResourceEvent;
use GianArb\Angry\ClassDefence;

class QueryProviderPlugin implements
    PluginInterface
{
    use ClassDefence;

    protected $repository;
    protected $parameters;
    protected $resourceEvent;
    protected $queryProvider;

    public function __construct(array $creationOptions)
    {
        $this->repository = $creationOptions['repository'];
        $this->parameters = $creationOptions['parameters'];
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

    public function find($id, array $parameters = null)
    {
        $queryBuilder = $this->getQueryProvider()->createQuery(
            $this->getResourceEvent(),
            $this->repository->getClassName(),
            $parameters
        );

        $queryBuilder->andWhere('row.id = :id')->setParameter('id', $id);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function findOneBy(array $filters, array $sort = null, $limit = null, $offset = null, $parameters = null)
    {
        $queryBuilder = $this->getQueryProvider()->createQuery(
            $this->getResourceEvent(),
            $this->repository->getClassName(),
            $parameters
        );

        $this->applyFindByParameters($queryBuilder, $filters, $sort, $limit, $offset);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }

    public function findBy(array $filters, array $sort = null, $limit = null, $offset = null, $parameters = null)
    {
        $queryBuilder = $this->getQueryProvider()->createQuery(
            $this->getResourceEvent(),
            $this->repository->getClassName(),
            $parameters
        );

        $this->applyFindByParameters($queryBuilder, $filters, $sort, $limit, $offset);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findAll($parameters = null)
    {
        $queryBuilder = $this->getQueryProvider()->createQuery(
            $this->getResourceEvent(),
            $this->repository->getClassName(),
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

        if (! is_null($offset)) {
            $queryBuilder->setFirstResult($offset);
        }

        if (! is_null($limit)) {
            $queryBuilder->setMaxResults($limit);
        }
    }
}
