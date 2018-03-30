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
            extension_loaded('runkit'),
            'The Runkit extension should have been loaded.'
        );
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