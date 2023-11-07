<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Oro\ChainCommandBundle\ChainOfResponsibility\CommandsHandler;
use App\Oro\ChainCommandBundle\Enum\CommandPriority;
use PHPUnit\Framework\TestCase;

class CommandsHandlerTest extends TestCase
{
    public function testRegisteredMemberCommandsEmptyArray()
    {
        $commandHandler = new CommandsHandler();
        $this->assertCount(0, $commandHandler->getRegisteredCommands()[CommandPriority::MEMBER->value]);
    }

    public function testTwoRegisteredCommands()
    {
        $commandHandler = new CommandsHandler();
        $commandHandler->commandsRegistration();
        $this->assertCount(2, $commandHandler->getRegisteredCommands());
        $this->assertArrayHasKey(CommandPriority::MAIN->value, $commandHandler->getRegisteredCommands());
        $this->assertArrayHasKey(CommandPriority::MEMBER->value, $commandHandler->getRegisteredCommands());
    }
}
