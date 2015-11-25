<?php
namespace App\Http\Controllers;


use Auth;
use Input;
use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Users;
use App\Models\Users_site;
use App\Models\Content_category;
use App\Models\Content_type;
use App\Models\Users_site2content;
use App\Models\Subscribers;
use App\Models\Segment;
use App\Models\Subscriber_status;
use App\Models\Mailing_list;
use App\Models\Log_subscribers;
use Cookie;
use Crypt;


class SubscriberLogController extends Controller {

    function createLog($action, $params){
        if(isset($params['subscriber_email'])){
            $subscriber = Subscribers::where('segment_id', '=', $params['segment_id'])->where('email', '=', $params['subscriber_email'])->first();
            $subscriber_id = $subscriber->id;
        }else{
            $subscriber_id = $params['subscriber_id'];
        }

        $logRow = new Log_subscribers;
        $logRow->subscriber_id = $subscriber_id;
        $logRow->segment_id = $params['segment_id'];
        $logRow->action = $action;
        if(isset($params['params'])) $logRow->params = $params['params'];

        $logRow->save();
        return true;
    }

    function getLog(){

    }
}