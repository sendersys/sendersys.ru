<?php

Admin::model('App\Models\Users_site')->title('Домены')->with('user')->filters(function ()
{
	ModelItem::filter('user_id')->title()->from(App\User::class, 'username');

})->columns(function ()
{
	Column::string('domen', 'Домен')->orderBy('domen')->sortableDefault();
	Column::string('user.name', 'Пользователь');
	Column::count('segment', 'Сегменты')->append(Column::filter('domen_id')->model('App\Models\Segment'));
});

