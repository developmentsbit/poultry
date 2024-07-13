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
        Schema::create('cash_closes', function (Blueprint $table) {
            $table->id();
            $table->date('cash_date')->nullable();
            $table->double('cash',10,2)->nullable();
            $table->text('bankbalance')->nullable();
            $table->text('current_asset')->nullable();
            $table->text('comment')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_closes');
    }
};
