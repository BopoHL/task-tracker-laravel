<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->index()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->unsignedBigInteger('assigner_id')->nullable()->index();
            $table->foreign('assigner_id')->references('id')->on('users')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('task_name')->index();
            $table->string('task_description')->nullable();
            $table->enum('status', ['not_started', 'in_progress', 'done', 'pause'])->default('not_started')->index();
            $table->enum('priority', ['low', 'medium', 'high'])->nullable()->index();
            $table->date('deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
