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
        Schema::create('employee_salary_setups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employee_infos');
            $table->string('employee_salary')->nullable();
            $table->string('status')->nullable();
            $table->date('date')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_salary_setups');
    }
};
