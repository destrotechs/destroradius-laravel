<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadpostauthTable extends Migration
{
    public function up()
    {
        Schema::create('radpostauth', function (Blueprint $table) {
            $table->id();
            $table->string('username',64)->default('');
            $table->string('pass',64)->default('');
            $table->string('reply',32)->default('');
            $table->timestamp('authdate');
            $table->string('class',64)->default('');

        });
    }

    public function down()
    {
        Schema::dropIfExists('radpostauth');
    }
}