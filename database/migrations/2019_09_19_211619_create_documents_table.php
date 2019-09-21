<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number')->unique()->index();
            $table->integer('transporter_cnpj')->index();
            $table->integer('company_cnpj')->index();
            $table->integer('customer_cnpj')->index();
            $table->integer('order_id')->nullable();
            $table->dateTime('collected_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shipments_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shipment_id');
            $table->integer('document_id');
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
        Schema::dropIfExists('documents');
    }
}
