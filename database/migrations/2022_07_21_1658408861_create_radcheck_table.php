<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadcheckTable extends Migration
{
    public function up()
    {
        Schema::create('radcheck', function (Blueprint $table) {
            $table->id();
            $table->string('username',64)->default('');
            $table->string('attribute',64)->default('');
            $table->char('op',2)->default('==');
            $table->string('value',253)->default('');

        });
    }

    public function down()
    {
        Schema::dropIfExists('radcheck');
    }
}