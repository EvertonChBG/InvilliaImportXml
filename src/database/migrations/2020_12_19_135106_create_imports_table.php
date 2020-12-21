<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $oTable) {

            $oTable->id();
            $oTable->string('file_path');
            $oTable->integer('size');
            $oTable->boolean('async')->default(false)->nullable();
            $oTable->dateTimeTz('date_processed')->nullable();

            $oTable->timestampsTz();
            $oTable->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imports');
    }
}
