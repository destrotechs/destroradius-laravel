<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_limits', function (Blueprint $table) {
            $table->id();
            $table->string('limitname')->notNull();
            $table->string('limitmeasure')->nullable();
            $table->string('pref_table')->notNull();
            $table->string('op')->default(":=");
            $table->string('eng_name')->nullable();
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
        Schema::dropIfExists('custom_limits');
    }
}
