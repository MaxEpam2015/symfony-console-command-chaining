<?php

declare(strict_types=1);

namespace App\Oro\ChainCommandBundle\Trait;

use App\Oro\ChainCommandBundle\Enum\CommandPriority;
use App\Oro\ChainCommandBundle\Event\RunChainCommandsEvent;
use App\Oro\ChainCommandBundle\ChainOfResponsibility\CommandsHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Trait should be included to run chain functionality
 */
trait RunChainCommand
{
    private OutputInterface $output;

    public function __construct(
        private readonly CommandsHandler          $commandsHandler,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly LoggerInterface          $logger
    ) {
        parent::__construct();
    }

    /**
     * Initializes the command after the input has been bound and before the input is validated.
     */
    protected function initialize(InputInterface $input, OutputInterface $output): int
    {
        if ($this->commandsHandler->isNotSetCommandFromConsole()) {
            $this->commandsHandler->commandFromConsole = $this->getName();
        }
        $this->output = $output;
        $this->commandsHandler->commandsRegistration();

        if ($this->isCommandMemberAndFromConsole()) {
            throw new \LogicException($this->getName().' command is a member of '. $this->commandsHandler->getMainCommand() . ' command chain and cannot be executed on its own.');
        }

        if ($this->getName() === $this->commandsHandler->getMainCommand()) {
            $this->logger->info($this->getName() . ' is a '. CommandPriority::MAIN->value . ' command of a command chain that has registered member commands');
            $this->logger->info('Executing ' . $this->getName() . ' command itself first:');
            $this->logger->info($this->commandMessage);
        }

        if ($this->getName() !== $this->commandsHandler->getMainCommand()) {
            $this->logger->info($this->getName() . ' registered as a member of '. CommandPriority::MAIN->value . ' command chain');
            $this->logger->info('Executing ' . $this->commandsHandler->getMainCommand() . ' chain members:');
            $this->logger->info($this->commandMessage);
        }

        return Command::SUCCESS;
    }

    /**
     * Call in the end of any Command
     */
    public function __destruct()
    {
        $this->commandsHandler->forgetCommandTypedFromConsole($this->getName());
        $event = new RunChainCommandsEvent($this->output, $this->getName(), $this->getApplication(), $this->commandsHandler);

        $this->eventDispatcher->dispatch($event, $event::NAME);
    }

    /**
     * Command Member of chain and run directly from console
     */
    private function isCommandMemberAndFromConsole(): bool
    {
        return $this->commandsHandler->isCommandMemberInChain($this->getName()) && $this->getName() === $this->commandsHandler->commandFromConsole;
    }
}
