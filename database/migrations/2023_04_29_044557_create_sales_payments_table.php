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
        Schema::create('sales_payments', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no',200)->nullable();
            $table->date('entry_date')->nullable();
            $table->double('payment_amount',11,2)->nullable();
            $table->double('return_amount',11,2)->nullable();
            $table->double('returnpaid',11,2)->nullable();
            $table->double('discount',11,2)->nullable();
            $table->double('previous_due',11,2)->nullable();
            $table->string('customer_id',200)->nullable();
            $table->string('payment_type')->nullable();
            $table->text('note')->nullable();
            $table->string('branch_id',100)->nullable();
            $table->integer('status')->nullable();
            $table->bigInteger('admin_id')->unsigned();
            $table->foreign('admin_id')->references('id')->on('users');
            $table->string('transaction_type',100)->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_payments');
    }
};
