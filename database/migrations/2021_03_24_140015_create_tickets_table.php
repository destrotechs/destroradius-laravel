<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('customer_username',100)->notnull();
            $table->string('assignedto',100);
            $table->string('group')->nullable();
            $table->string('priority',100)->default('low');
            $table->string('status',100)->default('closed');
            $table->string('package')->notNull();
            $table->string('serialnumber')->nullable();
            $table->double('cost')->notNull();
            $table->string ('type')->nullable();
            $table->string('password')->nullable();
            $table->string('subject')->nullable();
            $table->string('message')->nullable();
            $table->string('location')->notnull();
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
        Schema::dropIfExists('tickets');
    }
}
