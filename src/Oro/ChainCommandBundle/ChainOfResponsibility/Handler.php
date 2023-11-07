<?php

declare(strict_types=1);

namespace App\Oro\ChainCommandBundle\ChainOfResponsibility;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Output\OutputInterface;

abstract class Handler
{
    public ?string $commandFromConsole;

    public array $registeredChainCommands = ['main' => [], 'member' => []];

    abstract public function getRegisteredCommands(): array;

    abstract public function getMainCommand(): string;

    abstract public function setMainCommand(string $commandName): void;

    abstract public function setMemberCommands(string $commandName): void;

    abstract public function runNextChainCommand(OutputInterface $output, string $commandTypedFromConsole, Application $application);
}
