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

        $version = PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION;

        exec(dirname(__DIR__) . '/bin/install-runkit.sh', $output, $exitCode);

        $this->assertEquals(0, $exitCode, 'Expected an exit code of 0:' . $this->quoteShellOutput($output));
        $this->assertTrue(
            (bool) preg_match('/^runkit\s/m', shell_exec('pecl list')),
            'The Runkit extension should have been loaded.'
        );
        $this->assertTrue(
            file_exists('/etc/php/' . $version . '/mods-available/runkit.ini'),
            'Expected a runkit.ini file to be created for PHP ' . $version . '.'
        );
    }

    /**
     * @requires extension runkit
     * @runInSeparateProcess
     */
    public function testRunkitFunctionsAreAvailable()
    {
        $this->assertTrue(function_exists('runkit_constant_add'));
        $this->assertTrue(function_exists('runkit_constant_remove'));
        $this->assertTrue(function_exists('runkit_function_add'));
        $this->assertTrue(function_exists('runkit_function_remove'));
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
