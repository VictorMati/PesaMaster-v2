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
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('category'); // e.g., groceries, rent, savings
            $table->decimal('budget_limit', 15, 2);
            $table->decimal('current_expense', 15, 2)->default(0);
            $table->string('status')->default('active'); // e.g., active, exceeded
            $table->string('period'); // e.g., "2024-03" for March 2024
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
