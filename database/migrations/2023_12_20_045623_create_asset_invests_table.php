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
        Schema::create('asset_invests', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->bigInteger('title_id')->unsigned();
            $table->foreign('title_id')->references('id')->on('asset_categories');
            $table->double('amount')->default('0.00');
            $table->text('comment')->nullable();
            $table->bigInteger('branch_id')->unsigned();
            $table->foreign('branch_id')->references('id')->on('branch_infos');
            $table->date('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_invests');
    }
};
