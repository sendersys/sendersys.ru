<div class="modal fade" id="success_signup" tabindex="-1" role="dialog" aria-labelledby="login_label" aria-hidden="false">
  <?php echo Form::open(array('url' => URL::to('success_signup', array(), true), 'method' => 'post', 'class' => 'modal-dialog modal-lg')); ?>
    <div class="modal-content login-content">
      <div class="modal-header login_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center" id="login_label">Мы отправили письмо c паролем на ваш email:</h4>
        <script type="text/javascript">
        $(function(){

                    $('.hide_signup_success').click();
                    });
             </script>
       
      </div>
      <div class="modal-body login_body">
      
      </div>
      <div class="modal-footer login_footer">
          <?php 
          // echo $errors
          ?>
      </div>
    </div>
 <?php echo Form::close(); ?>
</div>