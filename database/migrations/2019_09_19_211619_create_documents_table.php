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
            $table->integer('series');
            $table->string('transporter_cnpj', 14)->nullable();
            $table->string('company_cnpj', 14)->nullable();
            $table->string('customer_cnpj', 14)->nullable();
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
