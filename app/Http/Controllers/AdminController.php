<?php

namespace App\Http\Controllers;

use View;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\User;
use App\Models\Users_site;
use App\Models\Subscribers;
use App\Models\Segment;

class AdminController extends BaseController
{
    public function getIndex()
    {
        $segmentCount = Segment::count();
        $subscribersCount = Subscribers::count();
        $domensCount = Users_site::count();
        $usersCount = User::count();
        $data = compact('segmentCount', 'subscribersCount', 'domensCount', 'usersCount');
        return View::make('admin.index', $data);
    }
} 