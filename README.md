# The Model Package [![Build Status](https://ci.joomla.org/api/badges/joomla-framework/model/status.svg?ref=refs/heads/2.0-dev)](https://ci.joomla.org/joomla-framework/model)

[![Latest Stable Version](https://poser.pugx.org/joomla/model/v/stable)](https://packagist.org/packages/joomla/model)
[![Total Downloads](https://poser.pugx.org/joomla/model/downloads)](https://packagist.org/packages/joomla/model)
[![Latest Unstable Version](https://poser.pugx.org/joomla/model/v/unstable)](https://packagist.org/packages/joomla/model)
[![License](https://poser.pugx.org/joomla/model/license)](https://packagist.org/packages/joomla/model)

## Interfaces

### `Model\ModelInterface`

`Model\ModelInterface` is an interface that requires a class to be implemented with a `getState` and a `setState` method.

## Classes

# `Model\AbstractModel`

#### Construction

The contructor for a new `Model\AbstractModel` object takes an optional `Registry` object that defines the state of the model. If omitted, an empty `Registry` object will be assigned automatically.

#### Usage

The `Model\AbstractModel` class is abstract. All requirements of the interface are already satisfied by the base class.

```php

namespace MyApp;

use Joomla\Model\AbstractModel;

/**
 * My custom model.
 *
 * @pacakge  Examples
 *
 * @since   1.0
 */
class MyModel extends AbstractModel
{
  /**
	 * Get the time.
	 *
	 * @return  integer
	 *
	 * @since   1.0
	 */
	public function getTime()
	{
		return time();
	}
}
```

# `Model\AbstractDatabaseModel`

#### Construction

`Model\AbstractDatabaseModel` is extended from `Model\AbstractModel` and the contructor takes a required `Database\DatabaseDriver` object and an optional `Registry` object.

#### Usage

The `Model\AbstractDatabaseModel` class is abstract so cannot be used directly. It forms a base for any model that needs to interact with a database.

```php

namespace MyApp

use Joomla\Model;
use Joomla\Database;

/**
 * My custom database model.
 *
 * @package  Examples
 *
 * @since   1.0
 */
class MyDatabaseModel extends Model\AbstractDatabaseModel
{
	/**
	 * Get the content count.
	 *
	 * @return  integer
	 *
	 * @since   1.0
	 * @throws  RuntimeException on database error.
	 */
	public function getCount()
	{
		// Get the query builder from the internal database object.
		$q = $this->db->getQuery(true);

		// Prepare the query to count the number of content records.
		$q->select('COUNT(*)')->from($q->qn('#__content'));

		$this->db->setQuery($q);

		// Execute and return the result.
		return $this->db->loadResult();
	}
}

try
{
	$driver = Database\DatabaseFactory::getInstance()->getDriver('mysqli');
	$model = new MyDatabaseModel($driver);
	$count = $model->getCount();
}
catch (RuntimeException $e)
{
	// Handle database error.
}
```


## Installation via Composer

Add `"joomla/model": "2.0.*@dev"` to the require block in your composer.json and then run `composer install`.

```json
{
	"require": {
		"joomla/model": "2.0.*@dev"
	}
}
```

Alternatively, you can simply run the following from the command line:

```sh
composer require joomla/model "2.0.*@dev"
```
