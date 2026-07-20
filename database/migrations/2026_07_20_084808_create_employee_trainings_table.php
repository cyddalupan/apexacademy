<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('training_module_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('assigned');
            $table->foreignId('current_lesson_id')->nullable()->constrained('lessons')->nullOnDelete();
            $table->integer('failed_attempts')->default(0);
            $table->unique(['employee_id', 'training_module_id']);
            $table->timestamp('enrolled_at')->useCurrent();
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_trainings');
    }
};
