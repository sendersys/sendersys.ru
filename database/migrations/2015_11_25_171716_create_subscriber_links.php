<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriberLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriber_links', function (Blueprint $table) {
            $table -> integer('subscriber_id', 11);
            $table -> integer('campaign_id', 11);
            $table -> string('redirect_link', 255);
            $table -> string('link_hash', 255);
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
        Schema::table('subscriber_links', function (Blueprint $table) {
            //
        });
    }
}
