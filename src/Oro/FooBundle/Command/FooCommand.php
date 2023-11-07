<?php

declare(strict_types=1);

namespace App\Oro\FooBundle\Command;

use App\Oro\ChainCommandBundle\Trait\RunChainCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'foo:hello',
    description: 'Foo hello command',
    hidden: false
)]
class FooCommand extends Command
{
    use RunChainCommand;
    protected string $commandMessage = 'Hello from Foo!';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln($this->commandMessage);

        return Command::SUCCESS;
    }
}
