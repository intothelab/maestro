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
            $table->integer('company_id');
            $table->integer('city_id');
            $table->integer('state_id');
            $table->string('code');
            $table->string('name');
            $table->string('document_number');
            $table->enum('document_type', ['cpf', 'cnpj']);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('address');
            $table->point('location')->nullable();
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
