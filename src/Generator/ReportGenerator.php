<?php

namespace Ivpel\VigilantReporter\Generator;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ReportGenerator
{
    public static function generate($reportName)
    {
        $loader = new FilesystemLoader(realpath(__DIR__ . '/../Templates'));
        $twig = new Environment($loader);
        $htmlReportFile = fopen(__DIR__ . '/../../' . $reportName .date("Y-m-d-H:i:s").'.html', 'w');

        $twigTemplate = $twig->render(
            'report.html.twig', [
                'name' => 'John Doe',
                'occupation' => 'gardener'
            ]);

        fwrite($htmlReportFile, $twigTemplate);
    }
}