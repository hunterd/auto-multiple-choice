<?php
namespace WpAmc\Controllers;

class PdfController
{
    /**
     * Generate PDF layout for an AMC project.
     *
     * @param string $projectDir Path to the project directory.
     * @return array{output:array,status:int} Execution output and status code.
     */
    public function generate(string $projectDir): array
    {
        $command = 'AMC-meptex.pl --project ' . escapeshellarg($projectDir);
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);
        return ['output' => $output, 'status' => $returnVar];
    }
}
