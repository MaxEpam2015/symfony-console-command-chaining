<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class FooTest extends KernelTestCase
{
    public function testSuccessfulExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $command = $application->find('foo:hello');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
        $commandTester->assertCommandIsSuccessful();
    }
}
