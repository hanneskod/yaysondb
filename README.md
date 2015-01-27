# Yaysondb

[![Packagist Version](https://img.shields.io/packagist/v/hanneskod/yaysondb.svg?style=flat-square)](https://packagist.org/packages/hanneskod/yaysondb)
[![Build Status](https://img.shields.io/travis/hanneskod/yaysondb/master.svg?style=flat-square)](https://travis-ci.org/hanneskod/yaysondb)
[![Quality Score](https://img.shields.io/scrutinizer/g/hanneskod/yaysondb.svg?style=flat-square)](https://scrutinizer-ci.com/g/hanneskod/yaysondb)
[![Dependency Status](https://img.shields.io/gemnasium/hanneskod/yaysondb.svg?style=flat-square)](https://gemnasium.com/hanneskod/yaysondb)

Flat file db storing data as json arrays

Why?
----
Partly as a learning exercise, partly since I needed a simple and PHP only DB 
for some cli scripts.

### Features

 * Enforces `_id` field in a manner similar to mongoDB.
 * Powerfull searches using search documents.
 * Supports limits and orderBy expressions.
 * No concurrency checks.
 * Supports loading collections from directory.

Installation
------------
Install using [composer](http://getcomposer.org/). Exists as
[hanneskod/yaysondb](https://packagist.org/packages/hanneskod/yaysondb)
in the [packagist](https://packagist.org/) repository:

    composer require hanneskod/yaysondb

CRUD usage
----------
[`Collection`](/src/Collection.php) works on json data.

### Create

```php
$collection = new \hanneskod\yaysondb\Collection($jsonEncodedArray);
$collection->insert(['_id' => 'some-id', 'name' => 'foobar']);
$updatedJsonContent = json_encode($collection);
```

### Read

Create search documents using the [`Operators`](/src/Operators.php) class.

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

#### The search document

The following operators are available when creating search documents:

Operator                   | Description
:------------------------- | :--------------------------------------------------------------
`doc(array $query)`        | Evaluate documents and nested subdocuments
`not(Expr $e)`             | Negate expression
`exists()`                 | Use to assert that a document key exists
`type($type)`              | Check if operand is of php type
`in(array $list)`          | Check if operand is included in list
`regexp($reg)`             | Check if operand matches regular expression
`equals($op)`              | Check if operands equals each other
`same($op)`                | Check if operands are the same
`greaterThan($op)`         | Check if supplied operand is greater than loaded operand
`greaterThanOrEquals($op)` | Check if supplied operand is greater than or equals loaded operand
`lessThan($op)`            | Check if supplied operand is less than loaded operand
`lessThanOrEquals($op)`    | Check if supplied operand is less than or equals loaded operand
`all(Expr ...$e)`          | All contained expressions must evaluate to true
`atLeastOne(Expr ...$e)`   | At least one contained expressions must evaluate to true
`exactly($c, Expr ...$e)`  | Match exact number of contained expressions evaluating to true
`none(Expr ...$e)`         | No contained expressions are allowed evaluate to true
`one(Expr ...$ex)`         | Exactly one contained expressions must evaluate to true
`listAll(Expr $e)`         | Expression must evaluate to true for each list item
`listAtLeastOne(Expr $e)`  | Expression must evaluate to true for at least one list item
`listExactly($c, Expr $e)` | Expression must evaluate to true for exact numer of items in list
`listNone(Expr $e)`        | Expression is not allowed to evaluate to true for any list item
`listOne(Expr $e)`         | Expression must evaluate to true for exactly one list item

### Update

`Collection::update()` takes two arguments. A search document and an array
of values. Documents matching the search document are updated with the supplied
values.

### Delete

`Collection::delete()` takes a search document as sole argument. Documents
matching the search document are removed.

Using the DB wrapper
--------------------
[`Yaysondb`](/src/Yaysondb.php) works as a handler for multiple collections.

```php
use hanneskod\yaysondb\Yaysondb;
use hanneskod\yaysondb\Adapter\DirectoryAdapter;

$db = new Yaysondb(new DirectoryAdapter('path-to-json-files'));

// handle to path-to-json-files/mycollection.json
$db->mycollection;

// commit collection updates
$db->commit('mycollection');
```

Credits
-------
Yaysondb is covered under the [WTFPL](http://www.wtfpl.net/)

@author Hannes Forsgård (hannes.forsgard@fripost.org)
