<?php

declare(strict_types=1);

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class BarExceptionTest extends KernelTestCase
{

    public function testExceptionExecute()
    {
        $kernel = self::bootKernel();
        $application = new Application($kernel);
        $command = $application->find('bar:hi');
        $commandTester = new CommandTester($command);
        $this->expectException(\LogicException::class);
        $commandTester->execute([]);
        $commandTester->getDisplay();
    }
}
