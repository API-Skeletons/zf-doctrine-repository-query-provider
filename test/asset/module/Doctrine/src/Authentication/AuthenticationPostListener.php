<?php

namespace ZFTest\Doctrine\Authentication;

use Interop\Container\ContainerInterface;
use ZF\MvcAuth\MvcAuthEvent;
use ZF\MvcAuth\Identity\GuestIdentity;
use ZF\OAuth2\Doctrine\Identity\AuthenticatedIdentity as DoctrineAuthenticatedIdentity;
use ZF\OAuth2\Doctrine\Identity\Exception;
use GianArb\Angry\Unclonable;
use GianArb\Angry\Unserializable;
use Zend\Authentication\AuthenticationService;

class AuthenticationPostListener
{
    use Unclonable;
    use Unserializable;

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // Replace an Authenticated Identity with a Doctrine enabled identity
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $identity = $mvcAuthEvent->getAuthenticationService()->getIdentity();
    }
}
