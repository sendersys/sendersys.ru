@include('header')

{{--<pre>--}}
{{--<?php //print_r($main_page) ?>--}}
{{--</pre>--}}

<div class="modal fade" id="signup_form" tabindex="-1" role="dialog" aria-labelledby="login_label" aria-hidden="true">
  <?php echo Form::open(array('url' => URL::to('signup', array(), true), 'method' => 'post', 'class' => 'modal-dialog modal-lg')); ?>
    <div class="modal-content login-content">
      <div class="modal-header login_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center" id="login_label">Используйте ваш аккаунт от социальной сети:</h4>
        <span class = "text-center login_bottom_label center-block">(рекомендуется)</span>
      </div>
      <div class="modal-body login_body signup_body">
      	<div class = "row">
      		<div class = "col-md-6 col-xs-12 col-sm-6 f_login">
	      		<a class="btn btn-block btn-social btn-facebook login_link" href="/login/facebook">
			    	<i class="fa fa-facebook"></i> Facebook
			  	</a>
		  	</div>
		  	<div class = "col-md-6 col-xs-12 col-sm-6 vk_login">
	  			<a class="btn btn-block btn-social btn-vk login_link" href="/login/vkontakte">
			    	<i class="fa fa-vk"></i> VKontakte
			  	</a>
		  	</div>
       	</div>

       	<div class = "row">
       		<h4 class="text-center second_login">Или ваш email:</h4>
       	</div>
       	<?php echo Form::text('username', null, array('id' => 'username', 'required', 'class' => 'form-control signup_name', 'placeholder'=>'Введите ваше Имя')); ?>
       	<?php echo Form::email('email', null, array('id' => 'email', 'required', 'class' => 'form-control signup_email', 'placeholder'=>'Введите ваш Email')); ?>
    	  <div class="signup_message"></div>
    	  <div class = "row">
	      	<p class = "signup_link col-md-12 col-xs-12 col-sm-12 text-center offer_accept" href = "">*Пароль будет выслан на указанный email</a>
  		  
  		  </div>
  		  
    	
      </div>
      <div class="modal-footer login_footer signup_footer">

      	<?php echo Form::submit('Зарегистрироваться', array('class' => 'btn btn-default btn-xs center-block enter')); ?>	
      	
      	<div class = "row login_support">
	      	<p class = "signup_link col-md-12 col-xs-12 col-sm-12 text-center offer_accept" href = "">Вы соглашаетесь с <a class = "text-underline" href="http://sendersys.ru/assets/docs/Пользовательское_соглашение.docx">пользовательским соглашением<a></p>
      	</div>
      </div>
    </div>
 <?php echo Form::close(); ?>
</div>

<div class = "row">
	<div class = "col-md-12 center-block logo-block">

		<img class = "img-responsive logo center-block" src = "/images/main-icon.jpg"/>
	</div>	
</div>
<div class = "row">
	<div class = "col-md-12">
	<p class = "text-center big-text center-block">{!! $main_page->first_string !!}</p>
	</div>
</div>
<div class = "row">
	<div class = "col-md-12">
	<p class = "text-center medium-text">{!! $main_page->second_string !!}</p>
	
	</div>
</div>
<div class = "row">
	<div class = "col-md-12">
		<div class = "btn btn-default btn-lg center-block want" data-toggle="modal" data-target="#signup_form">Хочу попробовать</div>
	</div>
</div>
			</div>
		</div>
	</div>
</div>

<div class = "container">
	<div class = "row">
		<div class = "col-md-12">
			<p class = "howwork text-center center-block">{!! $main_page->content_title !!}</p>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-6 col-xs-12">
			<div class = "howwork__title h2 center-block text-center">{!! $main_page->first_column_title !!}</div>
			{!! $main_page->first_column_text !!}
		</div>
		<div class = "col-md-6 col-xs-12">
			<div class = "howwork__title h2 center-block text-center">{!! $main_page->second_column_title !!}</div>
			{!! $main_page->second_column_text !!}
		</div>
	</div>

	<div class = "row">
		<div class = "col-md-12">
			<p class = "itwork text-center center-block">{!! $main_page->first_footer_string !!}</p>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-12">
			<div class = "btn btn-default btn-lg center-block want-second" data-toggle="modal" data-target="#signup_form">Хочу попробовать</div>
		</div>
	</div>
	<div class = "row">
		<div class = "col-md-12">
			<p class = "no_trial text-center">*Никаких пробных периодов, сервис бесплатный сразу и навсегда!</p>
		</div>
	</div>


</div>

<?php if(isset($emailSend) && $emailSend !=null): ?>
             
            
<?php endif;?> 



      

@include('footer')

    
    
    
        
    