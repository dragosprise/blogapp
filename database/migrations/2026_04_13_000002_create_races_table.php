<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('races', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('venue')->nullable();
            $table->string('city')->nullable();
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->unsignedSmallInteger('season_year');
            $table->string('classes')->nullable();
            $table->string('image')->nullable();
            $table->string('tickets_url')->nullable();
            $table->string('details_url')->nullable();
            $table->string('status')->default('scheduled');
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            $table->index(['competition_id', 'season_year', 'starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('races');
    }
};

