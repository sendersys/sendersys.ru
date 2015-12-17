<?php

Route::get('/', [
	'as' => 'admin.home',
	function (){
		//Смахивает на костыль, но другого менее болезненного способа не нашел
		$content = (new \App\Http\Controllers\AdminController)->getIndex();
		return Admin::view($content, 'Главная');
	}
]);
