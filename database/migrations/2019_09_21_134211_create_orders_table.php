<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('company_cnpj');
            $table->integer('customer_cnpj');
            $table->string('code')->nullable();
            $table->double('value');
            $table->float('weight');
            $table->timestamps();
        });

        Schema::create('shipments_orders', function(Blueprint $table) {
           $table->bigIncrements('id');
           $table->integer('shipment_id');
           $table->integer('order_id');
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
        Schema::dropIfExists('orders');
    }
}
