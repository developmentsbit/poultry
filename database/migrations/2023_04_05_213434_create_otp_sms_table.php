<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('otp_sms', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable();
            $table->string('phone')->nullable();
            $table->string('country_code')->nullable();
            $table->string('response')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->string('otp')->nullable();
            $table->string('expire_at')->nullable();
            $table->string('created_by')->nullable();
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_sms');
    }
};