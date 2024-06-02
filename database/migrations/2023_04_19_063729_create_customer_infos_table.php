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
        Schema::create('customer_infos', function (Blueprint $table) {
            $table->string('customer_id')->primary();
            $table->string('customer_branch_id')->nullable();
            $table->string('customer_name_en')->nullable();
            $table->string('customer_name_bn')->nullable();
            $table->string('customer_email',100)->nullable();
            $table->string('customer_phone',20)->nullable();
            $table->text('customer_address')->nullable();
            $table->string('customer_admin_id',20)->nullable();
            $table->string('nid',50)->default('0');
            $table->string('image',50)->default('0');
            $table->string('type')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_infos');
    }
};
