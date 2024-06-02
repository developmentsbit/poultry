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
        Schema::create('supplier_infos', function (Blueprint $table) {
            $table->string('supplier_id')->primary();
            $table->string('supplier_branch_id')->nullable();
            $table->string('supplier_name_en')->nullable();
            $table->string('supplier_name_bn')->nullable();
            $table->string('supplier_phone')->nullable();
            $table->string('supplier_address')->nullable();
            $table->string('supplier_email')->nullable();
            $table->string('supplier_company_name')->nullable();
            $table->string('supplier_company_phone')->nullable();
            $table->string('supplier_company_address')->nullable();
            $table->string('supplier_admin_id')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_infos');
    }
};
