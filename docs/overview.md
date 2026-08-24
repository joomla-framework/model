# Overview

The Model package provides the interfaces and traits a model class needs to hold a database
connection and a state object. It is deliberately minimal: two interfaces, two traits, no base
class and no CRUD.

```bash
composer require joomla/model
```

## What is in the package

| Type | Purpose |
|---|---|
| `Joomla\Model\DatabaseModelInterface` | A model that exposes a database driver — `getDb()` |
| `Joomla\Model\DatabaseModelTrait` | Implementation, plus `setDb()` |
| `Joomla\Model\StatefulModelInterface` | A model that exposes a state object — `getState()` |
| `Joomla\Model\StatefulModelTrait` | Implementation, plus `setState()` |

The two pairs are independent. Use one, the other, or both.

## A database backed model

```php
use Joomla\Database\DatabaseInterface;
use Joomla\Model\DatabaseModelInterface;
use Joomla\Model\DatabaseModelTrait;

final class ArticleModel implements DatabaseModelInterface
{
    use DatabaseModelTrait;

    public function __construct(DatabaseInterface $db)
    {
        $this->setDb($db);
    }

    public function findById(int $id): ?object
    {
        $db    = $this->getDb();
        $query = $db->createQuery()
            ->select('*')
            ->from($db->quoteName('#__content'))
            ->where($db->quoteName('id') . ' = :id')
            ->bind(':id', $id, \Joomla\Database\ParameterType::INTEGER);

        return $db->setQuery($query)->loadObject();
    }
}
```

`getDb()` throws an `UnexpectedValueException` when no driver was set, so a model that was built
incompletely fails at the point of use with a message naming the class.

## A stateful model

State is a `Joomla\Registry\Registry`, which gives you dot notation and defaults:

```php
use Joomla\Model\StatefulModelInterface;
use Joomla\Model\StatefulModelTrait;
use Joomla\Registry\Registry;

final class ArticleListModel implements StatefulModelInterface
{
    use StatefulModelTrait;

    public function __construct(Registry $state)
    {
        $this->setState($state);
    }

    public function getLimit(): int
    {
        return (int) $this->getState()->get('list.limit', 20);
    }
}
```

`getState()` throws an `UnexpectedValueException` when no state was set. It does **not** lazily
create an empty `Registry`, so every stateful model has to be given one.

## Combining both

```php
final class ArticleListModel implements DatabaseModelInterface, StatefulModelInterface
{
    use DatabaseModelTrait;
    use StatefulModelTrait;

    public function __construct(DatabaseInterface $db, Registry $state)
    {
        $this->setDb($db);
        $this->setState($state);
    }
}
```

## Things to know before you build on this

**The dependencies are optional at install time but mandatory at runtime.** `joomla/database` and
`joomla/registry` are listed under `suggest`, not `require`, yet both interfaces and traits type
hint them. Install what you use:

```bash
composer require joomla/model joomla/database joomla/registry
```

**The setters are not part of the interfaces.** `DatabaseModelInterface` declares only `getDb()`,
`StatefulModelInterface` only `getState()`. `setDb()` and `setState()` come from the traits. Code
that receives a `DatabaseModelInterface` therefore cannot inject a driver in a type safe way —
prefer constructor injection, as in the examples above.

**Exception messages name the wrong class in a hierarchy.** Both traits build the message with
`__CLASS__`, which resolves to the class that *uses* the trait, not to the runtime class. If `B`
extends `A` and `A` uses the trait, an incomplete `B` reports `A`.

## What this package does not do

This package is a pair of building blocks, not a model layer:

* No `ModelInterface` base type — the two interfaces are unrelated.
* No CRUD, no pagination, no filtering conventions, no result hydration.
* No validation and no form handling.
* No events — there is no `beforeSave`/`afterSave` hook.

For persistence, combine it with `joomla/database` and write repository or model classes that suit
your application, as in the examples above.
