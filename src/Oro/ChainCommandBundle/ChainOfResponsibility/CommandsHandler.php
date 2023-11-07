<?php

declare(strict_types=1);

namespace App\Oro\ChainCommandBundle\ChainOfResponsibility;

use App\Oro\BarBundle\Command\BarCommand;
use App\Oro\ChainCommandBundle\Enum\CommandPriority;
use App\Oro\FooBundle\Command\FooCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;

class CommandsHandler extends Handler
{
    /**
     * Command called directly from console (not programmatically).
     */
    public ?string $commandFromConsole = '';

    /**
     * Registered commands for chain.
     * Main should include only command name as 'string'. Member can include array of command names.
     */
    public array $registeredChainCommands = ['main' => '', 'member' => []];

    /**
     * Member command setter.
     */
    public function setMemberCommands(string $commandName): void
    {
        $this->registeredChainCommands[CommandPriority::MEMBER->value][] = $commandName;
    }

    /**
     * Main command setter.
     */
    public function setMainCommand(string $commandName): void
    {
        $this->registeredChainCommands[CommandPriority::MAIN->value] = $commandName;
    }

    /**
     * Method for the command registration.
     */
    public function commandsRegistration(): void
    {
        $this->setMainCommand(FooCommand::getDefaultName());
        $this->setMemberCommands('cache:clear');
        $this->setMemberCommands(BarCommand::getDefaultName());
    }

    /**
     * key = priority, value = command name.
     */
    public function getRegisteredCommands(): array
    {
        return $this->registeredChainCommands;
    }

    /**
     * Core command fot the chain functionality execution.
     */
    public function runNextChainCommand(OutputInterface $output, string $commandTypedFromConsole, Application $application)
    {
        $memberCommands = $this->getMemberCommands();
        foreach ($memberCommands as $commandName) {
            $commandInput = new ArrayInput([
                'command' => $commandName,
            ]);

            $application->doRun($commandInput, $output);
        }
    }

    public function forgetCommandTypedFromConsole(string $commandTypedFromConsole): void
    {
        $this->registeredChainCommands[CommandPriority::MEMBER->value] = array_diff($this->getRegisteredCommands()[CommandPriority::MEMBER->value], [$commandTypedFromConsole]);
    }

    /**
     * Main command getter.
     */
    public function getMainCommand(): string
    {
        return $this->getRegisteredCommands()[CommandPriority::MAIN->value] ?? '';
    }

    /**
     * Check if Command is member of Chain.
     */
    public function isCommandMemberInChain(string $commandName): bool
    {
        return in_array($commandName, $this->getMemberCommands());
    }

    /**
     * Getter for all member commands.
     */
    public function getMemberCommands(): array
    {
        if (!isset($this->getRegisteredCommands()[CommandPriority::MAIN->value])) {
            throw new \LengthException(CommandPriority::MAIN->value.' command should be set.');
        }

        return $this->getRegisteredCommands()[CommandPriority::MEMBER->value] ?? [];
    }

    /**
     * Command run programmatically.
     */
    public function isNotSetCommandFromConsole(): bool
    {
        return strlen($this->commandFromConsole) < 1;
    }
}
