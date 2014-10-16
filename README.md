# hanneskod/yaysondb

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/yaysondb.svg?style=flat-square)](https://packagist.org/packages/hanneskod/yaysondb)
[![Build Status](https://img.shields.io/travis/hanneskod/yaysondb/master.svg?style=flat-square)](https://travis-ci.org/hanneskod/yaysondb)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/yaysondb.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/yaysondb)
[![Dependency Status](https://img.shields.io/gemnasium/hanneskod/yaysondb.svg?style=flat-square)](https://gemnasium.com/hanneskod/yaysondb)

Flat file db storing data as json arrays

> Install using **[composer](http://getcomposer.org/)**. Exists as
> **[hanneskod/yaysondb](https://packagist.org/packages/hanneskod/yaysondb)**
> in the **[packagist](https://packagist.org/)** repository.


## Why?

Partly as a learning exercise, partly since I needed a simple and PHP only DB 
for some cli scripts.


## Features

 * Enforces `_id` field in a manner similar to mongoDB.
 * Powerfull searches using search documents.
 * Supports limits and orderBy expressions.
 * No concurrency checks.
 * Supports loading collections from directory.


## Using the Collection class

`Collection` works on json data.

```php
use hanneskod\yaysondb\Collection;

$collection = new Collection('a string encoding a json array of data');

$collection->insert([
    '_id' => 'some-id',
    'name' => 'foobar'
]);

// Outputs the updated json structure
echo json_encode($collection);
```

Create search documents using the `Operators` class.

```php
use hanneskod\yaysondb\Operators as y;

// Find all documents with an address in new york
$result = $collection->find(
    y::doc([
        'address' => y::doc([
            'town' => y::regexp('/new york/i')
        ])
    ])
);

// The result set is iterable
foreach ($result as $id => $doc) {
    // ...
}
```

Se [Operators](/src/Operators.php) for a complete list of avaliable search operators.


## Using the DB wrapper

`Yaysondb` works as a handler for multiple collections.

```php
use hanneskod\yaysondb\Yaysondb;
use hanneskod\yaysondb\Adapter\DirectoryAdapter;

$db = new Yaysondb(new DirectoryAdapter('path-to-json-files'));

// handle to path-to-json-files/mycollection.json
$db->mycollection;

// commit collection updates
$db->commit('mycollection');
```
