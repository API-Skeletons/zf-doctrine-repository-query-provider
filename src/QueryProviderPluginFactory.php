<?php

namespace ZF\Doctrine\Repository\Query\Provider;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use ZF\Rest\ResourceEvent;
use GianArb\Angry\Unclonable;
use GianArb\Angry\Unserializable;

class QueryProviderPluginFactory implements FactoryInterface
{
    use Unclonable;
    use Unserializable;

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $instance = new $requestedName($options);

        $resourceEvent = new ResourceEvent();
        $resourceEvent->setIdentity($container->get('authentication')->getIdentity());
        $resourceEvent->setRequest($container->get('request'));
        $config = $container->get('config')['zf-doctrine-repository-query-provider'];

        $queryManager = $container->get('ZfApigilityDoctrineQueryProviderManager');
        $queryProvider = $queryManager->get($config[$options['repository']->getClassName()]['query_provider']);
        $objectManager = $container->get($config[$options['repository']->getClassName()]['object_manager']);
        $queryProvider->setObjectManager($objectManager);

        $instance
            ->setResourceEvent($resourceEvent)
            ->setQueryProvider($queryProvider)
            ;

        return $instance;
    }
}
