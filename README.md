# The Model Package [![Build Status](https://github.com/joomla-framework/model/actions/workflows/ci.yml/badge.svg?branch=4.x-dev)](https://github.com/joomla-framework/model)

[![Latest Stable Version](https://poser.pugx.org/joomla/model/v/stable)](https://packagist.org/packages/joomla/model)
[![Total Downloads](https://poser.pugx.org/joomla/model/downloads)](https://packagist.org/packages/joomla/model)
[![Latest Unstable Version](https://poser.pugx.org/joomla/model/v/unstable)](https://packagist.org/packages/joomla/model)
[![License](https://poser.pugx.org/joomla/model/license)](https://packagist.org/packages/joomla/model)

The Model package provides the interfaces and traits a model class needs to hold a database driver and a state
object. It has no base class and no CRUD.

| Type | Purpose |
|---|---|
| `Joomla\Model\DatabaseModelInterface` | A model that exposes a database driver: `getDb()` |
| `Joomla\Model\DatabaseModelTrait` | Implementation of `getDb()`, plus `setDb()` |
| `Joomla\Model\StatefulModelInterface` | A model that exposes a `Joomla\Registry\Registry` state: `getState()` |
| `Joomla\Model\StatefulModelTrait` | Implementation of `getState()`, plus `setState()` |

The two pairs are independent; use one, the other, or both. The getters throw an `UnexpectedValueException` when
nothing was set, so pass the driver and the state in, for example through the constructor:

```php
use Joomla\Database\DatabaseInterface;
use Joomla\Model\DatabaseModelInterface;
use Joomla\Model\DatabaseModelTrait;
use Joomla\Model\StatefulModelInterface;
use Joomla\Model\StatefulModelTrait;
use Joomla\Registry\Registry;

final class ArticleListModel implements DatabaseModelInterface, StatefulModelInterface
{
    use DatabaseModelTrait;
    use StatefulModelTrait;

    public function __construct(DatabaseInterface $db, Registry $state)
    {
        $this->setDb($db);
        $this->setState($state);
    }

    public function getLimit(): int
    {
        return (int) $this->getState()->get('list.limit', 20);
    }
}
```

`joomla/database` and `joomla/registry` are only suggested dependencies; install the ones you use.

See the [documentation](docs/index.md) for details, and the update guides in `docs/` when upgrading between major
versions.

## Installation via Composer

Add `"joomla/model": "~4.0"` to the require block in your composer.json and then run `composer install`.

```json
{
	"require": {
		"joomla/model": "~4.0"
	}
}
```

Alternatively, you can simply run the following from the command line:

```sh
composer require joomla/model "~4.0"
```
