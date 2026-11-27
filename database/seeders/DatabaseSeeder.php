<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\ApplicationStatus;
use App\Models\Application;
use App\Models\ApplicationEvent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $statuses = [
            ApplicationStatus::Saved,
            ApplicationStatus::Applied,
            ApplicationStatus::Applied,
            ApplicationStatus::Screening,
            ApplicationStatus::Interview,
            ApplicationStatus::Offer,
            ApplicationStatus::Rejected,
        ];

        foreach ($statuses as $status) {
            $application = Application::factory()
                ->for($user)
                ->withStatus($status)
                ->create();

            ApplicationEvent::factory()
                ->for($application)
                ->create([
                    'to_status' => ApplicationStatus::Saved,
                    'occurred_at' => now()->subDays(10),
                ]);

            if ($status !== ApplicationStatus::Saved) {
                ApplicationEvent::factory()
                    ->for($application)
                    ->statusChanged(ApplicationStatus::Saved, $status)
                    ->create([
                        'occurred_at' => now()->subDays(5),
                    ]);
            }
        }
    }
}
