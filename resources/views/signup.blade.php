<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Регистрация</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/reset.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/styles.css') }}">
</head>
<body>
    <div id="container" class = "signup__container">
        <h1 class = "signup_title">Регистрация</h1>
        <?php echo Form::open(array('method' => 'post')); ?>
            <label for="name">E-mail:</label>
        <?php echo Form::email('email', null, array('id' => 'email', 'required')); ?>   
            <label for="username">Пароль:</label>
        <?php echo Form::password('password', null, array('id' => 'password', 'required')); ?>   
            <div id="lower">
        <?php if(isset($errors) && $errors !=null): ?>
            <p class = "signup__errors"><?=$errors?></p>
        <?php elseif(isset($success) && $success !=null): ?>
            <p class = "signup__success"><?=$success?></p>
        <?php endif; ?>
        <?php echo Form::submit('Зарегистрироваться', array('class' => 'signup_button')); ?>
        <?php echo Form::close(); ?>
            </div>
        </form>
    </div>
</body>
</html>
    
    
    
    
    
        
    