<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddsAdrenalineLegacyColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function(Blueprint $table){
            $table->integer('adr_id')->nullable();
        });

        Schema::table('orders', function(Blueprint $table){
            $table->integer('adr_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function(Blueprint $table){
            $table->dropColumn('adr_id');
        });

        Schema::table('orders', function(Blueprint $table){
            $table->dropColumn('adr_id');
        });
    }
}
