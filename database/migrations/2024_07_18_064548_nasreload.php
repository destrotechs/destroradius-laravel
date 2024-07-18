<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Nasreload extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TABLE IF NOT EXISTS nasreload (
            nasipaddress varchar(15) NOT NULL,
            reloadtime datetime NOT NULL,
            PRIMARY KEY (nasipaddress)
            ) ENGINE = INNODB;
        ");
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
