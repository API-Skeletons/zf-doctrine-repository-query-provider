<?php

namespace ZFTest\Doctrine\Authentication;

use Interop\Container\ContainerInterface;

class AuthenticationPostListenerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthenticationPostListener($container);
    }
}
