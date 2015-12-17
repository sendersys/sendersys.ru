<?php


Admin::menu()->url('')->label('Start page')->icon('fa-dashboard');
Admin::menu('App\User')->icon('fa-users');
Admin::menu('App\Models\Users_site')->icon('fa-tags');
Admin::menu('App\Models\Segment')->icon('fa-bars');
Admin::menu('App\Models\Subscribers')->icon('fa-users');
Admin::menu('App\Models\Black_list')->icon('fa-file-text');
Admin::menu('App\Models\Main_page')->icon('fa-home');
