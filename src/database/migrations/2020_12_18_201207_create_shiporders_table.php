<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiporders', function (Blueprint $oTable) {

            $oTable->bigInteger('id')->unique();
            $oTable->bigInteger('person_id');
            $oTable->jsonb('shipto');

            $oTable->timestampsTz();
            $oTable->softDeletesTz();
        });

        Schema::create('shiporder_items', function (Blueprint $oTable) {

            $oTable->bigIncrements('id');
            $oTable->string('title');
            $oTable->text('note');
            $oTable->integer('quantity');
            $oTable->float('price');
            $oTable->bigInteger('shiporder_id');

            $oTable->foreign('shiporder_id')
                ->references('id')
                ->on('shiporders')
                ->onDelete('cascade');

            $oTable->timestamps();
            $oTable->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shiporder_items', function (Blueprint $table) {
            $table->dropForeign(['shiporder_id']);
        });

        Schema::dropIfExists('shiporder_items');
        Schema::dropIfExists('shiporders');

    }
}
