<?php
/**
 * Tests the installation of Runkit7.
 *
 * @package SteveGrunwell\Runkit7
 */

use PHPUnit\Framework\TestCase;

class InstallTest extends TestCase
{
    private static $createdDirectories = [];

    /**
     * Get an array of all PHP versions we want to use for testing configuration.
     *
     * @return array
     */
    public static function getTestedVersions(): array
    {
        return [
            '7.0',
            '7.1',
            '7.2',
            '50.0', // Something very unlikely to exist.
        ];
    }

    /**
     * If the local filesystem doesn't have them, create mods-available directories.
     *
     * @beforeClass
     */
    public static function createModsAvailable()
    {
        foreach (self::getTestedVersions() as $version) {
            if (mkdir('/etc/php/' . $version . '/mods-available', 0777, true)) {
                self::$createdDirectories[] = '/etc/php/' . $version;
            }
        }
    }

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

        foreach (self::getTestedVersions() as $version) {
            $this->assertTrue(
                file_exists('/etc/php/' . $version . '/mods-available/runkit.ini'),
                'Expected a runkit.ini file to be created for PHP ' . $version
            );
        }
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
     * Remove directories that were only created for tests.
     *
     * @afterClass
     */
    public static function removeModsAvailable()
    {
        foreach (self::$createdDirectories as $dir) {
            unlink($dir . '/runkit.ini');
            rmdir($dir);
        }
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
