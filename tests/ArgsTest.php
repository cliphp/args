<?php declare(strict_types=1);

namespace Cliphp;

use PHPUnit\Framework\TestCase;

class ArgsTest extends TestCase
{
    /**
     * @covers Args::get, Args::has
     */
    public function testArgs()
    {
        // override arguments
        global $argc, $argv;
        $argv = ['scriptname', '-a', '/path/to', '-b=test.php',  '--verbose', '--setting=2', 'other'];
        $argc = count($argv);

        // create instance
        $args = new Args();

        // assert that script name was not set
        $this->assertFalse($args->has('scriptname'));

        // assert that arguments are set
        $this->assertTrue(
            $args->has('a') &&
            $args->has('b') &&
            $args->has('verbose') &&
            $args->has('setting') &&
            $args->has('other')
        );

        // assert that argument values are as expected
        $this->assertEquals($args->get('a'), '/path/to');
        $this->assertEquals($args->get('b'), 'test.php');
        $this->assertEquals($args->get('verbose'), true);
        $this->assertEquals($args->get('setting'), 2);
        $this->assertEquals($args->get('other'), true);

        // assert that missing argument is null
        $this->assertNull($args->get('missing'));
    }
}
