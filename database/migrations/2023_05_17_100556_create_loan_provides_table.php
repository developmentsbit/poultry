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
        Schema::create('loan_provides', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('register_id')->unsigned();
            $table->foreign('register_id')->references('id')->on('loan_registers');
            $table->double('amount',10,2)->nullable();
            $table->date('date')->nullable();
            $table->integer('branch')->nullable();
            $table->text('note')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_provides');
    }
};
