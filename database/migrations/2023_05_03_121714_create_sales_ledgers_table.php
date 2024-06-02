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
        Schema::create('sales_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('customer_id')->nullable();
            $table->double('total',11,2)->nullable();
            $table->double('final_discount',11,2)->nullable();
            $table->double('paid_amount',11,2)->nullable();
            $table->double('return_amount',11,2)->nullable();
            $table->double('vat',11,2)->nullable();
            $table->string('note')->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('status')->nullable();
            $table->string('admin_id')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_ledgers');
    }
};
