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
        Schema::create('current_sales_returns', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->nullable();
            $table->string('sub_unit_id')->nullable();
            $table->string('product_id')->nullable();
            $table->double('product_quantity',11,2)->nullable();
            $table->double('final_quantity',11,2)->nullable();
            $table->double('product_purchase_price',11,2)->nullable();
            $table->double('product_sales_price',11,2)->nullable();
            $table->double('product_discount_amount',11,2)->nullable();
            $table->string('note')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('session_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_sales_returns');
    }
};
