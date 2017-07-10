<?php

namespace ZF\Doctrine\Repository\Query\Provider;

use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use GianArb\Angry\Unclonable;
use GianArb\Angry\Unserializable;

class Module implements
    ConfigProviderInterface,
    DependencyIndicatorInterface
{
    use Unclonable;
    use Unserializable;

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getModuleDependencies()
    {
        return ['ZF\Doctrine\Repository'];
    }
}
