<?php

declare(strict_types=1);

namespace App\Enums;

enum ApplicationSource: string
{
    case JustJoin = 'justjoin';
    case NoFluff = 'nofluff';
    case Pracuj = 'pracuj';
    case LinkedIn = 'linkedin';
    case Other = 'other';
}
