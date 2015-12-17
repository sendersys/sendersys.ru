<?php
Admin::model('App\Models\Users_site')->title('Домены')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->with('user', 'segments');
	$display->filters([
		Filter::related('user_id')->model('App\User')->display('name'),
	]);
	$display->columns([
		Column::string('domen')->label('Домен'),
		Column::string('user.name')->label('Пользователь'),
		Column::count('segments')->label('Сегменты')->append(Column::filter('domen_id')->model('App\Models\Segment')),
	]);
	return $display;
})->createAndEdit(function ()
{
	return null;
});