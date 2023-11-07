<?php
declare(strict_types=1);

namespace App\Oro\ChainCommandBundle\Enum;

enum CommandPriority: string
{
    case MAIN   = 'main';
    case MEMBER = 'member';
}