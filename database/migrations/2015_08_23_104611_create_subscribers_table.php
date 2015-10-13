<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('surname')->nullable(); 
            $table -> string('name')->nullable(); 
            $table -> string('sex')->nullable();
            $table -> string('age')->nullable();
            $table -> string('city')->nullable();
            $table -> string('email')->nullable(); 
            $table -> string('segment_id')->nullable();
            $table -> string('status_id')->nullable(); 
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
        //
    }
}
