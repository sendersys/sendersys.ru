<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_page', function (Blueprint $table) {
            $table->text('first_string', 255);
            $table->text('second_string', 255);
            $table->text('content_title', 255);
            $table->text('first_column_title', 255);
            $table->text('first_column_text', 255);
            $table->text('second_column_title', 255);
            $table->text('second_column_text', 255);
            $table->text('first_footer_string', 255);
            $table->tinyInteger('active', 1)->default(0);
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
        Schema::table('main_page', function (Blueprint $table) {
            //
        });
    }
}
