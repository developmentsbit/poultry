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
        Schema::create('income_entries', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->bigInteger('income_id')->unsigned();
            $table->foreign('income_id')->references('id')->on('income_expense_titles');
            $table->date('entry_date')->nullable();
            $table->string('amount')->nullable();
            $table->string('note')->nullable();
            $table->string('admin')->nullable();
            $table->string('branch')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_entries');
    }
};
