<?php
namespace WpAmc\Controllers;

class MailingController
{
    /**
     * Send annotated answer sheets to students via email.
     *
     * @param string $projectDir Path to the project directory.
     * @param string $studentsList CSV with students emails.
     * @return array{output:array,status:int}
     */
    public function sendEmails(string $projectDir, string $studentsList): array
    {
        $command = 'AMC-mailing.pl --project ' . escapeshellarg($projectDir)
            . ' --students-list ' . escapeshellarg($studentsList);
        $output = [];
        $returnVar = 0;
        exec($command, $output, $returnVar);
        return ['output' => $output, 'status' => $returnVar];
    }
}
