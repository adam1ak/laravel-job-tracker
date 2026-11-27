<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ApplicationEventType;
use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\ApplicationEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ApplicationEvent>
 */
class ApplicationEventFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'application_id' => Application::factory(),
            'type' => ApplicationEventType::Created,
            'from_status' => null,
            'to_status' => ApplicationStatus::Saved,
            'note' => null,
            'occurred_at' => now(),
        ];
    }

    public function statusChanged(
        ApplicationStatus $from,
        ApplicationStatus $to,
        ?string $note = null,
    ): static {
        return $this->state(fn (array $attributes): array => [
            'type' => ApplicationEventType::StatusChanged,
            'from_status' => $from,
            'to_status' => $to,
            'note' => $note,
        ]);
    }

    public function note(?string $note = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'type' => ApplicationEventType::Note,
            'from_status' => null,
            'to_status' => null,
            'note' => $note ?? fake()->sentence(),
        ]);
    }
}
