<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ApplicationSource;
use App\Enums\ApplicationStatus;
use App\Enums\WorkMode;
use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $salaryMin = fake()->boolean(70) ? fake()->numberBetween(6, 15) * 1000 : null;
        $salaryMax = $salaryMin !== null ? $salaryMin + fake()->numberBetween(2, 6) * 1000 : null;

        return [
            'user_id' => User::factory(),
            'company' => fake()->company(),
            'position' => fake()->jobTitle(),
            'url' => fake()->optional()->url(),
            'source' => fake()->randomElement(ApplicationSource::cases()),
            'work_mode' => fake()->randomElement(WorkMode::cases()),
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'currency' => $salaryMin !== null ? 'PLN' : null,
            'status' => ApplicationStatus::Saved,
            'applied_at' => null,
            'follow_up_at' => null,
            'follow_up_reminded_at' => null,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function applied(): static
    {
        return $this->withStatus(ApplicationStatus::Applied);
    }

    public function withStatus(ApplicationStatus $status): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => $status,
            'applied_at' => $status === ApplicationStatus::Saved
                ? null
                : now()->subDays(fake()->numberBetween(1, 14))->toDateString(),
        ]);
    }
}
