<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNasTable extends Migration
{
    public function up()
    {
        Schema::create('nas', function (Blueprint $table) {
            $table->id();
            $table->string('nasname',128);
            $table->string('shortname',32)->nullable()->default('NULL');
            $table->string('type',30)->default('other');
            $table->string('ports',5)->nullable();
            $table->string('secret',60)->default('secret');
            $table->string('server',64)->nullable()->default('NULL');
            $table->string('community',50)->nullable()->default('NULL');
            $table->string('description',200)->default('RADIUS Client');

        });
    }

    public function down()
    {
        Schema::dropIfExists('nas');
    }
}