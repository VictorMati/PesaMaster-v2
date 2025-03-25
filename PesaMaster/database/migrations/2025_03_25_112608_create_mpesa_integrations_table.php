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
         // Mpesa Integrations Table
         Schema::create('mpesa_integrations', function (Blueprint $table) {
            $table->id();
            $table->string('business_shortcode');
            $table->string('consumer_key');
            $table->string('consumer_secret');
            $table->string('passkey');
            $table->string('callback_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mpesa_integrations');
    }
};
