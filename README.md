zf-doctrine-query-provider
==========================

Integrate [Doctrine in Apigility](https://github.com/zfcampus/zf-apigility-doctrine)
Query Providers into Doctrine Repositories.

This allows you to fetch entities using the same business logic and filtering your Query Providers use.
Useful for an RPC where an entity may be required and must have access to the current user.  Can be
used throughout the application to apply business rules for entity access to the current user.

The intention of this module is to solve the problem of repeated code to validate if a user has access
to a given entity.


Installation
------------

Installation of this module uses composer. For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

```sh
composer require api-skeletons/zf-doctrine-query-provider
```


Repository Factory Configuration
--------------------------------

This repository provides an interface and trait to be applied to a Doctrine repository.  By default Doctrine uses it's own
repository factory to create repositories.  You will need to create a custom repository factory.  See the article
[Dependency Injection in Doctrine Repositories](http://blog.tomhanderson.com/2016/01/dependency-injection-in-doctrine.html)
for instructions to do this.

Once you have a factory for your repositories you will need to code the dependency injection for the provided interface.
The following code will inject the necessary dependencies:

```php
use ZF\Doctrine\Query\Provider\QueryProviderAwareInterface;

// Add to createRepository function after the instance has been created.
if ($instance instanceof QueryProviderAwareInterface && $instance->getQueryProviderAlias()) {
    $resourceEvent = new ResourceEvent();
    $resourceEvent->setIdentity($this->getServiceLocator()->get('Authentication')->getIdentity());
    $resourceEvent->setRequest($this->getServiceLocator()->get('Request'));

    $queryManager = $this->getServiceLocator()->get('ZfApigilityDoctrineQueryProviderManager');
    $queryProvider = $queryManager->get($instance->getQueryProviderAlias());
    $queryProvider->setObjectManager($entityManager);

    $instance
        ->setResourceEvent($resourceEvent)
        ->setQueryProvider($queryProvider)
        ;
}
```


Repository Configuration
------------------------

To attach a Query Provider to a repository you must create implement `ZF\Doctrine\Query\Provider\QueryProviderAwareInterface`
and use the trait `ZF\Doctrine\Query\Provider\QueryProviderAwareTrait` on each repository or an abstract your repositories inherit
from.

Next you must have a Query Provider for each repository.  These are part of
[zfcampus/zf-apigility-doctrine](https://github.com/zfcampus/zf-apigility-doctrine) and the creation of each is outside the scope
of this `README`.

For each repository you wish to use with a Query Provider add this function:

```php
    public function getQueryProviderAlias()
    {
        return 'Database\Query\Provider\ProjectQueryProvider';
    }
```

of course replacing the return value with the service locator alias for your Query Provider.


Use
---

These functions mirror the default functions `find`, `findOneBy`, `findBy`, and `findAll`.

Return an entity by id or null
```php
$objectManager
    ->getRepository('Database\Entity\Project')
    ->findWithQueryProvider($id)
    ;
```

Return one entity based on filters
```php
$objectManager
    ->getRepository('Database\Entity\Project')
    ->findOneByWithQueryProvider([
        'name' => $name
    );
```

Return an array of entities based on filters
```php
$objectManager
    ->getRepository('Database\Entity\Project')
    ->findByWithQueryProvider([
        'name' => $name
    );
```

Return all entities the Query Provider provides
```php
$objectManager
    ->getRepository('Database\Entity\Project')
    ->findAll()
    ;
```
