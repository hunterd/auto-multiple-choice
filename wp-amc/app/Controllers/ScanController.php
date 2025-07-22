<?php
namespace WpAmc\Controllers;

class ScanController
{
    /**
     * Run OMR analysis on scanned answer sheets.
     *
     * @param string $projectDir Path to the project directory.
     * @param string $scansDir Directory containing scanned sheets.
     * @return array{output:array,status:int}
     */
    public function analyse(string $projectDir, string $scansDir): array
    {
        $command = 'AMC-analyse.pl --project ' . escapeshellarg($projectDir)
            . ' --crdir ' . escapeshellarg($scansDir);
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);
        return ['output' => $output, 'status' => $returnVar];
    }
}
