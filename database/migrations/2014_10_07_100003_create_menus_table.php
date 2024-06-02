<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('name');
            $table->string('bn_name')->nullable();
            $table->string('system_name')->nullable();
            $table->string('route_name')->nullable()->unique();
            $table->string('icon')->nullable();
            $table->integer('order_by')->nullable();
            $table->enum('is_hidden', ['Yes', 'No'])->default('No');
            $table->integer('status')->nullable()->default(1)->comment('1 = active, 0 = inactive');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
