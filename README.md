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

Once installed, add `ZF\Doctrine\Repository\Query\Provider` to your list of modules inside
`config/application.config.php` or `config/modules.config.php`.

> ### zf-component-installer
>
> If you use [zf-component-installer](https://github.com/zendframework/zf-component-installer),
> that plugin will install zf-doctrine-repository-query-provider as a module for you.


Configuration
-------------

This repository plugin provides access to `find`, `findOneBy`, `findBy`, and `findAll` using the query providers already
a part of your application.

To add entities with query providers you should copy file `config/zf-doctrine-repository-query-provider.global.php.dist`
to your autoload directory and rename to `config/zf-doctrine-repository-query-provider.global.php` and add each entity
you wish to use with this plugin to that configuration.


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