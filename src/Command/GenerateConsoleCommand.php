<?php

namespace Ivpel\VigilantReporter\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateConsoleCommand extends Command
{
    protected function configure()
    {
        $this->setName('generate:console-report')
            ->setDescription('Generate report based on Junit xml file and output in to the Console')
            ->setHelp('This command generate report based on Junit xml file and output it in to the Console');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Test message");
        return self::SUCCESS;
    }
}