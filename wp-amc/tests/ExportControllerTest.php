<?php
namespace WpAmc\Controllers;

// Override exec in this namespace to avoid real command execution
function exec(string $command, ?array &$output = null, ?int &$return_var = null)
{
    \WpAmc\Tests\ExportControllerTest::$executedCommand = $command;
    $output = ['mock'];
    $return_var = 0;
}

namespace WpAmc\Tests;

use PHPUnit\Framework\TestCase;
use WpAmc\Controllers\ExportController;

class ExportControllerTest extends TestCase
{
    public static string $executedCommand = '';

    public function testExportResultsBuildsCommand()
    {
        $controller = new ExportController();
        $result = $controller->exportResults('/project/path', '/tmp/out.csv');

        $expected = 'AMC-export.pl --data ' . escapeshellarg('/project/path') .
            ' --o ' . escapeshellarg('/tmp/out.csv');

        $this->assertSame($expected, self::$executedCommand);
        $this->assertSame(['mock'], $result['output']);
        $this->assertSame(0, $result['status']);
    }
}
