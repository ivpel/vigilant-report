<?php

namespace Ivpel\VigilantReporter\HTMLComponents;

class HTMLComponents
{
    public static function pageHeaderComponent(): string
    {
        return
            '<!doctype html>
            <html lang="en">
               <head>
                 <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
                 <meta content="utf-8" http-equiv="encoding">
                 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
                 <style>
                      .block:not(:last-child), .box:not(:last-child), .breadcrumb:not(:last-child), .content:not(:last-child), .highlight:not(:last-child), .level:not(:last-child), .message:not(:last-child), .notification:not(:last-child), .pagination:not(:last-child), .progress:not(:last-child), .subtitle:not(:last-child), .table-container:not(:last-child), .table:not(:last-child), .tabs:not(:last-child), .title:not(:last-child) { margin-bottom: 0.5rem; }
                      .message-header + .message-body {white-space: pre-wrap; max-height: 550px; overflow-y: auto;}
                      article {margin-top: 3px;}
                 </style>
                 <title>Report</title>
               </head>
               <body>
                 <div class="container is-fluid">';
    }

    public static function pageFooterComponent(): string
    {
        return ' 
         </div>
            </body>
        </html>';
    }

    public static function summaryReportOverviewComponent(string $projectName, $items): string
    {
        return '<div class="card">
          <header class="card-header">
            <p class="card-header-title title">
              Project: '. $projectName . '<br>
            </p>
          </header>
            <div class="card-content">
                 <p class="subtitle">
                  Summary overview
                </p>
                <p >
                  Report generated at: '. date("Y-m-d H:i:s") .'
                </p>
            <div class="content">
              <table class="table">
                <thead>
                    <tr>
                        <th>Tests</th>
                        <th>Assertions</th>
                        <th>Warnings</th>
                        <th>Skipped</th>
                        <th>Errors</th>
                        <th>Failures</th>
                        <th>Total time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>'. $items['tests'] .'</td>
                        <td class="has-background-success-light">'. $items['assertions'] .'</td>
                        <td class="has-background-warning-light">'. $items['warnings'] .'</td>
                        <td class="has-background-link-light">'. $items['skipped'] .'</td>
                        <td class="has-background-danger-light">'. $items['errors'] .'</td>
                        <td class="has-background-danger-light">'. $items['failures'] .'</td>
                        <td class="has-background-info-light">'. $items['time'] . '</td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>';
    }

    public static function suiteTableHeadComponent(): string
    {
        return
            '<details>
                <summary>Report details</summary>
            <table class="table"><thead>
               <tr>
                 <th><abbr title="Position">Case</abbr></th>
                 <th>Assertions</th>
                 <th>Time</th>
               </tr>
            </thead><tbody>';
    }

    public static function suiteHeaderComponent($items): string
    {
        return
            '<div class="box content">' . '<h3>Suite: '. $items['name'] .'</h3><div class="columns">' .
            '<div class="column"><strong> Tests executed: </strong>' . $items['tests']. '</div>'.
            '<div class="column has-text-success-dark"><strong> Assertions: </strong>' . $items['assertions']. '</div>'.
            '<div class="column has-text-warning-dark"><strong> Warnings: </strong>' . $items['warnings']. '</div>'.
            '<div class="column has-text-link-dark"><strong> Skipped: </strong>' . $items['skipped']. '</div>'.
            '<div class="column has-text-danger-dark"><strong> Errors: </strong>' . $items['errors']. '</div>'.
            '<div class="column has-text-danger-dark"><strong> Failures: </strong>' . $items['failures']. '</div>'.
            '<div class="column"><strong> Time: </strong>' . $items['time'] . '</div>'
            . '</div>';
    }

    public static function articleCommonComponent($items): string
    {
        return
            '<article class="message is-small">
            <details>
              <summary class="message-header" style="display: flow-root list-item;">
                 Logging output
              </summary>
              <div class="message-body">
               '. $items->{'system-out'}. '
              </div>
            </details>
         </article>';
    }

    public static function articleFailureComponent($items): string
    {
        return
            '<article class="message is-danger is-small">
            <details>
              <summary class="message-header" style="display: flow-root list-item;">
                 Failure '. $items->failure['type'] .'
              </summary>
              <div class="message-body">
               '. $items->failure. '
              </div>
            </details>
        </article>';
    }

    public static function articleWarningComponent($items): string
    {
        return
            '<article class="message is-warning is-small">
            <details>
              <summary class="message-header" style="display: flow-root list-item;">
                 Warning '. $items->warning['type'] .'
              </summary>
              <div class="message-body">
               '. $items->warning. '
              </div>
            </details>
        </article>';
    }

    public static function articleErrorComponent($items): string
    {
        return
            '<article class="message is-danger is-small">
            <details>
              <summary class="message-header" style="display: flow-root list-item;">
                 Error '. $items->error['type'] .'
              </summary>
              <div class="message-body">
               '. $items->error. '
              </div>
            </details>
        </article>';
    }

    public static function caseStatusOK(): string
    {
        return '<span class="is-pulled-right has-background-success has-text-white" style="padding: 0px 30px 0px 30px;border-radius: 5px;">OK</span>';
    }

    public static function caseStatusErrorOrFailure($status): string
    {
        return '<span class="is-pulled-right has-background-danger has-text-white" style="padding: 0px 30px 0px 30px;border-radius: 5px;">'.$status.'</span>';
    }

    public static function caseStatusWarning(): string
    {
        return '<span class="is-pulled-right has-background-warning has-text-white" style="padding: 0px 30px 0px 30px;border-radius: 5px;">Warning</span>';
    }
}
