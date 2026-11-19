<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_events', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->string('type');
            $table->string('from_status')->nullable();
            $table->string('to_status')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();

            $table->index(['application_id', 'occurred_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_events');
    }
};
