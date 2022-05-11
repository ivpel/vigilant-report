<?php

namespace Ivpel\VigilantReporter\Generator;

use Ivpel\VigilantReporter\HTMLComponents\HTMLComponents;
use Ivpel\VigilantReporter\Builder\ReportBuilder;

class ReportGenerator
{
    public static function generateHtmlReport()
    {
        $htmlReportFile = fopen(__DIR__ . '/../../'. ReportBuilder::getFormattedProjectName().'Report'.date("Y-m-d-H:i:s").'.html', 'w');
        fwrite($htmlReportFile, HTMLComponents::pageHeaderComponent());
        fwrite($htmlReportFile, ReportBuilder::getSummaryReportOverview());
        foreach (ReportBuilder::getSuiteResults() as $suite) {
            fwrite($htmlReportFile, $suite);
        }
        fwrite($htmlReportFile, HTMLComponents::pageFooterComponent());
        fclose($htmlReportFile);
    }
}