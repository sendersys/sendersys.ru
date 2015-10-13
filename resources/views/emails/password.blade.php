<div class="modal fade" id="forgot_form" tabindex="-1" role="dialog" aria-labelledby="login_label" aria-hidden="true">
  <?php echo Form::open(array('url' => URL::to('forgot_password', array(), true), 'method' => 'post', 'class' => 'modal-dialog modal-lg')); ?>
    <div class="modal-content login-content">
      <div class="modal-header login_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center" id="login_label">Восстановление пароля</h4>
      </div>
      <div class="modal-body login_body">

        <?php echo Form::email('email', null, array('id' => 'email', 'required', 'class' => 'form-control login_email', 'placeholder'=>'Введите ваш Email')); ?>
      
      </div>
      <div class="modal-footer login_footer">
          <?php 
          // echo $errors
          ?>
        <?php echo Form::submit('Восстановить', array('class' => 'btn btn-default btn-xs center-block enter')); ?> 
      </div>
    </div>
 <?php echo Form::close(); ?>
</div>