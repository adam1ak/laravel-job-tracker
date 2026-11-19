<?php

declare(strict_types=1);

use App\Enums\ApplicationStatus;

it('allows valid status transitions', function (ApplicationStatus $from, ApplicationStatus $to): void {
    expect($from->canTransitionTo($to))->toBeTrue();
})->with([
    'saved -> applied' => [ApplicationStatus::Saved, ApplicationStatus::Applied],
    'saved -> withdrawn' => [ApplicationStatus::Saved, ApplicationStatus::Withdrawn],

    'applied -> screening' => [ApplicationStatus::Applied, ApplicationStatus::Screening],
    'applied -> interview' => [ApplicationStatus::Applied, ApplicationStatus::Interview],
    'applied -> rejected' => [ApplicationStatus::Applied, ApplicationStatus::Rejected],
    'applied -> withdrawn' => [ApplicationStatus::Applied, ApplicationStatus::Withdrawn],

    'screening -> interview' => [ApplicationStatus::Screening, ApplicationStatus::Interview],
    'screening -> rejected' => [ApplicationStatus::Screening, ApplicationStatus::Rejected],
    'screening -> withdrawn' => [ApplicationStatus::Screening, ApplicationStatus::Withdrawn],

    'interview -> offer' => [ApplicationStatus::Interview, ApplicationStatus::Offer],
    'interview -> rejected' => [ApplicationStatus::Interview, ApplicationStatus::Rejected],
    'interview -> withdrawn' => [ApplicationStatus::Interview, ApplicationStatus::Withdrawn],

    'offer -> accepted' => [ApplicationStatus::Offer, ApplicationStatus::Accepted],
    'offer -> rejected' => [ApplicationStatus::Offer, ApplicationStatus::Rejected],
    'offer -> withdrawn' => [ApplicationStatus::Offer, ApplicationStatus::Withdrawn],
]);

it('rejects invalid status transitions', function (ApplicationStatus $from, ApplicationStatus $to): void {
    expect($from->canTransitionTo($to))->toBeFalse();
})->with([
    'saved -> saved' => [ApplicationStatus::Saved, ApplicationStatus::Saved],
    'saved -> screening' => [ApplicationStatus::Saved, ApplicationStatus::Screening],
    'saved -> interview' => [ApplicationStatus::Saved, ApplicationStatus::Interview],
    'saved -> offer' => [ApplicationStatus::Saved, ApplicationStatus::Offer],
    'saved -> rejected' => [ApplicationStatus::Saved, ApplicationStatus::Rejected],

    'applied -> saved' => [ApplicationStatus::Applied, ApplicationStatus::Saved],
    'applied -> applied' => [ApplicationStatus::Applied, ApplicationStatus::Applied],
    'applied -> offer' => [ApplicationStatus::Applied, ApplicationStatus::Offer],
    'applied -> accepted' => [ApplicationStatus::Applied, ApplicationStatus::Accepted],

    'screening -> applied' => [ApplicationStatus::Screening, ApplicationStatus::Applied],
    'screening -> offer' => [ApplicationStatus::Screening, ApplicationStatus::Offer],

    'interview -> screening' => [ApplicationStatus::Interview, ApplicationStatus::Screening],
    'interview -> accepted' => [ApplicationStatus::Interview, ApplicationStatus::Accepted],

    'offer -> interview' => [ApplicationStatus::Offer, ApplicationStatus::Interview],
    'offer -> offer' => [ApplicationStatus::Offer, ApplicationStatus::Offer],
]);

it('does not allow any transitions from terminal statuses', function (ApplicationStatus $terminal): void {
    expect($terminal->allowedTransitions())->toBe([]);

    foreach (ApplicationStatus::cases() as $target) {
        expect($terminal->canTransitionTo($target))->toBeFalse();
    }
})->with([
    'accepted' => [ApplicationStatus::Accepted],
    'rejected' => [ApplicationStatus::Rejected],
    'withdrawn' => [ApplicationStatus::Withdrawn],
]);
