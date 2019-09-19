<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 150);
            $table->string('cnpj', 30)->unique();
            $table->string('email', 100)->unique();
            $table->string('phone', 30);
            $table->string('contact_name', 70)->nullable();
            $table->string('contact_phone', 30)->nullable();
            $table->text('description')->nullable();
            $table->point('location')->nullable();
            $table->text('zipcode');
            $table->text('address');
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
        Schema::dropIfExists('suppliers');
    }
}
