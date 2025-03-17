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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->enum('business_type', ['retail', 'Wholesale', 'manufacturing'])->default('retail');;
            $table->string('address')->nullable;
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
