<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Radusergroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("CREATE TABLE radusergroup (
            id int(11) unsigned NOT NULL auto_increment,
            username varchar(64) NOT NULL default '',
            groupname varchar(64) NOT NULL default '',
            priority int(11) NOT NULL default '1',
            PRIMARY KEY  (id),
            KEY username (username(32))
            )ENGINE = INNODB;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('radusergroup');
    }
}
