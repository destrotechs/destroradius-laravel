<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('packagename')->unique();
            $table->integer('uploadspeed');
            $table->integer('downloadspeed');
            $table->integer('numberofdevices');
            $table->string('quota');
            $table->string('users');
            $table->string('packagezone');
            $table->text('description');
            $table->integer('validdays')->nullable();
            $table->string('durationmeasure')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
