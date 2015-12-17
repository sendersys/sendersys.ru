<?php
Admin::model('App\Models\Main_page')->title('Главная страница')->display(function ()
{
	$display = AdminDisplay::datatables();
	$display->columns([
		Column::string('first_string')->label('Данные'),
		Column::datetime('created_at')->label('Создано')->format('d.m.Y'),
		Column::datetime('updated_at')->label('Обновлено')->format('d.m.Y'),
		Column::string('active_string')->label('Активность')->orderable(false),
	]);
	return $display;
})->createAndEdit(function ()
{
	$form = AdminForm::form();
	$form->items([
		FormItem::text('first_string', 'Шапка - первая строка')->required(),
		FormItem::text('second_string', 'Шапка - вторая строка')->required(),
		FormItem::text('content_title', 'Заголовок контента')->required(),
		FormItem::columns()->columns([
			[
				FormItem::text('first_column_title', 'Заголовок первой колонки')->required(),
				FormItem::textarea('first_column_text', 'Текст первой колонки')->required(),
			],
			[
				FormItem::text('second_column_title', 'Заголовок второй колонки')->required(),
				FormItem::textarea('second_column_text', 'Текст второй колонки')->required(),
			],
		]),
		FormItem::text('first_footer_string', 'Строка в footer')->required(),
		FormItem::checkbox('active', 'Активно'),
	]);
	return $form;
});