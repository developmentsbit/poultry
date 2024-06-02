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
        Schema::create('current_purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('pdt_id')->nullable();
            $table->string('sub_unit_id')->nullable();
            $table->double('purchase_quantity',11,2)->nullable();
            $table->double('final_quantity',11,2)->nullable();
            $table->double('purchase_price',11,2)->nullable();
            $table->double('discount_amount',11,2)->nullable();
            $table->double('per_unit_cost',11,2)->nullable();
            $table->double('sale_price_per_unit',11,2)->nullable();
            $table->string('pdt_expiry_date')->nullable();
            $table->string('session_id')->nullable();
            $table->string('admin_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_purchase_returns');
    }
};
