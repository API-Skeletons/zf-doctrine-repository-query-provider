<?php

namespace ZF\Doctrine\Repository\Query\Provider;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZF\Rest\ResourceEvent;

class QueryProviderPluginFactory implements FactoryInterface
{
    private $config;

    private $serviceLocator;

    public function __invoke()
    {
        $resourceEvent = new ResourceEvent();
        $resourceEvent->setIdentity($this->getServiceLocator()->get('Authentication')->getIdentity());
        $resourceEvent->setRequest($this->getServiceLocator()->get('Request'));

        $queryManager = $this->getServiceLocator()->get('ZfApigilityDoctrineQueryProviderManager');
        $queryProvider = $queryManager->get($instance->getQueryProviderAlias());
        $queryProvider->setObjectManager($objectManager);

        $instance
            ->setResourceEvent($resourceEvent)
            ->setQueryProvider($queryProvider)
            ;
    }

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $servicelocator->get('Your\Service');
    }
}