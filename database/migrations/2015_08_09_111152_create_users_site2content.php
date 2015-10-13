<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSite2content extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_site2content', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('domen_id')->nullable(); //Домен сайта
            $table -> string('category_id')->nullable(); //категория контента
            $table -> string('type_id')->nullable(); //тип контента
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
