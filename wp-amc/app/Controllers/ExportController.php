<?php
namespace WpAmc\Controllers;

class ExportController
{
    /**
     * Export marks for an AMC project.
     *
     * @param string $projectDir Path to the project directory.
     * @param string $outputFile Destination CSV file.
     * @return array{output:array,status:int}
     */
    public function exportResults(string $projectDir, string $outputFile): array
    {
        $command = 'AMC-export.pl --data ' . escapeshellarg($projectDir)
            . ' --o ' . escapeshellarg($outputFile);
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);
        return ['output' => $output, 'status' => $returnVar];
    }
}
