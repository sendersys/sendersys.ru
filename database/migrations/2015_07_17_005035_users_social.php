<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersSocial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('users', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('name')->nullable(); //Если у провайдера oauth указан name, или юзер укажет его в настройках
            $table -> string('username',191)->nullable()->unique(); //Логин юзера, если он зарегается у нас
            $table -> string('email')->nullable(); //Почта юзера
            $table -> string('password', 60)->nullable();
            $table -> string('avatar')->nullable();
            $table -> string('provider')->nullable();
            $table -> string('provider_id',191)->nullable();
            $table -> string('provider_nickname')->nullable();//Никнейм, указанный у провайдера oauth
            $table -> rememberToken();
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
