<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class ItemStock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('item_stock', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->string('quantity_in')->nullable();
            $table->string('narration')->nullable();
            $table->string('added_by')->nullable();
            $table->string('allocation_id')->nullable();
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
        //
    }
}
