<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Radgroupreply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(" CREATE TABLE radgroupreply (
            id int(11) unsigned NOT NULL auto_increment,
            groupname varchar(64) NOT NULL default '',
            attribute varchar(64)  NOT NULL default '',
            op char(2) NOT NULL DEFAULT '=',
            value varchar(253)  NOT NULL default '',
            PRIMARY KEY  (id),
            KEY groupname (groupname(32))
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
        Schema::dropIfExists('radgroupreply');
    }
}
