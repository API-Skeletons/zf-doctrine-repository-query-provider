zf-doctrine-repository-query-provider
=====================================

A plugin for [zf-doctrine-repository](https://github.com/api-skeletons/zf-doctrine-repository)
to integrate [Doctrine in Apigility](https://github.com/zfcampus/zf-apigility-doctrine)
Query Providers.

This allows you to fetch entities using the same business logic and filtering your Query Providers use.
Useful for an RPC where an entity may be required and must have access to the current user.  Can be
used throughout the application to apply business rules for entity access to the current user.

The intention of this module is to solve the problem of repeated code to validate if a user has access
to a given entity.


Installation
------------

Installation of this module uses composer. For composer documentation, please refer to [getcomposer.org](http://getcomposer.org/).

```sh
composer require api-skeletons/zf-doctrine-repository-query-provider
```


Repository Factory Configuration
--------------------------------

This repository provides an interface and trait to be applied to a Doctrine repository.  By default Doctrine uses it's own
repository factory to create repositories.  You will need to create a custom repository factory.  See the article
[Dependency Injection in Doctrine Repositories](http://blog.tomhanderson.com/2016/01/dependency-injection-in-doctrine.html)
for instructions to do this.

Once you have a factory for your repositories you will need to code the dependency injection for the provided interface.
The following code will inject the necessary dependencies:


Repository Configuration
------------------------


Use
---

These functions mirror the default functions `find`, `findOneBy`, `findBy`, and `findAll`.

Return an entity by id or null
```php
$objectManager
    ->getRepository('Database\Entity\Project')
    ->plugin('queryProvider')
    ->find($id)
    ;
```

Return one entity based on filters
```php
$objectManager
    ->getRepository('Database\Entity\Project')
    ->plugin('queryProvider')
    ->findOneBy([
        'name' => $name
    );
```

Return an array of entities based on filters
```php
$objectManager
    ->getRepository('Database\Entity\Project')
    ->plugin('queryProvider')
    ->findBy([
        'name' => $name
    );
```

Return all entities the Query Provider provides
```php
$objectManager
    ->getRepository('Database\Entity\Project')
    ->plugin('queryProvider')
    ->findAll()
    ;
```

The findBy* functions also take arguments for sorting, limit, and offset.