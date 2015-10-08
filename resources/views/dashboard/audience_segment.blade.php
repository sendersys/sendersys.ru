<?php
use App\Models\Subscribers;
use App\Models\Subscriber_status;
use App\Models\Mailing_list;
use App\Models\Mailing_list2segment;
use App\Models\Mailing_list2period;
use App\Models\Mailing_period;

$current_segment = Request::cookie('current_segment');
?>
<div class = "row null_audience">
    <div class = "col-md-4 null_audience__head">Ваши аудитории</div>
    <div class = "col-md-4 null_audience__button pull-right">
        <a href="/dashboard/add_audience/" class ="add_audience__link pull-right">Добавить аудиторию</a>
    </div>
</div>


<div class="modal fade" id="delete_segment" tabindex="-1" role="dialog" aria-labelledby="delete_segment_label" aria-hidden="false">
  <?php echo Form::open(array('url' => URL::to('', array(), true) , 'method' => 'post', 'class' => 'modal-dialog modal-lg')); ?>
    <div class="modal-content delete_segment_content">
      <div class="modal-header delete_segment_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center" id="delete_segment_label">Удалить сегмент и подписчиков?</h4>
      </div>
      <div class="modal-body delete_segment_body">
      <p class = "text_mail text-center"></p>
      </div>
      <div class="modal-footer delete_segment_footer">
      	 <a href="" class="delete_segment_ok btn btn-default btn-xs center-block">Удалить</a>
      	 <div class="delete_segment_no btn btn-default btn-xs center-block">Отмена</div>
		</div>      
    </div>
 <?php echo Form::close(); ?>
