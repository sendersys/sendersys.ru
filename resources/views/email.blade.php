<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Sendersys</title>
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/reset.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/login_form/styles.css') }}">
</head>
<body>
    Раз два

<?php 
	$to  = "<samikhajlov@gmail.com>"; 
	// $to .= "mail2@example.com>"; 

	$subject = "Тестирую отправку"; 

	$message = ' <h3>HTML теги</h3> </br> и кодировка работают </br> <p style = "color:green; font-family: Arial;">применяю стиль шрифт и цвет</p> <p><i>P.S.Привет от Станислава :)</i></p>';

	$mailheaders = "Content-type: text/html; UTF-8 \r\n";
	$mailheaders .= "From: no-reply@sendersys.ru";
	// $mailheaders .= "Reply-To: mysite.ru";

	mail($to, $subject, $message, $mailheaders); 
?>
</body>
</html>