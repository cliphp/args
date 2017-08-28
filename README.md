# cliphp/args

Library for command line arguments.

```
use Cliphp;

$args = new Args;

// Check for --help flag
if ($args->has('help')) {
    // show help message
}

// Get limit value
$limit = $args->get('limit') ?? 100;
```