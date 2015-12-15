<?php

Admin::model('App\Models\Black_list')->title('Черный список')->columns(function ()
{
	Column::string('email', 'Email')->orderBy('email')->sortableDefault();
	Column::date('reason', 'Причина занесения')->format('medium', 'none');
})->form(function ()
{
	FormItem::text('email', 'Email')->required();
	FormItem::text('reason', 'Причина занесения');
});