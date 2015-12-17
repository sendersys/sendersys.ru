<?php

Admin::model('App\Models\Black_list')->title('Черный список')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->columns([
		Column::string('email')->label('Email'),
		Column::string('reason')->label('Причина занесения')->orderable(false),
	]);
	return $display;
})->createAndEdit(function ()
{
	$form = AdminForm::form();
	$form->items([
		FormItem::text('email', 'Email')->required(),
		FormItem::text('reason', 'Причина занесения'),
	]);
	return $form;
});