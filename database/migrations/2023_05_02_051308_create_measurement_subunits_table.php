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
        Schema::create('measurement_subunits', function (Blueprint $table) {
            $table->id();
            $table->string('measurement_unit_id')->nullable();
            $table->string('sub_unit_name')->nullable();
            $table->string('sub_unit_data')->nullable();
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
        Schema::dropIfExists('measurement_subunits');
    }
};
