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
        Schema::create('company_infos', function (Blueprint $table) {
            $table->id();
            $table->string('company_name_en',200)->nullable();
            $table->string('company_name_bn',200)->nullable();
            $table->string('company_mobile',20)->nullable();
            $table->text('company_address_en')->nullable();
            $table->text('company_address_bn')->nullable();
            $table->string('company_email',100)->nullable();
            $table->string('company_contact_no',20)->nullable();
            $table->string('banner',50)->nullable();
            $table->string('logo',50)->nullable();
            $table->integer('status')->comment(' 1 = Active & 0 = Inactive')->default(1);
            $table->integer('vat')->nullable();
            $table->date('date')->nullable();
            $table->double('openingbalance',10,2)->nullable();
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_infos');
    }
};
