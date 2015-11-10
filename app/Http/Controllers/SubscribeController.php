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
use App\Models\Email_templates;
use App\Models\Content_category;
use App\Models\Content_type;
use App\Models\Users_site2content;
use App\Models\Subscribers;
use App\Models\Subscriber_hash;
use App\Models\Segment;
use App\Models\Subscriber_status;
use App\Models\Mailing_list;
use Cookie;
use Crypt;


class SubscribeController extends BaseController {

    public function unsubscribe(Request $request){
        if ($hash = Input::get('key'))
        {
            $subscriber_hash = Subscriber_hash::where(['hash' => $hash])->get()->first();
            if(is_object($subscriber_hash)){
                $subscriber = Subscribers::where(['id' => $subscriber_hash->id])->get()->first();
                $subscriber->status_id = 8;
                if($subscriber->save()){
                    $subscriber_hash->delete();
                    return view('subscribe.unsubscribe_success');
                }
            }
            return redirect('/');
        }
        return redirect('/');
    }

    public function unsubLink($id){
        $key = NULL;

        $old_hash = Subscriber_hash::where(['id' => $id])->get()->first();
        if(is_object($old_hash)){
            $key = $old_hash->hash;
        }else{
            $subscriber = Subscribers::where(['id' => $id])->get()->first();
            $subscriber_id = $subscriber->id;
            $subscriber_email = $subscriber->email;
            $number = rand(1, 10000);
            $key = md5($number . $subscriber_id . $subscriber_email);

            $new_hash = new Subscriber_hash;
            $new_hash->id = $id;
            $new_hash->hash = $key;
            $new_hash->save();
        }

        $link = "https://sendersys.ru/unsubscribe?key=".$key;
        return $link;
    }
}