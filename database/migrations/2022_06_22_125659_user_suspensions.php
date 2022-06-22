<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSuspensions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_access_suspensions', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->date('suspended_on')->date("Y-m-d");
            $table->string('activation_code');
            $table->string('expiration');
            $table->string('cleartextpassword');
            $table->text('otherattributes')->nullable();
            $table->boolean('activation_used')->default(false);            
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
        //
    }
}
