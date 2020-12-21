<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $oTable) {

            $oTable->bigIncrements('id');
            $oTable->string('name');
            $oTable->string('email')->unique();
            $oTable->timestamp('email_verified_at')->nullable();
            $oTable->string('password');
            $oTable->rememberToken();

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
        Schema::dropIfExists('users');
    }
}
