<?php

namespace Ivpel\VigilantReporter\Generator;

use Ivpel\VigilantReporter\HTMLComponents\HTMLComponents;
use Ivpel\VigilantReporter\Builder\ReportBuilder;

class ReportGenerator
{
    public static function generateHtmlReport($reportLocation, $reportName = 'Report')
    {
        $htmlReportFile = fopen(__DIR__ . '/../../'. ReportBuilder::getFormattedProjectName($reportLocation). $reportName .date("Y-m-d-H:i:s").'.html', 'w');
        fwrite($htmlReportFile, HTMLComponents::pageHeaderComponent());
        fwrite($htmlReportFile, ReportBuilder::getSummaryReportOverview($reportLocation));
        foreach (ReportBuilder::getSuiteResults($reportLocation) as $suite) {
            fwrite($htmlReportFile, $suite);
        }
        fwrite($htmlReportFile, HTMLComponents::pageFooterComponent());
        fclose($htmlReportFile);
    }
}
