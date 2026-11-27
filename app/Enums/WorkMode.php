<?php

declare(strict_types=1);

namespace App\Enums;

enum WorkMode: string
{
    case Remote = 'remote';
    case Hybrid = 'hybrid';
    case Office = 'office';
    case Unknown = 'unknown';
}
