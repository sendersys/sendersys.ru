<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogSubscribers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_subscribers', function (Blueprint $table) {
            $table -> integer('subscriber_id', 11);
            $table -> integer('segment_id', 11);
            $table -> string('action', 255);
            $table -> string('params', 255)->nullable();
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_subscribers', function (Blueprint $table) {
            //
        });
    }
}
