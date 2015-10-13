<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailinglistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mailing_list', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('name')->nullable(); 
            $table -> string('domen_id')->nullable(); 
            $table -> string('type_id')->nullable(); //тип рассылки
            $table -> string('return_address')->nullable();
            $table -> date('date_start')->nullable();
            $table -> time('time_start')->nullable();
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
