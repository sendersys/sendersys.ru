<div class="modal fade" id="change_subscribers" tabindex="-1" role="dialog" aria-labelledby="change_subscribers_label" aria-hidden="false">
  <?php echo Form::open(array('url' => URL::to('/dashboard/change_subscriber/'.$current_subscriber['id'].'/'.$current_segment, array(), true) , 'method' => 'post', 'class' => 'modal-dialog modal-lg')); ?>
    <div class="modal-content change_subscribers_content">
      <div class="modal-header change_subscribers_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center" id="change_subscribers_label">Редактирование подписчика</h4>
      </div>
      <div class="modal-body change_subscribers_body">
            <?php echo Form::text('name', $current_subscriber['name'], array('id' => 'name', 'class' => 'change_subscribers_input form-control', 'placeholder'=>'Имя подписчика')); ?>
            <div class="change_subscribers_label_text">Имя подписчика</div>
            <?php echo Form::text('surname', $current_subscriber['surname'], array('id' => 'surname', 'class' => 'change_subscribers_input form-control', 'placeholder'=>'Фамилия подписчика')); ?>
            <div class="change_subscribers_label_text">Фамилия подписчика</div>
            <?php echo Form::text('sex', $current_subscriber['sex'], array('id' => 'sex', 'class' => 'change_subscribers_input form-control', 'placeholder'=>'Пол подписчика')); ?>
            <div class="change_subscribers_label_text">Пол подписчика</div>
            <?php echo Form::input('number', 'age', $current_subscriber['age'], array('id' => 'age', 'class' => 'change_subscribers_input form-control', 'placeholder'=>'Возраст подписчика')); ?>
            <div class="change_subscribers_label_text">Возраст подписчика</div>
            <?php echo Form::text('city', $current_subscriber['city'], array('id' => 'city', 'class' => 'change_subscribers_input form-control', 'placeholder'=>'Город')); ?>
            <div class="change_subscribers_label_text">Город</div>
            <?php echo Form::email('email', $current_subscriber['email'], array('id' => 'email', 'required', 'class' => 'change_subscribers_input form-control', 'placeholder'=>'Email подписчика')); ?>
            <div class="change_subscribers_label_text">Email подписчика</div>
            <p class="add_site_errors text-center"><?php echo Session::get('add_site_errors');?></p>
      <p class = "text_mail text-center">{{Session::get('errors')}}</p>
      </div>
      <div class="modal-footer change_subscribers_footer">
         <?php echo Form::submit('Сохранить', array('class' => 'btn btn-default btn-xs center-block change_subscribers_ok')); ?>      
         <div class="change_subscribers_no btn btn-default btn-xs center-block">Отмена</div>
         <?php echo '<a href="/dashboard/delete_subscriber/'.$current_subscriber['id'].'/'.$current_segment.'"" class="change_subscribers_delete btn btn-default btn-xs center-block">Удалить</a>'; ?>

        </div>      
    </div>
 <?php echo Form::close(); ?> 
</div>