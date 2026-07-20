<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('role')->default('employee');
            $table->foreignId('position_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('active');
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['position_id']);
            $table->dropColumn(['company_id', 'role', 'position_id', 'status', 'deleted_at']);
        });
    }
};
