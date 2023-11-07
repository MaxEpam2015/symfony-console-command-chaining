<?php

declare(strict_types=1);

namespace App\Oro\ChainCommandBundle\Event;

use App\Oro\ChainCommandBundle\ChainOfResponsibility\CommandsHandler;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\EventDispatcher\Event;

class RunChainCommandsEvent extends Event
{
    public const NAME = 'run.command.chain';

    public function __construct(
        public OutputInterface $output,
        public string $currentCommandName,
        public Application $application,
        public CommandsHandler $commandChainService
    ) {
    }

    public function run()
    {
        $this->commandChainService->runNextChainCommand($this->output, $this->currentCommandName, $this->application);
    }
}
