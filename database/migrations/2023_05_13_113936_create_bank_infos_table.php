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
        Schema::create('bank_infos', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->longtext('details')->nullable();
            $table->string('contact')->nullable();
            $table->string('account_type')->nullable();
            $table->string('bankingType')->nullable();
            $table->double('limit')->nullable();
            $table->integer('expiry')->nullable();
            $table->integer('admin')->nullable();
            $table->integer('branch_id')->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('bank_infos');
    }
};
