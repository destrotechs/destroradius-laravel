<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadacctTable extends Migration
{
    public function up()
    {
        Schema::create('radacct', function (Blueprint $table) {
			$table->integer('radacctid',21);
			$table->string('acctsessionid',64)->default('');
			$table->string('acctuniqueid',32)->default('');
			$table->string('username',64)->default('');
			$table->string('groupname',64)->default('');
			$table->string('realm',64)->default('');
			$table->string('nasipaddress',15)->default('');
			$table->string('nasportid',32)->nullable()->default('NULL');
			$table->string('nasporttype',32)->nullable()->default('NULL');
			$table->string('acctstarttime')->nullable()->default('NULL');
			$table->string('acctupdatetime')->nullable()->default('NULL');
			$table->string('acctstoptime')->nullable()->default('NULL');
			$table->string('acctinterval',12)->nullable();
			$table->string('acctsessiontime',12)->nullable();
			$table->string('acctauthentic',32)->nullable()->default('NULL');
			$table->string('connectinfo_start',50)->nullable()->default('NULL');
			$table->string('connectinfo_stop',50)->nullable()->default('NULL');
			$table->string('acctinputoctets',20)->nullable();
			$table->string('acctoutputoctets',20)->nullable();
			$table->string('calledstationid',50)->default('');
			$table->string('callingstationid',50)->default('');
			$table->string('acctterminatecause',32)->default('');
			$table->string('servicetype',32)->nullable()->default('NULL');
			$table->string('framedprotocol',32)->nullable()->default('NULL');
			$table->string('framedipaddress',15)->default('');
			$table->string('framedipv6address',45)->default('');
			$table->string('framedipv6prefix',45)->default('');
			$table->string('framedinterfaceid',44)->default('');
			$table->string('delegatedipv6prefix',45)->default('');
			$table->string('class',64)->nullable()->default('NULL');

        });
    }

    public function down()
    {
        Schema::dropIfExists('radacct');
    }
}