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
        Schema::create('product_informations', function (Blueprint $table) {
            $table->id();
            $table->string('pdt_id');
            $table->string('pdt_item_id')->nullable();
            $table->string('barcode')->nullable();
            $table->string('pdt_cat_id')->nullable();
            $table->string('pdt_brand_id')->nullable();
            $table->string('pdt_name_en')->nullable();
            $table->string('pdt_name_bn')->nullable();
            $table->string('pdt_measurement')->nullable();
            $table->string('pdt_purchase_price')->nullable();
            $table->string('pdt_sale_price')->nullable();
            $table->string('pdt_status')->nullable();
            $table->string('pdt_admin_id')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_informations');
    }
};
