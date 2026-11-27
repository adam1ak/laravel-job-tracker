<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ApplicationSource;
use App\Enums\ApplicationStatus;
use App\Enums\WorkMode;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'company',
    'position',
    'url',
    'source',
    'work_mode',
    'salary_min',
    'salary_max',
    'currency',
    'status',
    'applied_at',
    'follow_up_at',
    'follow_up_reminded_at',
    'notes',
])]
class Application extends Model
{
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'source' => ApplicationSource::class,
            'work_mode' => WorkMode::class,
            'status' => ApplicationStatus::class,
            'salary_min' => 'integer',
            'salary_max' => 'integer',
            'applied_at' => 'date',
            'follow_up_at' => 'date',
            'follow_up_reminded_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<ApplicationEvent, $this>
     */
    public function events(): HasMany
    {
        return $this->hasMany(ApplicationEvent::class);
    }
}
