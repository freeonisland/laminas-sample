<?php

namespace LmConsole\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ModelGenerateCrud extends Command
{
    function execute(InputInterface $input, OutputInterface $output): int
    {
        return 1;
    }

    function getDescription()
    {

    }
}