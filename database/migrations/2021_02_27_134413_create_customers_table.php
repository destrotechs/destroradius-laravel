<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name',100)->nullable();
            $table->string('username',50)->notNull();
            $table->string('password',255)->notNull();
            $table->string('phone',20)->notNull();
            $table->string('zone',50)->nullable();
            $table->string('type',100)->default('prepaid');
            $table->string('address',200)->nullable();
            $table->string('email')->unique();
            $table->string('cleartextpassword');
            $table->string('created_by')->nullable();
            $table->string('gender')->nullable();
            $table->string('customer_type')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
