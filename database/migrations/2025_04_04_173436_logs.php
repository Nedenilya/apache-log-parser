<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('hostname');
            $table->string('ip');
            $table->string('timestamp');
            $table->string('timezone');
            $table->string('request_method');
            $table->string('url');
            $table->string('protocol');
            $table->string('status_code');
            $table->string('response_size');
            $table->string('referrer');
            $table->string('user_agent');
            $table->string('hash');
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
        //
    }
};
