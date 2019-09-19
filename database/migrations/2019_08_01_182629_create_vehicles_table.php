<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->integer('transporter_id');
            $table->enum('type', ['water', 'cement', 'cargo', 'van', 'lowboy', 'container', 'chemical']);
            $table->string('name')->nullable();
            $table->string('plate');
            $table->float('capacity');
            $table->float('length');
            $table->integer('axles');
            $table->string('fleet_number')->nullable();
            $table->enum('status', ['active', 'inactive']);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
