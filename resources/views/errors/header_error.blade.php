<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sendersys</title>
    <link rel="stylesheet" href="/assets/css/normalize.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/bootstrap/css/docs.css">
    <link rel="stylesheet" href="/bootstrap/css/font-awesome.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-social.css">
    <link rel="stylesheet" href="/assets/css/main_style.css">
</head>
<body>

<div class="modal fade" id="login_form" tabindex="-1" role="dialog" aria-labelledby="login_label" aria-hidden="true">
  <?php echo Form::open(array('url' => URL::to('login_standart', array(), true), 'method' => 'post', 'class' => 'modal-dialog modal-lg', 'id' => 'login_standart_form')); ?>
    <div class="modal-content login-content">
      <div class="modal-header login_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center" id="login_label">Используйте ваш аккаунт от социальной сети:</h4>
        <span class = "text-center login_bottom_label center-block">(рекомендуется)</span>
      </div>
      <div class="modal-body login_body">
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
       	<?php echo Form::email('email', null, array('id' => 'email', 'required', 'class' => 'form-control login_email', 'placeholder'=>'Введите ваш Email')); ?>
    	  <?php echo Form::password('password', array('id' => 'password', 'required', 'class' => 'form-control login_pass', 'placeholder'=>'Введите пароль')); ?>
    	  <div class="login_message"></div>
         
      </div>

      <div class="modal-footer login_footer">

      	<?php echo Form::submit('Войти', array('class' => 'btn btn-default btn-xs center-block enter')); ?>	
      	
      	<div class = "row login_support">
	      	<a class = "login_forgot col-md-6 col-xs-12 col-sm-6 text-center" data-toggle="modal" data-target="#forgot_form">Забыли пароль?</a>
	      	<a class = "signup_link col-md-6 col-xs-12 col-sm-6 text-center" {{-- href = "/signup" --}} 
          data-toggle="modal" data-target="#signup_form">Зарегистрироваться</a>
      	</div>
      </div>
    </div>
 <?php echo Form::close(); ?>
</div>

@include('emails.password')

<?php if(isset($emailSend) && $emailSend !=null): ?>
             
            

<div class="modal fade" id="success_signup" tabindex="-1" role="dialog" aria-labelledby="login_label" aria-hidden="false">
  <?php echo Form::open(array('url' => URL::to('success_signup', array(), true) , 'method' => 'post', 'class' => 'modal-dialog modal-lg')); ?>
    <div class="modal-content login-content">
      <div class="modal-header login_header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title text-center" id="login_label">Мы отправили письмо c паролем на ваш email:</h4>
       
      </div>
      <div class="modal-body login_body send_success_body">
      <p class = "text_mail text-center"><?=$emailSend?></p>
      </div>
      <div class="modal-footer login_footer">
         <p class = "check_mail text-center">Проверьте почту!</p>
      </div>
    </div>
 <?php echo Form::close(); ?>
</div>
<?php endif;?> 

<div class = "limiter">

	<div class = "filter">
		<div class="container">
		<div class = "head-ground">
			
				<header class = "header">
					<div class = "row">
						
						<div class="col-md-1 pull-right text-uppercase language">
						  	<a class = "language__select" href = "#">RU<span class="glyphicon glyphicon-triangle-bottom arrow" aria-hidden="true"></span></a>
<!-- 						  	<a class = "language__select" href = "#">EN</a> -->
				        </div>
				        <div class = "col-md-1 pull-right text-uppercase"><a class = "login" data-toggle="modal" data-target="#login_form">Вход</a></div>
					</div>
          <a style="display:none;" class = "hide_signup_success" data-toggle="modal" data-target="#success_signup"></a>
				</header>

     