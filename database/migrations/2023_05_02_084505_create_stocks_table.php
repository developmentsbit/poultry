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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->double('quantity',11,2)->nullable();
            $table->double('sales_qty',11,2)->nullable();
            $table->double('purchase_price',11,2)->nullable();
            $table->double('purchase_price_withcost',11,2)->nullable();
            $table->double('sale_price',11,2)->nullable();
            $table->double('old_and_new_purchase_price_average',11,2)->nullable();
            $table->string('pdt_expiry_date')->nullable();
            $table->double('stock_qun',11,2)->nullable();
            $table->string('branch_id')->nullable();
            $table->string('status')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
