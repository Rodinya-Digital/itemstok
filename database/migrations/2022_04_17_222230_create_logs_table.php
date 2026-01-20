<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('type',['info','warning','danger','success','other'])->default('other');
            $table->enum('name',['freepik','envatoelements','motionarray','motionelements','system','other'])->default('other');
            $table->longText('value');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('gofiles', function (Blueprint $table) {
            $table->id();
            $table->string('service');
            $table->string('slug_id');
            $table->string('code');
            $table->timestamp('created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
        Schema::dropIfExists('gofiles');
    }
}
