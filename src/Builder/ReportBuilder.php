<?php

namespace Ivpel\VigilantReporter\Builder;

use Ivpel\VigilantReporter\HTMLComponents\HTMLComponents;

class ReportBuilder
{
    public static function loader($reportLocation)
    {
        return simplexml_load_file(__DIR__ . '/../../' . $reportLocation);
    }

    public static function getFormattedProjectName($reportLocation): ?string
    {
        $xml = self::loader($reportLocation);
        $total = $xml->testsuite;
        $projectTestsFullPath = explode('/', $total['name']);
        return array_pop($projectTestsFullPath);
    }

    public static function getSummaryReportOverview($reportLocation): string
    {
        $xml = self::loader($reportLocation);
        $total = $xml->testsuite;
        return HTMLComponents::summaryReportOverviewComponent('ReportName',$total);
    }

    /**
     * Principle of construction - build HTML document layer by layer pushing each layer to array in correct order.
     * Then this array will be written in to HTML file.
     *
     * Start with empty array $cases = [];
     * Array $cases will be container for our HTML elements. Each element of that array is some HTML tag/block/element
     * which include report information. Image this as layers - each element of array is layer
     * adhering to the structure of HTML document.
     * As result this methods will return array. When this array will be written to the file layer by layer
     * we will receive HTML structured entity.
     *
     * @param $reportLocation
     * @return array
     */
    public static function getSuiteResults($reportLocation): array
    {
        $xml = self::loader($reportLocation);
        $cases = [];

        /**
         * Parse available test suites (each {name}Test.php file is a test suite)
         * <testsuites>
         *      <testsuite>
         *          <testsuite> as $suite
         */
        foreach ($xml->testsuite->testsuite as $suite) {

            // Start suite block by insert <div> block which will be container for table with test cases info
            array_push($cases, HTMLComponents::suiteHeaderComponent($suite));

            /**
             * Each {name}Test.php has test cases inside it which can have different attributes,
             * child elements, etc. For more details see junit xml format.
             * <testsuite>
             *      <testcase>
             *          ...
             */
            if (isset($suite->testcase)) {
                // Inserting <table> tag with head and headers for suite result
                array_push($cases, HTMLComponents::suiteTableHeadComponent());

                foreach ($suite->testcase as $case) {
                    // Setting Test Case name by insert name attribute from <testcase> layer
                    array_push($cases,'<tr><td style="width: 80%;">' . $case['name']);

                    // Parse <testcase> tag for child tags, if exist - insert them in to the HTML table.
                    if (isset($case->failure)) {
                        array_push($cases, HTMLComponents::caseStatusErrorOrFailure('Failure'));
                        array_push($cases, HTMLComponents::articleFailureComponent($case));
                    }
                    elseif (isset($case->error)) {
                        array_push($cases, HTMLComponents::caseStatusErrorOrFailure('Error'));
                        array_push($cases, HTMLComponents::articleErrorComponent($case));
                    }
                    elseif (isset($case->warning)) {
                        array_push($cases, HTMLComponents::caseStatusWarning());
                        array_push($cases, HTMLComponents::articleWarningComponent($case));
                    }
                    elseif (isset($case->skipped)) {
                        array_push($cases, HTMLComponents::caseStatusSkipped());
                    } else {
                        array_push($cases, HTMLComponents::caseStatusOK());
                    }

                    // Check if <testcase> has <system-out> child tag and insert it in to the HTML table.
                    if (isset($case->{'system-out'})){
                        array_push($cases, HTMLComponents::articleCommonComponent($case));
                    }

                    // Close test case main table cell
                    array_push($cases, '</td>');

                    // Insert assertions and time attributes of <testcase> tag in to the array as part of the HTML table
                    array_push($cases, '<td>' . $case['assertions'] . '</td>
                                                       <td>' . $case['time'] . '</td></tr>');
                }
            }

            if (isset($suite->testsuite->testcase)) {
                foreach ($suite->testsuite->testcase as $case) {
                    // Setting Test Case name by insert name attribute from <testcase> layer
                    array_push($cases,'<tr><td style="width: 80%;">' . $case['name']);

                    // Parse <testcase> tag for child tags, if exist - insert them in to the HTML table.
                    if (isset($case->failure)) {
                        array_push($cases, HTMLComponents::caseStatusErrorOrFailure('Failure'));
                        array_push($cases, HTMLComponents::articleFailureComponent($case));
                    }
                    elseif (isset($case->error)) {
                        array_push($cases, HTMLComponents::caseStatusErrorOrFailure('Error'));
                        array_push($cases, HTMLComponents::articleErrorComponent($case));
                    }
                    elseif (isset($case->warning)) {
                        array_push($cases, HTMLComponents::caseStatusWarning());
                        array_push($cases, HTMLComponents::articleWarningComponent($case));
                    }
                    elseif (isset($case->skipped)) {
                        array_push($cases, HTMLComponents::caseStatusSkipped());
                    }
                    else {
                        array_push($cases, HTMLComponents::caseStatusOK());
                    }

                    // Check if <testcase> has <system-out> child tag and insert it in to the HTML table.
                    if (isset($case->{'system-out'})){
                        array_push($cases, HTMLComponents::articleCommonComponent($case));
                    }

                    // Close test case main table cell
                    array_push($cases, '</td>');

                    // Insert assertions and time attributes of <testcase> tag in to the array as part of the HTML table
                    array_push($cases, '<td>' . $case['assertions'] . '</td>
                                                       <td>' . $case['time'] . '</td></tr>');
                }
            }
            // Insert closing tags for HTML table
            array_push($cases, '</tbody></table></details>');

            // End of Suite block
            // Insert last closing tag for Suite block
            array_push($cases, '</div>');
        }
        return $cases;
    }
}
