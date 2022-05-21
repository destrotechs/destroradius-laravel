<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('category_code');
            $table->string('sub_category_code');
            $table->string('item_code');
            $table->string('name')->nullable();
            $table->string('make')->nullable();
            $table->string('model')->nullable();
            $table->string('serial')->nullable();
            $table->string('type')->nullable();
            $table->string('quantity');
            $table->string('description')->nullable();
            $table->string('supplier_id')->default('other');
            $table->string('vendor')->nullable();
            $table->string('stock')->nullable();
            $table->string('price')->nullable();
            $table->string('cost')->nullable();
            $table->text('attributes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
