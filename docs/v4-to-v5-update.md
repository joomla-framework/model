# Updating from v4 to v5

Release 5.0.0 adds native types to both interfaces and both traits, and declares the setters on the
interfaces.

## At a glance

| | v4 | v5 |
|---|---|---|
| `DatabaseModelInterface` | `getDb()` | `getDb(): DatabaseInterface`, `setDb(DatabaseInterface $db): void` |
| `StatefulModelInterface` | `getState()` | `getState(): Registry`, `setState(Registry $state): void` |
| Trait properties | untyped | `?DatabaseInterface $db = null`, `?Registry $state = null` |

## Native types on the interfaces and traits

The interfaces and traits now declare their types natively:

| Method | v4 | v5 |
|---|---|---|
| `getDb()` | untyped | `getDb(): DatabaseInterface` |
| `setDb()` | `setDb(DatabaseInterface $db)` | `setDb(DatabaseInterface $db): void` |
| `getState()` | untyped | `getState(): Registry` |
| `setState()` | `setState(Registry $state)` | `setState(Registry $state): void` |

Classes that use the traits need no change. Classes that implement an interface themselves, or
override a trait method, have to add the return types.

## The setters are declared on the interfaces

`DatabaseModelInterface` now declares `setDb()` and `StatefulModelInterface` declares `setState()`.
Classes that use the traits already have them. Classes that implement an interface without the
trait have to add the setter:

```php
// v5
final class ArticleModel implements DatabaseModelInterface
{
    private ?DatabaseInterface $db = null;

    public function getDb(): DatabaseInterface
    {
        return $this->db ?? throw new \UnexpectedValueException('Database driver not set in ' . static::class);
    }

    public function setDb(DatabaseInterface $db): void
    {
        $this->db = $db;
    }
}
```

## Typed trait properties

`DatabaseModelTrait::$db` is now `protected ?DatabaseInterface $db = null` and
`StatefulModelTrait::$state` is `protected ?Registry $state = null`. A class that uses a trait and
declares the same property itself (for example `protected $db;`) now fails with a fatal error,
because PHP requires both declarations to be compatible. Remove the property from the class, or
declare it exactly as the trait does.
