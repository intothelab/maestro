<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('code');
            $table->string('name');
            $table->enum('document_type', ['cpf', 'cnpj']);
            $table->string('document_number');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('zip');
            $table->string('address');
            $table->integer('city')->nullable();
            $table->integer('state')->nullable();
            $table->point('location')->nullable();
            $table->double('extra_tax')->nullable();
            $table->set('receiving_days', ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'])->nullable();
            $table->time('receiving_hours')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
