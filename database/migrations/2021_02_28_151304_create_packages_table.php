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
            $table->string('poolname')->nullable();
            $table->integer('uploadspeed');
            $table->integer('downloadspeed');
            $table->integer('numberofdevices');
            $table->string('quota');
            $table->string('users');
            $table->string('packagezone');
            $table->text('description');
            $table->integer('validdays')->nullable();
            $table->integer('priority')->nullable();
            $table->string('durationmeasure')->nullable();
            $table->string('burstup')->nullable();
            $table->string('burstdown')->nullable();
            $table->string('profile')->nullable();
            $table->date('validuntil')->nullable();
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
