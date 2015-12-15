<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/', 'UserController@main'); //главная
Route::post('/login_standart', 'UserController@login'); //авторизация по email и пароль
Route::any('/login/{provider?}', 'Auth\AuthController@login'); //авторизация и регистрация соцсети
Route::any('/signup', 'UserController@signup'); //регистрация по имени и паролю
Route::any('/forgot_password', 'Auth\PasswordController@postEmail'); //восстановление пароля

Route::get('/dashboard', ['middleware' => 'auth', 'uses'=> 'DashBoardController@dashboard']); //личный кабинет
Route::any('/dashboard/add_site', ['middleware' => 'auth', 'uses'=> 'DashBoardController@add_site']); //личный кабинет, добавление сайта
Route::any('/dashboard/add_audience', ['middleware' => 'auth', 'uses'=>'DashBoardController@add_audience']); //личный кабинет, добавление аудитории
Route::any('/dashboard/add_audience_file', ['middleware' => 'auth', 'uses'=> 'DashBoardController@add_audience_file']);//загружаем сегмент и подписчиков
Route::any('/dashboard/add_next_site', ['middleware' => 'auth', 'uses'=> 'DashBoardController@add_next_site']);//второй и более сайт
Route::any('/dashboard/audience', function(){
	return redirect()->intended('/dashboard/'); //аудитория
}); 
Route::any('/dashboard/widget', ['middleware' => 'auth', 'uses'=> 'DashBoardController@widget']); //виджеты widget
Route::any('/change_domen/{id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@change_domen']); //смена домена
Route::any('/download_segment/{id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@download_segment']); //загрузка сегмента в csv
Route::any('/change_segment/{id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@change_segment']); //изменение текущего сегмента 
Route::any('/delete_segment/{id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@delete_segment']); //удаление сегмента 
Route::any('/dashboard/add_audience_segment/{id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@add_audience_segment']); //добавление подписчиков в текущий сегмент
Route::any('/dashboard/find_subscribers/{id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@find_subscribers']); //поиск подписчиков
Route::any('/dashboard/subscribers_change_status/{id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@subscribers_change_status']); //фильтр по статусам подписчиков
Route::any('/dashboard/paginate_filter_audience/{id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@paginate_filter_audience']);
Route::any('/dashboard/get_subscriber/{subscribes_id}/{segment_id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@get_subscriber']); /*передача данных подписчика
 на редактирование */
Route::any('/dashboard/delete_subscriber/{subscribes_id}/{segment_id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@delete_subscriber']); //удаление подписчика
Route::any('/dashboard/change_subscriber/{subscribes_id}/{segment_id}', ['middleware' => 'auth', 'uses'=> 'DashBoardController@change_subscriber']); //изменение подписчика
Route::get('logout', function(){
	Auth::logout();
	return redirect()->intended('/'); //выход из ЛК
});


Route::get('/dashboard/mailing/add', ['as' => 'mailing.add', 'middleware' => 'auth', 'uses' => 'DashBoardController@addDelivery']); //добавление рассылки
Route::get('/dashboard/mailing/start/{mailing_id}', ['middleware' => 'auth', 'uses' => 'DashBoardController@mailingStart']); //запуск рассылки

Route::any('/dashboard/mailing', ['as'=> 'mailing.main', 'middleware' => 'auth', 'uses'=> 'DashBoardController@mailing']); //рассылки
Route::any('/dashboard/templates', ['middleware' => 'auth', 'uses'=> 'TemplateController@show_template']); //шаблоны
Route::any('/dashboard/templates_update', ['middleware' => 'auth', 'uses'=> 'TemplateController@change_template']); //редактирование шаблона
Route::any('/dashboard/templates_save', ['middleware' => 'auth', 'uses'=> 'TemplateController@save_template']); //Сохранение шаблона
Route::any('/unsubscribe/', 'SubscribeController@unsubscribe'); //Отписка подписчика
Route::any('/redirectlink/', 'StatusController@openLinks'); //Переходы с писем
Route::any('/scounter/', 'StatusController@openLetter'); //Переходы с писем
Route::any('/domen_confirm/', 'DomenConfirmController@confirm'); //Переходы с писем


Route::get('email', 'UserController@email'); //тестовая страница

Route::get('mailru-domainJB2lQA3Hk6zDnKLC.html', 'DashBoardController@mailru'); //для подтверждения

