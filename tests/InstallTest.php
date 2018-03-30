<?php
/**
 * Tests the installation of Runkit7.
 *
 * @package SteveGrunwell\Runkit7
 */

use PHPUnit\Framework\TestCase;

class InstallTest extends TestCase
{
    public function testInstallsRunkit()
    {
        $this->assertFalse(
            extension_loaded('runkit'),
            'Expected the Runkit extension to not yet be loaded.'
        );

        exec(dirname(__DIR__) . '/bin/install-runkit.sh', $output, $exitCode);

        $this->assertEquals(0, $exitCode, 'Expected an exit code of 0:' . $this->quoteShellOutput($output));
        $this->assertTrue(
            (bool) preg_match('/^runkit\s/m', shell_exec('pecl list')),
            'The Runkit extension should have been loaded.'
        );
    }

    /**
     * @requires extension runkit
     * @testWith ["runkit_constant_add"]
     *           ["runkit_constant_remove"]
     *           ["runkit_function_add"]
     *           ["runkit_function_remove"]
     */
    public function testRunkitFunctionsAreAvailable($function)
    {
        $this->assertTrue(function_exists($function));
    }

    /**
     * Quote the output of the shell script.
     *
     * @param array $output The output captured by exec().
     *
     * @return string A string suitable for printing as a debug message.
     */
    protected function quoteShellOutput(array $output): string
    {
        $result = array_reduce($output, function ($result, $line) {
            return $result .= PHP_EOL . '    ' . $line;
        }, '');

        return PHP_EOL . "\033[0;36m$result\033[0;m" . PHP_EOL;
    }
}
