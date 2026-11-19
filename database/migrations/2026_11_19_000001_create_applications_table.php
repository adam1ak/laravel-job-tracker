<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('company');
            $table->string('position');
            $table->string('url', 2048)->nullable();
            $table->string('source');
            $table->string('work_mode')->default('unknown');
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('status');
            $table->date('applied_at')->nullable();
            $table->date('follow_up_at')->nullable();
            $table->timestamp('follow_up_reminded_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'applied_at']);
            $table->index('follow_up_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
