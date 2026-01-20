<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceAuthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_auths', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('cookie');
            $table->string('uid');
            $table->string('pw');
            $table->integer('status')->default(0);
            $table->longText('email_raw');
            $table->longText('detail_raw');
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
        Schema::dropIfExists('service_auths');
    }
}
