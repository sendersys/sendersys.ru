<?php

use Illuminate\Database\Seeder;

class MainPageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('main_page')->insert([

            'first_string' => 'Удобный сервис привлечения трафика для</br> контентных проектов через email',
            'second_string' => 'Собирайте подписчиков и делайте рассылки</br>Получайте дополнительный трафик бесплатно',
            'content_title' => 'Как это работает?',
            'first_column_title' => 'Простейшая интеграция:',
            'first_column_text' => '<p class = "howwork__list pull-left col-md-10 col-md-offset-1"><span class = "point">• </span> Вы устанавливаете наш виджет и он сразу начинает собирать ваших подписчиков.</p>
</br>
<p class = "howwork__list pull-left col-md-10 col-md-offset-1">•  Вы можете загрузить в свой аккаунт действующих подписчиков и делать рассылки по ним.</p>',
            'second_column_title' => 'Отличный эффект:        ',
            'second_column_text' => '<p class = "howwork__list pull-left col-md-10 col-md-offset-1"><span class = "point">• </span> Выберите шаблон и поставьте ваши рассылки на автомат.</p>
</br>
<p class = "howwork__list pull-left col-md-10 col-md-offset-1">•  Система сделает рассылку в указанное вами время, а вам останется только наблюдать за ростом вашего трафика.</p>',
            'first_footer_string' => 'Это работает очень просто и очень эффективно!</br>Попробуйте сами',
            'active' => '1',

        ]);
    }
}
