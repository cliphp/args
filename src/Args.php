<?php declare(strict_types=1);

namespace Cliphp;

/**
 * Class Args
 *
 * @package Cliphp
 */
class Args implements \Countable
{
    /**
     * Maximum amount of iterations to perform on CLI arguments
     */
    private const MAX_ARGS = 1024;

    /**
     * @var array $args Associative array of CLI arguments
     */
    protected $args = [];

    /**
     * Args constructor.
     */
    public function __construct()
    {
        // Parse the CLI arguments
        $this->args = $this->parseArgs();
    }

    /**
     * Returns value of an argument.
     *
     * @param string $arg
     *
     * @return mixed|null
     */
    public function get(string $arg)
    {
        return $this->args[$arg] ?? null;
    }

    /**
     * Checks for existence of an argument.
     *
     * @param string $arg
     *
     * @return boolean
     */
    public function has(string $arg): bool
    {
        return isset($this->args[$arg]);
    }

    /**
     * Get all of the arguments.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->args;
    }

    /**
     * Get count of arguments.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->args);
    }

    /**
     * Parse arguments and return an associative array.
     *
     * Note: Script name will be removed from the argument list
     *
     * @return array
     */
    protected function parseArgs(): array
    {
        global $argc, $argv;
        $argvCopy = $argv;

        if ($argc > 1) {
            // Shift script name from $argv
            array_shift($argvCopy);
        }

        $i = 0;
        $args = [];
        while ($i < self::MAX_ARGS && isset($argvCopy[$i])) {
            // Set current and next argument values
            $current = $argvCopy[$i];
            $next = $argvCopy[$i + 1] ?? null;

            // If the current argument starts with -
            if (preg_match('/^-+(.+)$/', $current, $matches) === 1) {
                if (preg_match('/^-+(.+)\=(.+)$/', $current, $subMatches) === 1) {
                    // Match argument with associated value after = (e.g. arg=value)
                    $args[$subMatches[1]] = $subMatches[2];
                } elseif (!is_null($next) && preg_match('/^[^-\=]+$/', $next) === 1) {
                    // Match argument with next argument
                    $args[$matches[1]] = $next;
                    $i++;
                } else {
                    // Argument is a flag
                    $args[$matches[1]] = true;
                }
            } else {
                // Argument is a flag
                $args[$current] = true;
            }

            // Next argument
            $i++;
        }

        return $args;
    }
}
