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
        Schema::create('product_brands', function (Blueprint $table) {
            $table->id();
            $table->string('brand_id');
            $table->string('brand_name_en')->nullable();
            $table->string('brand_name_bn')->nullable();
            $table->string('brand_status')->nullable();
            $table->string('brand_admin_id')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_brands');
    }
};
