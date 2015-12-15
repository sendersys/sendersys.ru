<?php

/*
 * Describe your menu here.
 *
 * There is some simple examples what you can use:
 *
 * 		Admin::menu()->url('/')->label('Start page')->icon('fa-dashboard')->uses('\AdminController@getIndex');
 * 		Admin::menu(User::class)->icon('fa-user');
 * 		Admin::menu()->label('Menu with subitems')->icon('fa-book')->items(function ()
 * 		{
 * 			Admin::menu(\Foo\Bar::class)->icon('fa-sitemap');
 * 			Admin::menu('\Foo\Baz')->label('Overwrite model title');
 * 			Admin::menu()->url('my-page')->label('My custom page')->uses('\MyController@getMyPage');
 * 		});
 */


Admin::menu()->url('/')->label('Главная')->icon('fa-dashboard')->uses('\SleepingOwl\Admin\Controllers\DummyController@getIndex');
Admin::menu('App\Models\Black_list')->icon('fa-file-text');
Admin::menu('App\User')->icon('fa-users');
Admin::menu('App\Models\Users_site')->icon('fa-tags');
Admin::menu('App\Models\Segment')->icon('fa-bars');
Admin::menu()->url('#')->label('Главная страница')->icon('fa-home');