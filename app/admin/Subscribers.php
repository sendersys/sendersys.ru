<?php
Admin::model('App\Models\Subscribers')->title('Подписчики')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->with('subscriber_segment');
	$display->filters([
		Filter::related('segment_id')->model('App\Models\Segment')->display('segment_name'),
	]);
	$display->columns([
		Column::string('email')->label('Email'),
		Column::string('name')->label('Имя'),
		Column::string('sex')->label('Пол'),
		Column::string('city')->label('Город'),
		Column::string('subscriber_segment.segment_name')->label('Сегмент'),
	]);
	return $display;
})->createAndEdit(function ()
{
	return null;
});