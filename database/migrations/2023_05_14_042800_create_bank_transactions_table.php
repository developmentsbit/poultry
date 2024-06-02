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
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->bigInteger('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('bank_infos');
            $table->string('transaction_type')->nullable();
            $table->longtext('voucher_cheque_no')->nullable();
            $table->string('amount')->nullable();
            $table->string('entry_date')->nullable();
            $table->string('note')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('branch_id')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transactions');
    }
};
