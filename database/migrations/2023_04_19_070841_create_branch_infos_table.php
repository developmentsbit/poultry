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
        Schema::create('branch_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('sl')->nullable();
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('company_infos');
            $table->string('branch_name_en',150)->nullable();
            $table->string('branch_name_bn',150)->nullable();
            $table->string('branch_mobile',20)->nullable();
            $table->text('branch_address_en')->nullable();
            $table->text('branch_address_bn')->nullable();
            $table->string('branch_email',100)->nullable();
            $table->string('official_contact_no',30)->nullable();
            $table->integer('status')->comment('1=Active & 0 = Inactive')->default(1);
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_infos');
    }
};
