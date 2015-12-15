<?php

Admin::model('App\User')->title('Пользователи')->with('user_sites')->columns(function ()
{
	Column::string('email', 'Email')->orderBy('email')->sortableDefault();
	Column::string('username', 'Никнейм')->orderBy('username')->sortableDefault();
	Column::string('name', 'Имя')->orderBy('name')->sortableDefault();
	Column::count('user_sites', 'Домены')->append(Column::filter('user_id')->model('App\Models\Users_site'));
});