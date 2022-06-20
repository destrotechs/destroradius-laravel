<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ItemAllocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_allocations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->bigInteger('customer_id')->nullable();
            $table->string('allocated_to')->nullable();
            $table->string('quantity')->nullable();
            $table->string('purpose')->nullable();
            $table->string('status')->nullable();
            $table->string('allocation_date')->nullable();
            $table->string('return_date')->nullable();
            $table->string('added_by');
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
