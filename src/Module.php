<?php

namespace ZF\Doctrine\Repository\Query\Provider;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\ModuleManagerInterface;

class Module implements
    ConfigProviderInterface,
    InitProviderInterface,
    DependencyIndicatorInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getModuleDependencies()
    {
        return ['ZF\Doctrine\Repository'];
    }
}
