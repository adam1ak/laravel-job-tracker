<?php

declare(strict_types=1);

namespace App\Enums;

enum ApplicationStatus: string
{
    case Saved = 'saved';
    case Applied = 'applied';
    case Screening = 'screening';
    case Interview = 'interview';
    case Offer = 'offer';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Withdrawn = 'withdrawn';

    /**
     * @return list<self>
     */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::Saved => [self::Applied, self::Withdrawn],
            self::Applied => [self::Screening, self::Interview, self::Rejected, self::Withdrawn],
            self::Screening => [self::Interview, self::Rejected, self::Withdrawn],
            self::Interview => [self::Offer, self::Rejected, self::Withdrawn],
            self::Offer => [self::Accepted, self::Rejected, self::Withdrawn],
            self::Accepted, self::Rejected, self::Withdrawn => [],
        };
    }

    public function canTransitionTo(self $next): bool
    {
        return in_array($next, $this->allowedTransitions(), true);
    }
}
