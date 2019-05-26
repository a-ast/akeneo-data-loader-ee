# Akeneo Data Loader (EE version)

[![Build Status](https://travis-ci.org/a-ast/akeneo-data-loader-ee.svg?branch=master)](https://travis-ci.org/a-ast/akeneo-data-loader)

Akeneo Data Loader helps you to load data to your Akeneo PIM Enterprise Edition via its REST API. 

For Community Edition please check the [CE version](https://github.com/a-ast/akeneo-data-loader).

## Use cases

* Load YAML fixtures for testing, local development or performance benchmarking.
* Import from external systems (legacy PIM or regular data providers). 
* Bulk media file import.

### Examples

#### Load form array

```php

use Aa\AkeneoDataLoader\Api;
use Aa\AkeneoEnterpriseDataLoader\LoaderFactory;

$factory = new LoaderFactory();

$apiCredentials = Api\Credentials::create('https://your.akeneo.host/', 'clientId', 'secret', 'username', 'password');

$loader = $factory->createByCredentials($apiCredentials);

$loader->load('product', [
    ['identifier' => 'test-1'],
    ['identifier' => 'test-2'],
]);
```
