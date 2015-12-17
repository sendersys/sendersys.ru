<?php


Admin::model('App\User')->title('Пользователи')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->columns([
		Column::string('name')->label('Имя'),
		Column::string('email')->label('Email'),
		Column::count('user_sites')->label('Домены')->append(Column::filter('user_id')->model('App\Models\Users_site')),
	]);
	return $display;
})->createAndEdit(function ()
{
	return null;
//	$form = AdminForm::form();
//	$form->items([
//		FormItem::text('name', 'Name')->required(),
//		FormItem::text('email', 'Email')->required()->unique(),
//	]);
//	return $form;
});