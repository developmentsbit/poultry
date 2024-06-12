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
        Schema::create('cash_incomes', function (Blueprint $table) {
            $table->id();
            $table->date('cash_date')->nullable();
            $table->double('sales',10,2)->nullable();
            $table->double('others',10,2)->nullable();
            $table->double('bank_withdraw',10,2)->nullable();
            $table->double('bank_interest',10,2)->nullable();
            $table->double('purchase_return',10,2)->nullable();
            $table->double('loan_recived',10,2)->nullable();
            $table->double('intloan_recived',10,2)->nullable();
            $table->double('supplier_loan',10,2)->nullable();
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
        Schema::dropIfExists('cash_incomes');
    }
};
