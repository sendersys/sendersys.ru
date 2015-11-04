<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="/assets/css/normalize.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/bootstrap/css/docs.css">
    <link rel="stylesheet" href="/bootstrap/css/font-awesome.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-social.css">
    <link rel="stylesheet" href="/assets/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/assets/css/jquery-ui.structure.min.css">
    <link rel="stylesheet" href="/assets/css/jquery-ui.theme.min.css">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap-multiselect.css">
    <link rel="stylesheet" href="/assets/css/main_style.css">
</head>
<body>

		
				<header class = "header header_dashboard">
        <div class="container">
					<div class = "row">
						<a href="/dashboard/" class = "dashboard-logo col-md-3 pull-left">
              <img class="img-responsive dashboard-logo-img" src="/images/main-icon.jpg">      
            </a>
            <div class="dashboard__usermail col-md-3 col-md-offset-4">
             <?php

             // Request::cookie('domen_clear_list'));

             $tmp_user_name = Request::cookie('user_name');
             if(isset($tmp_user_name)) $user_name = Request::cookie('user_name'); //берём текущую почту юзера
             if(isset($user_name)) echo $user_name->email;            
             ?>
            {{-- <span class="glyphicon glyphicon-triangle-bottom arrow" aria-hidden="true"></span> --}}</div>
						<div class="col-md-1 pull-right text-uppercase language">
						  	<a class = "language__select" href = "#">RU<span class="glyphicon glyphicon-triangle-bottom arrow" aria-hidden="true"></span></a>
<!-- 						  	<a class = "language__select" href = "#">EN</a> -->
				        </div>
				        <div class = "col-md-1 pull-right text-uppercase"><a class = "login" href = "/logout">Выход</a></div>
					</div>
          </div>
				</header>
<div class="container">
    <div class="row dashboard__menu">
        <ul class="nav dashboard__menu__block col-md-6 col-xs-12 col-sm-8">
          <li class="dashboard__menu__element <?php if($_SERVER['REQUEST_URI']=='/dashboard/mailing/') echo 'active';?>"><a href="/dashboard/mailing/">Рассылки</a></li>
          <li class="dashboard__menu__element <?php if($_SERVER['REQUEST_URI']=='/dashboard/templates/') echo 'active';?>"><a href="/dashboard/templates/">Шаблоны</a></li>
<<<<<<< HEAD
           <li class="dashboard__menu__element <?php if($_SERVER['REQUEST_URI']=='/dashboard/widget/') echo 'active';?>"><a href="/dashboard/widget/">Виджеты</a></li>
           <li class="dashboard__menu__element <?php if($_SERVER['REQUEST_URI']=='/dashboard' || $_SERVER['REQUEST_URI']=='/dashboard/audience/' || $_SERVER['REQUEST_URI']=='/dashboard/add_audience/' || $_SERVER['REQUEST_URI']=='/dashboard/add_next_site/') echo 'active';?>"><a href="/dashboard/audience/">Аудитории</a></li>
=======
          <li class="dashboard__menu__element <?php if($_SERVER['REQUEST_URI']=='/dashboard/widget/') echo 'active';?>"><a href="/dashboard/widget/">Виджеты</a></li>
          <li class="dashboard__menu__element <?php if($_SERVER['REQUEST_URI']=='/dashboard' || $_SERVER['REQUEST_URI']=='/dashboard/audience/' || $_SERVER['REQUEST_URI']=='/dashboard/add_audience/' || $_SERVER['REQUEST_URI']=='/dashboard/add_next_site/') echo 'active';?>"><a href="/dashboard/audience/">Аудитории</a></li>
>>>>>>> develop2
        </ul>

        <a href = "mailto:support@sendersys.ru" class="col-md-2 col-md-offset-4 col-xs-1 col-sm-2 col-sm-offset-2 dashboard__help">Помощь</a>
    </div>
    <div class="row">
        <div class="col-md-12">
        <a class="current_domen" href="#" class="site_name__link"><p class="site_name">

        <?php
        $tmp_current_domen = Request::cookie('current_domen'); //получаем текущий домен
        if(isset($tmp_current_domen)) $current_domen = Request::cookie('current_domen');
        if(isset($current_domen)) {
            foreach ($current_domen as $site_name) {  
                $url = $site_name->domen;
                $url = str_replace(['http://', 'https://', '/'], '', $url);                   
                echo $url;
            }  
        }
        ?>
       </p><span class="site_name__arrow"></span></a></div>
    </div>
    <div class="row site_name__list">
          <div class="col-md-6">
            <div class="site_name__block">
            <?php

              $tmp_domen_clear_list = Request::cookie('domen_clear_list'); //получаем список доменнов
              if(isset($tmp_domen_clear_list)) $domen_clear_list = Request::cookie('domen_clear_list');
                if(isset($domen_clear_list)) {
                    foreach ($domen_clear_list as $site_id => $site_name) {    
                          $url = $site_name;
                          $url = str_replace(['http://', 'https://', '/'], '', $url);                                                 
                          echo '<a href="http://sendersys.ru/change_domen/'.$site_id.'" class="site_name__second">'.$url.'</a>';
                    }  
                }
            ?>
            <a href="/dashboard/add_next_site/" class="add_site_inmenu site_name__second">Добавить сайт</a>
            </div>
          </div>
        </div>