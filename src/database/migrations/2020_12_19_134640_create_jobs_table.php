<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $oTable) {

            $oTable->bigIncrements('id');
            $oTable->string('queue')->index();
            $oTable->longText('payload');
            $oTable->unsignedTinyInteger('attempts');
            $oTable->unsignedInteger('reserved_at')->nullable();
            $oTable->unsignedInteger('available_at');
            $oTable->unsignedInteger('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}
