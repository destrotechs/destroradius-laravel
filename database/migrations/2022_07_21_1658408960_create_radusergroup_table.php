<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadusergroupTable extends Migration
{
    public function up()
    {
        Schema::create('radusergroup', function (Blueprint $table) {
            $table->id();
            $table->string('username',64)->default('');
            $table->string('groupname',64)->default('');
            $table->string('priority',11)->default(1);

        });
    }

    public function down()
    {
        Schema::dropIfExists('radusergroup');
    }
}