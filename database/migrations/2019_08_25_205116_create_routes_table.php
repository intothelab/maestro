<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_id');
            $table->text('code');
            $table->enum('mode', ['rail', 'sea', 'road', 'air', 'other']);
            $table->enum('group', ['inbound', 'outbound'])->default('outbound');
            $table->enum('type', ['regular', 'premium', 'milkrun', 'fractioned', 'door-to-door'])->default('regular');
            $table->char('uf_origin', 2);
            $table->char('uf_destination', 2);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('routes');
    }
}
