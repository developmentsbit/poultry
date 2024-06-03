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
        Schema::create('cash_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('cash_date')->nullable();
            $table->double('purchase',10,2)->nullable();
            $table->double('sales_return',10,2)->nullable();
            $table->double('others_expense',10,2)->nullable();
            $table->double('bank_deposit',10,2)->nullable();
            $table->double('bank_cost',10,2)->nullable();
            $table->double('loan_provide',10,2)->nullable();
            $table->double('intloan_provide',10,2)->nullable();
            $table->double('salary_payment',10,2)->nullable();
            $table->double('customer_loan',10,2)->nullable();
            $table->integer('admin_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_expenses');
    }
};
