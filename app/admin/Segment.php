<?php
Admin::model('App\Models\Segment')->title('Сегменты')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->with('user_sites', 'subscribers');
	$display->filters([
		Filter::related('domen_id')->model('App\Models\Users_site')->display('domen'),
	]);
	$display->columns([
		Column::string('segment_name')->label('Сегмент'),
		Column::string('user_sites.domen')->label('Домен'),
		Column::count('subscribers')->label('Подписчики')->append(Column::filter('segment_id')->model('App\Models\Subscribers')),
	]);
	return $display;
})->createAndEdit(function (){
	return null;
});