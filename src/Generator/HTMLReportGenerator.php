<?php

namespace Ivpel\VigilantReporter\Generator;

use Ivpel\VigilantReporter\HTMLComponents\HTMLComponents;
use Ivpel\VigilantReporter\Builder\HTMLReportBuilder;

class HTMLReportGenerator
{
    public static function generateHtmlReport($reportLocation, $reportName = 'Report')
    {
        $htmlReportFile = fopen(__DIR__ . '/../../'. HTMLReportBuilder::getFormattedProjectName($reportLocation). $reportName .date("Y-m-d-H:i:s").'.html', 'w');
        fwrite($htmlReportFile, HTMLComponents::pageHeaderComponent());
        fwrite($htmlReportFile, HTMLReportBuilder::getSummaryReportOverview($reportLocation));
        foreach (HTMLReportBuilder::getSuiteResults($reportLocation) as $suite) {
            fwrite($htmlReportFile, $suite);
        }
        fwrite($htmlReportFile, HTMLComponents::pageFooterComponent());
        fclose($htmlReportFile);
    }
}
