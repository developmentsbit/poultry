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
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->date('payment_date')->nullable();
            $table->string('supplier_id')->nullable();
            $table->double('payment',11,2)->nullable();
            $table->string('payment_type')->nullable();
            $table->double('return_amount',11,2)->nullable();
            $table->double('returnpaid',11,2)->nullable();
            $table->double('discount',11,2)->nullable();
            $table->double('previous_due',11,2)->nullable();
            $table->date('entry_date')->nullable();
            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->text('comment')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('transaction_type')->nullable();
            $table->date('deleted_at')->nullable();
            $table->string('ledger_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_payments');
    }
};
