<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersSite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_site', function (Blueprint $table) {
            $table -> increments('id');
            $table -> string('domen')->unique(); //Домен сайта
            $table -> string('user_id')->nullable(); //ID связи с таблицей пользователей
            $table -> string('visitor')->nullable(); //ежедневная посещаемость
            $table -> string('base_size')->nullable(); //размер имеющейся базы
            $table -> timestamps(); //дата, время создания, изменения
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
