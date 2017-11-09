# cliphp/args

Library for command line arguments.

```php
use Cliphp;

$args = new Args;

// Check for --help flag
if ($args->has('help')) {
    // show help message
}

// Get limit value
$limit = $args->get('limit') ?? 100;
```
### Notes

The global `$argv` variable returns the script name (e.g. index.php) as the first value in 
the array. This library will shift the script name from the arguments list.


### Available Methods

- `get(string $arg): mixed|null` Returns value of an argument or `NULL` if it doesn't exist.
- `has(string $arg): bool` Checks for existence of an argument
- `all(): array` Get all of the arguments
- `count(): int` Get count of arguments