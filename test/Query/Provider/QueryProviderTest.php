<?php

namespace ZFTest\Doctrine\Repository\Query\Provider;

use Zend\Stdlib\Request;
use ZFTest\Doctrine\Entity\User;

class QueryProviderTest extends AbstractTest
{
    static $accessToken;

    /** @dataProvider provideStorage */
    public function testAuthenticatedUser()
    {
        $serviceManager = $this->getApplication()->getServiceManager();
        $objectManager = $serviceManager->get('doctrine.entitymanager.orm_default');

        $objectManager->getRepository(User::class)->plugin('queryProvider')->find(1);
        $objectManager->getRepository(User::class)->plugin('queryProvider')->findOneBy([
            'id' => 1,
        ],
        [ 'username' => 'asc' ],
        0,
        5
        );
        $objectManager->getRepository(User::class)->plugin('queryProvider')->findBy([
            'id' => 1
        ]);
        $objectManager->getRepository(User::class)->plugin('queryProvider')->findAll();
    }
}
