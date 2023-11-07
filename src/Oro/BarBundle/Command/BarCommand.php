<?php

declare(strict_types=1);

namespace App\Oro\BarBundle\Command;

use App\Oro\ChainCommandBundle\Trait\RunChainCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'bar:hi',
    description: 'Bar hi command',
    hidden: false
)]
class BarCommand extends Command
{
    use RunChainCommand;

    protected string $commandMessage = 'Hi from Bar!';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln($this->commandMessage);

        return Command::SUCCESS;
    }
}
