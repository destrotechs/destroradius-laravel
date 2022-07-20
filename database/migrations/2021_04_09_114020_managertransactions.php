<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Managertransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managertransactions', function (Blueprint $table) {
            $table->id();
            $table->string('transactionid',200)->notNull();
            $table->integer('managerid')->notNull();
            $table->double('commission')->notNull();
            $table->string('status')->default('unpaid');
            $table->string('description')->nullable();
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
