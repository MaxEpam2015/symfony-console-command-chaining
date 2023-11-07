<?php

declare(strict_types=1);

namespace App\Oro\ChainCommandBundle\EventListener;

use App\Oro\ChainCommandBundle\Event\RunChainCommandsEvent;

class ChainCommandsListener
{
    public function onSuccess(RunChainCommandsEvent $runChainCommandsEvent): void
    {
        $runChainCommandsEvent->run();
    }
}
