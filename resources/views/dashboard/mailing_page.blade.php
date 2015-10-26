<?
use App\Models\Mailing_list;
use App\Models\Mailing_list2segment;
use App\Models\Mailing_list2period;
use App\Models\Mailing_period;
use App\Models\Mailing_status;
use App\Models\Segment;
?>

@include('dashboard.header_v2')
<div class = "row mailing_line">
    <div class = "col-md-4 mailing__head">Рассылки</div>
    <div class = "col-md-4 pull-right">
        <a href="{{  route('mailing.add') }}" class ="add_mailing__link pull-right">Добавить рассылку</a>
    </div>
</div>
<table class="table table-hover mailing__table">
         <thead class="mailing__table__head">
             <tr>
                 <th>Название рассылки</th>
                 <th>Сегмент</th>
                 <th>Дата запуска</th>
                 <th>Результаты</th>
                 <th class="text-right mailing__table__update">Редактирование</th>
             </tr>
         </thead>
         <tbody>
         <? 
         $mailing_list = Mailing_list::where('domen_id', '=', $current_domen[0]['id'])->get();
         $mailing_list_check = Mailing_list::where('domen_id', '=', $current_domen[0]['id'])->first();

         if($mailing_list_check) {
         	foreach ($mailing_list as $mailing_option) {
	         echo '<tr>';
	         	echo '<td>';
		         	echo '<p class="mailing__name">'.$mailing_option->name.'</p>';
		         	echo '<p class="mailing__status">'.Mailing_status::where('id', '=', $mailing_option->status_id)->first()->name.'</p>';
		         	echo '<p class="statistics_link">Статистика</p>';
		         	echo '<p class="mailing__see__template"><a>Смотреть шаблон</a></p>';
	         	echo '</td>';
	         	echo '<td>';
         			$mailing_segment = $mailing_option->segment()->get();
					foreach ($mailing_segment as $segment_id) {
						echo '<p class="mailing__segment">'.Segment::where('id', '=', $segment_id->segment_id)->first()->segment_name.'</p>';
					}
	         	echo '</td>';
	         	echo '<td>';
	         		$mailing_period = $mailing_option->period()->get();
					foreach ($mailing_period as $period_id) {
						echo '<p class="mailing__periodicity">'.Mailing_period::where('id', '=', $period_id->period_id)->first()->name.'</p>';
					}
	         		// echo '<p class="mailing__periodicity">Еженедельно</p>';
	         		// echo '<p class="mailing__weekday">Пн, Ср, Пт</p>';
	         		echo '<p class="mailing__time">в '.$mailing_option->time_start.'</p>';
	         	echo '</td>';
	         	echo '<td>';
		         	echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Отправлено: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
	         		echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Открыли: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
	         		echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Перешли: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
	         		 echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Отписались: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
		         	echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Пожаловались: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
	         	echo '</td>';
	         	echo '<td>';
	         		echo '<a class="mailing__table__update__link">Редактировать</a>';
	         		echo '<p class="text-right"><a href="/dashboard/mailing/start/'.$mailing_option->id.'/" class="mailing__table__start__link pull-right">Запустить</a></p>';
	         		echo '<p class="text-right"><a class="mailing__table__delete__link pull-right">Удалить</a></p>';
	         	echo '</td>';
	         echo '</tr>';
          	}
        }
	         else {
	         	echo '<tr>';
	         	echo '<td>';
		         	echo '<p class="mailing__name"> Нет активных рассылок </p>';
		         	echo '<p class="mailing__status"> Недоступно </p>';
		         	echo '<p class="statistics_link">Статистика</p>';
		         	echo '<p class="mailing__see__template"><a> Шаблона нет </a></p>';
	         	echo '</td>';
	         	echo '<td>';
	         		echo '<p class="mailing__segment"> Не выбран </p>';
	         	echo '</td>';
	         	echo '<td>';
	         		echo '<p class="mailing__periodicity"> Не определена </p>';
	         	echo '</td>';
	         	echo '<td>';
		         	echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Отправлено: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
	         		echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Открыли: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
	         		echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Перешли: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
	         		 echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Отписались: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
		         	echo '<div class="row">';
		         		echo '<div class="col-md-6"><p class="mailing__status__email">Пожаловались: </p></div>';
		         		echo '<div class="col-md-6"><span class="mailing__bold"> 0 </span></div>';
		         	echo '</div>';
	         	echo '</td>';
	         	echo '<td>';
	         		echo '<a class="mailing__table__update__link"> Недоступно </a>';
	         		echo '<p class="text-right"><a class="mailing__table__delete__link pull-right"> Недоступно </a></p>';
	         	echo '</td>';
	         echo '</tr>';
	         }
	         ?>
         </tbody>
         </table>
         <div class="row">
         <div class="col-md-4 pull-right">
             <select class="form-control paginate_filter_input" onchange="document.location=this.options[this.selectedIndex].value">
                     <option>10</option>
                     <option>20</option>
                     <option>30</option>
                     <option>50</option>
             </select>
             <span class="paginate_filter">Показывать на одной странице:</span>
         </div>
         
     </div>
</div>
@include('dashboard.footer')