</div>
<?php 
    $current_subscriber = Session::get('subscribes');
    $showmodal_change_subscribers = Session::get('showmodal_change_subscribers');
    if(isset($showmodal_change_subscribers) && $showmodal_change_subscribers!=null) {?>
        @include('dashboard.change_subscribers')
<?php } ?>
<div class ="row">
     <table class="table table-hover">
             <tbody>
             <?php
                foreach ($segments as $value) {
                   if(!isset($current_segment)) $current_segment = $value->id; //устанавливаем сегмент по умолчанию далее делаем редирект чтобы сменить сегмент при клике
                         if($current_segment == $value->id) {
                            echo "<tr class=\"audience__segment__row__active audience__segment__row\">";
                            echo '<td class="audience__segment__cell">';
                         	echo '<p class="audience__segment">'.$value->segment_name.'</p>'; 
                         	if(isset($error_message_save)) echo $error_message_save;
                         } 
                         else {
                         	echo "<tr class=\"audience__segment__row\">";
                         	echo '<td class="audience__segment__cell">';
                         	echo "<p class=\"audience__segment\" onClick='document.location.href=\"/change_segment/$value->id\"'>".$value->segment_name."</p>"; 
                         } 
                         
                         echo '<p class="audience__datecreated">Дата создания:</p>';
                         echo '<p class="audience__datecreated__text">'.date('d.m.Y', strtotime($value->created_at)).'</p>';
                     echo '</td>';
                     echo '<td class="audience__segment__cell">';
                        $mailing_id = Mailing_list2segment::where('segment_id', '=', $value->id)->get(); //почему-то не делает отбор по 15 сегменту

                        if($mailing_id) {
                            $mailing_ready_arr = [];
                            foreach ($mailing_id as $mailing_arr_id) {
                                $mailing_ready_arr[] = $mailing_arr_id->id;
                            }
                            $mailing_next = Mailing_list::whereIn('id', $mailing_ready_arr)->where('status_id', '=', '2')->first();
                            if(!$mailing_next) $mailing_next = Mailing_list::where('id', '=', $mailing_id)->where('status_id', '=', '1')->first();
                            $mailing_last = Mailing_list::whereIn('id', $mailing_ready_arr)->where('status_id', '=', '4')->first();
                            if($mailing_last) {
                                echo '<p class="audience__delivery">Последняя рассылка: <span class="audience__delivery__text"> - </span></p>'; 
                            }
                            else {
                                echo '<p class="audience__delivery">Последняя рассылка: <span class="audience__delivery__text"> - </span></p>';
                            }
                            if($mailing_next) {
                                echo '<p class="audience__delivery">Следующая рассылка: <span class="audience__delivery__text">
                                '.$mailing_next->date_start.'  '.$mailing_next->time_start.'</span></p>';
                                $period_list = Mailing_list2period::where('mailing_id', '=', $mailing_next->id)->get();
                                echo '<p class="audience__delivery">Рассылка: <span class="audience__delivery__text">';
                                foreach ($period_list as $period_id) {
                                   echo Mailing_period::where('id', '=', $period_id->period_id)->first()->name.', ';
                                }
                                echo ' '.$mailing_next->time_start.'</span></p>';
                            }
                            else {
                                echo '<p class="audience__delivery">Следующая рассылка: <span class="audience__delivery__text"> - </span></p>';
                                echo '<p class="audience__delivery">Рассылка: <span class="audience__delivery__text"> - </span></p>';
                            }
                        }
                        else {
                            echo '<p class="audience__delivery">Последняя рассылка: <span class="audience__delivery__text"> - </span></p>'; 
                            echo '<p class="audience__delivery">Последняя рассылка: <span class="audience__delivery__text"> - </span></p>';
                            echo '<p class="audience__delivery">Следующая рассылка: <span class="audience__delivery__text"> - </span></p>';
                            echo '<p class="audience__delivery">Рассылка: <span class="audience__delivery__text"> - </span></p>';
                        }
                     echo '</td>';
                     echo '<td class="audience__segment__cell">';
                        $subscribes_count = 0;
                        $subscribes_all = Subscribers::where('segment_id', '=', $value->id)->get(); //всего без учёта статуса
                        $subscribes_active = Subscribers::where('segment_id', '=', $value->id)->where('status_id', '=', '6')->get(); //6 - активен
                        $subscribes_unsubscribe = Subscribers::where('segment_id', '=', $value->id)->where('status_id', '=', '8')->get(); //8 - отписка
                        $subscribes_spam = Subscribers::where('segment_id', '=', $value->id)->where('status_id', '=', '9')->get(); //9 - жалуются на спам 
                        echo '<p class="audience__subscribers">Количество подписчиков: <span class="audience__subscribers__text">'.count($subscribes_all).'</span></p>';
                        echo '<p class="audience__subscribers">Активные подписчики: <span class="audience__subscribers__text">'.count($subscribes_active).'</span></p>';
                        echo '<p class="audience__subscribers">Отписались: <span class="audience__subscribers__text">'.count($subscribes_unsubscribe).'</span></p>';
                        echo '<p class="audience__subscribers">Пожаловались на спам: <span class="audience__subscribers__text">'.count($subscribes_spam).'</span></p>';
                     echo '</td>';
                     echo '<td class="audience__segment__cell">';
                        echo '<p class="text-right audience__button"><a href="/dashboard/add_audience_segment/'.$value->id.'" class="add_audience__segment__link pull-right">Добавить подписчиков</a></p>';
                        echo '<p class="text-right audience__button"><a data-segment-name='.$value->segment_name.' data-link="/delete_segment/'.$value->id.'" class="add_audience__delete__link pull-right" data-toggle="modal" data-target="#delete_segment">Удалить подписчиков</a></p>'; //
                        echo '<p class="text-right audience__button"><a href="/download_segment/'.$value->id.'" class="add_audience__download__link pull-right">Скачать подписчиков</a></p>';
                     echo '</td>';
                   echo '<tr>';
                }
             ?>
     </table>
</div>
</div>
<div class="null_audience__separator"></div>
<div class="container">
<div class="row audience__status__row">
<?php $subscribers_change_status = Request::cookie('subscribers_change_status'); ?>
    <ul class="nav audience__status__block col-md-9 col-xs-12 col-sm-11">
          <li class="audience__status__element <?php if($subscribers_change_status == 1000 || $subscribers_change_status == null || !isset($subscribers_change_status)) echo 'audience__status__element_selected'; ?>"><a href="/dashboard/subscribers_change_status/1000">Все</a></li>
          <li class="audience__status__element <?php if($subscribers_change_status == 3) echo 'audience__status__element_selected'; ?>"><a href="/dashboard/subscribers_change_status/3">Переходили</a></li>
          <li class="audience__status__element <?php if($subscribers_change_status == 5) echo 'audience__status__element_selected'; ?>"><a href="/dashboard/subscribers_change_status/5">Открывали рассылку</a></li>
          <li class="audience__status__element <?php if($subscribers_change_status == 2) echo 'audience__status__element_selected'; ?>"><a href="/dashboard/subscribers_change_status/2">Не открывали</a></li>
          <li class="audience__status__element <?php if($subscribers_change_status == 8) echo 'audience__status__element_selected'; ?>"><a href="/dashboard/subscribers_change_status/8">Отписались</a></li>
          <li class="audience__status__element <?php if($subscribers_change_status == 9) echo 'audience__status__element_selected'; ?>"><a href="/dashboard/subscribers_change_status/9">Пожаловались</a></li>
    </ul>
    <div class="col-md-3">
    <?php echo Form::open(array('url' => URL::to('dashboard/find_subscribers/'.$current_segment, array(), true), 'method' => 'post', 'class' => 'find_subscribers')); ?>
    <?php echo Form::email('search', null, array('id' => 'search', 'required', 'class' => 'search_subscribers form-control', 'placeholder'=>'Поиск подписчиков по email', 'title'=>'Введите email')); ?>
    <?php echo Form::hidden('hidden_segment', $current_segment, array('id' => 'hidden_segment', 'required')); ?>
    <?php echo Form::submit('Найти', array('class' => 'search_button btn btn-default btn-xs center-block')); ?> 
    <?php echo Form::close(); ?> 
    </div>
   
