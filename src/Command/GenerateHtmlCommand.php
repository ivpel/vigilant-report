<?php

namespace Ivpel\VigilantReporter\Command;

use Ivpel\VigilantReporter\Generator\ReportGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateHtmlCommand extends Command
{
    protected function configure()
    {
        $this->setName('generate:html-report')
            ->setDescription('Generate report in HTML format based on Junit xml file')
            ->setHelp('This command generate HTML report based on Junit xml file and output it in to the destination')
            ->addArgument('name', InputArgument::OPTIONAL, 'Add report custom name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Generating report!');

        ReportGenerator::generateHtmlReport();
        return self::SUCCESS;
    }
}
