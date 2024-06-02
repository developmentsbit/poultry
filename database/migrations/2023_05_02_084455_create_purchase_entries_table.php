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
        Schema::create('purchase_entries', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('product_id')->nullable();
            $table->string('sub_unit_id')->nullable();
            $table->double('product_quantity',11,2)->nullable();
            $table->double('purchase_price',11,2)->nullable();
            $table->double('per_unit_cost',11,2)->nullable();
            $table->double('discount_amount',11,2)->nullable();
            $table->double('return_quantity',11,2)->nullable();
            $table->double('return_amount',11,2)->nullable();
            $table->double('returnpaid',11,2)->nullable();
            $table->string('pdt_expiry_date')->nullable();
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
        Schema::dropIfExists('purchase_entries');
    }
};