</div>
<div class ="row">
     <table class="table table-hover subscribers__table">
         <thead class="subscribers__head">
             <tr>
                 <th>Фамилия Имя</th>
                 <th>Email</th>
                 <th class="subscribers__status__head">Статус</th>
                 <th class="text-right subscribers__update__head">Редактирование</th>
             </tr>
         </thead>
         <tbody>
         <?php
            $not_found = Session::get('not_found');
            $subscribers_find = Session::get('subscribers_find');

            $pagination_store = Request::cookie('pagination_store');
            if(isset($pagination_store) && $pagination_store!=null) $pagination_number = $pagination_store;
                else $pagination_number = 10;

            if(isset($not_found)) {
                echo '<tr>';
                     echo '<td> - </td>';
                     echo '<td>'.$not_found.'</td>';
                     echo '<td> - </td>';
                     echo '<td><a class="subscribers__update">Нет действий</a></td>';
                 echo '</tr>';
            }
            else if(isset($subscribers_find)) {
                    echo '<tr>';
                         echo '<td>'.$subscribers_find->name.' '.$subscribers_find->surname.'</td>';
                         echo '<td>'.$subscribers_find->email.'</td>';
                         echo '<td>'.Subscriber_status::where('id', '=', $subscribers_find->status_id)->first()->status_name.'</td>';
                         echo '<td><a href="/dashboard/get_subscriber/'.$subscribers_find->id.'/'.$current_segment.'" class="subscribers__update">Редактировать</a></td>';
                     echo '</tr>';
            }
            else {

                if(isset($subscribers_change_status) && $subscribers_change_status!=null) {
                    $subscribes = Subscribers::where('segment_id', '=', $current_segment)->where('status_id', '=', $subscribers_change_status)->paginate($pagination_number);
                }
                    else $subscribes = Subscribers::where('segment_id', '=', $current_segment)->paginate($pagination_number);
                
     
                foreach ($subscribes as $value) {
                     echo '<tr>';
                         echo '<td>'.$value->name.' '.$value->surname.'</td>';
                         echo '<td>'.$value->email.'</td>';
                         echo '<td>'.Subscriber_status::where('id', '=', $value->status_id)->first()->status_name.'</td>';
                         echo '<td><a href="/dashboard/get_subscriber/'.$value->id.'/'.$current_segment.'" class="subscribers__update">Редактировать</a></td>';
                     echo '</tr>';
                }
            }
         ?>
         </tbody>
     </table>
     <div class="row">
         <div class="col-md-4 pull-right">
             <select class="form-control paginate_filter_input" onchange="document.location=this.options[this.selectedIndex].value">
                     <option <?php if($pagination_number == 10) echo 'selected'; ?> value="/dashboard/paginate_filter_audience/10">10</option>
                     <option <?php if($pagination_number == 20) echo 'selected'; ?> value="/dashboard/paginate_filter_audience/20">20</option>
                     <option <?php if($pagination_number == 30) echo 'selected'; ?> value="/dashboard/paginate_filter_audience/30">30</option>
                     <option <?php if($pagination_number == 50) echo 'selected'; ?> value="/dashboard/paginate_filter_audience/50">50</option>

             </select>
             <span class="paginate_filter">Показывать на одной странице:</span>
             
         </div>
         
     </div> 
     <?php if(isset($subscribes)) {
                echo '<div class="row">';
                    echo '<div class="text-center col-md-12">';
                        echo $subscribes->render();
                    echo '</div>';
                echo '</div>';
           } 
        ?>
</div>