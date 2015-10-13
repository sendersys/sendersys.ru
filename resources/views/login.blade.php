<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Авторизация</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/reset.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/styles.css') }}">
</head>
<body>
    <div id="container">
    	<h1 class = "login_title">Авторизация</h1>
        <?php echo Form::open(array('method' => 'post')); ?>
            <label for="name">E-mail:</label>
        <?php echo Form::email('email', null, array('id' => 'email', 'required')); ?>   
            <label for="username">Пароль:</label>

        <?php echo Form::password('password', array('id' => 'password', 'required')); ?>
        <?php echo Form::checkbox('remember', '1'); ?><label class="check" for="checkbox">Запомнить меня</label>
        <?php if(isset($errors) && $errors !=null): ?>
            <p class = "login__errors"><?=$errors?></p>
        <?php endif;?> 
            <div id="lower">

        <?php echo Form::submit('Войти'); ?>
        <a href="/signup" class = "signup_link">Регистрация</a>
        <?php echo Form::close(); ?>
            </div>
    </div>
</body>
</html>