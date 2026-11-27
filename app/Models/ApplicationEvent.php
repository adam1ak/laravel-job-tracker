<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ApplicationEventType;
use App\Enums\ApplicationStatus;
use Database\Factories\ApplicationEventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'application_id',
    'type',
    'from_status',
    'to_status',
    'note',
    'occurred_at',
])]
class ApplicationEvent extends Model
{
    /** @use HasFactory<ApplicationEventFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ApplicationEventType::class,
            'from_status' => ApplicationStatus::class,
            'to_status' => ApplicationStatus::class,
            'occurred_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Application, $this>
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}
