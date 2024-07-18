<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Radpostauth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TABLE radpostauth (
            id int(11) NOT NULL auto_increment,
            username varchar(64) NOT NULL default '',
            pass varchar(64) NOT NULL default '',
            reply varchar(32) NOT NULL default '',
            authdate timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
            class varchar(64) NOT NULL default '',
            PRIMARY KEY  (id)
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
        Schema::dropIfExists('radpostauth');
    }
}
