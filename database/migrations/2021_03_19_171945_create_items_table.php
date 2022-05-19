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
            $table->string('category_code',100);
            $table->string('sub_category_code',100);
            $table->string('name',100)->nullable();
            $table->string('model',100)->nullable();
            $table->string('serial',100)->nullable();
            $table->string('type',100)->nullable();
            $table->string('quantity',100);
            $table->string('cost',100)->nullable();
            $table->string('description',233)->nullable();
            $table->string('supplier_id',100)->default('other');
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
