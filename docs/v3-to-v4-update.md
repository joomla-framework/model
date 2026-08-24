# Updating from v3 to v4

Release 4.0.0 raises the PHP requirement. Nothing else changed in `src/`.

## At a glance

| | v3 (3.0.1) | v4 (4.0.0) |
|---|---|---|
| PHP | `^8.1.0` | `^8.3.0` |
| Public API | — | unchanged |

## Minimum supported PHP version raised

All Framework packages now require **PHP 8.3** or newer.

## No API changes

`git diff 3.0.1 HEAD -- src/` is empty. Both interfaces and both traits are byte-for-byte identical
to 3.0.1, so upgrading is a matter of satisfying the PHP requirement and updating the optional
packages.

## Dependency changes

| Package | v3 (3.0.1) | v4 (4.0.0) |
|---|---|---|
| `php` | `^8.1.0` | `^8.3.0` |

The optional packages in `suggest` moved to their 4.x releases:

| Package | v3 | v4 |
|---|---|---|
| `joomla/database` | `^3.0` | `^4.0` |
| `joomla/registry` | `^3.0` | `^4.0` |

Both remain in `suggest` rather than `require`, even though the interfaces and traits type hint
them. Install them explicitly — see [the overview](overview.md#things-to-know-before-you-build-on-this).
