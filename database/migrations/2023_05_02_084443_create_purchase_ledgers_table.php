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
        Schema::create('purchase_ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('invoice_date')->nullable();
            $table->string('voucher_no')->nullable();
            $table->string('voucher_date')->nullable();
            $table->string('suplier_id')->nullable();
            $table->double('total',11,2)->nullable();
            $table->double('paid',11,2)->nullable();
            $table->double('discount',11,2)->nullable();
            $table->double('return_amount',11,2)->nullable();
            $table->string('transaction_type')->nullable();
            $table->string('comment')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('status')->nullable();
            $table->string('admin_id')->nullable();
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
        Schema::dropIfExists('purchase_ledgers');
    }
};
