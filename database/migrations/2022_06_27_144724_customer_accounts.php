<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CustomerAccounts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('owner');
            $table->string('account_name')->nullable();
            $table->string('account_no')->unique();
            $table->string('access_code')->nullable();
            $table->string('address')->nullable();
            $table->string('building')->nullable();
            $table->string('town')->nullable();
            $table->string('coordinates')->nullable();
            $table->string('package_name')->nullable();
            $table->string('status')->nullable();
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
