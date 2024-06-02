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
        Schema::create('employee_salary_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employee_infos');
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->date('date')->nullable();
            $table->string('transaction_type')->nullable();
            $table->double('salary_deposit',10,2)->nullable();
            $table->double('salary_withdraw',10,2)->nullable();
            $table->text('note')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salary_payments');
    }
};
