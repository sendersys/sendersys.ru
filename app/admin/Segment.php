<?php

Admin::model('App\Models\Segment')->title('Сегменты')->filters(function ()
{
	ModelItem::filter('id')->title()->from('App\Models\Segment');

})->columns(function ()
{
	Column::string('segment_name', 'Название')->orderBy('segment_name')->sortableDefault();
});