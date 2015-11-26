<?php
namespace App\Http\Controllers;


use App\Models\Crowded_emails;
use App\Models\Segment;
use Auth;
use Input;
use Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use App\Users;

use App\Models\Subscribers;
use App\Models\Log_subscribers;
use App\Models\Subscriber_link;


class StatusController extends Controller {

    function createImageRoute($subscriber_id, $campaign_id){
        $src = 'https://sendersys.ru/scounter?campaign_id=' . urlencode($campaign_id) . '&uid=' . urlencode($subscriber_id);
        $counter_image = '<img alt="" src="'.$src.'" width="1" height="1" border="0" />';
        return $counter_image;
    }

    function openLetter(){
        $uid = Input::get('uid');
        $campaign_id = Input::get('campaign_id');

        if ($uid && $campaign_id){
            $subscriber = Subscribers::where(['id' => $uid])->get()->first();
            $logSubscribers = (new SubscriberLogController)->createLog('change_status', ['segment_id' => $subscriber->segment_id, 'subscriber_id' => $subscriber->id, 'params' => 5]);
            if($subscriber->status_id != 8) {
                $subscriber->status_id = 5;
            }

            $image_path = 'https://sendersys.ru/images/s_counter.gif';

            $filesize = File::size(public_path(). '/images/s_counter.gif');

            header( 'Pragma: public' );
            header( 'Expires: 0' );
            header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
            header( 'Cache-Control: private',false );
            header( 'Content-Disposition: attachment; filename="s_counter.gif"' );
            header( 'Content-Transfer-Encoding: binary' );
            header( 'Content-Length: ' . $filesize );
            readfile($image_path);
        }
    }

    function createRedirectLink($link, $subscriber_id, $campaign_id){
        $key = NULL;
        $old_link = Subscriber_link::where(['subscriber_id' => $subscriber_id, 'redirect_link' => $link, 'campaign_id' => $campaign_id])->get()->first();
        if(is_object($old_link)){
            $link_hash = $old_link->link_hash;
        }else{
            $number = rand(1, 10000);
            $link_hash = md5($subscriber_id . $link . $campaign_id . $number);

            $new_link = new Subscriber_link;
            $new_link->subscriber_id = $subscriber_id;
            $new_link->redirect_link = $link;
            $new_link->link_hash = $link_hash;
            $new_link->campaign_id = $campaign_id;
            $new_link->save();
        }

        $link = "https://sendersys.ru/redirectlink?uid=" . $subscriber_id . "&campaign=" . $campaign_id . "&ckey=" . $link_hash;
        return $link;
    }

    function openLinks(){
        if ($link_hash = Input::get('ckey'))
        {
            $subscriber_id = Input::get('uid');
            $campaign_id = Input::get('campaign');
            $redirect = Subscriber_link::where(['link_hash' => $link_hash,'campaign_id' => $campaign_id, 'subscriber_id' => $subscriber_id])->get()->first();
            if(is_object($redirect)){
                $subscriber = Subscribers::where(['id' => $redirect->subscriber_id])->get()->first();
                if($subscriber->status_id != 8) {
                    $subscriber->status_id = 6;
                    $logSubscribers = (new SubscriberLogController)->createLog('change_status', ['segment_id' => $subscriber->segment_id, 'subscriber_id' => $subscriber->id, 'params' => 6]);
                    if($subscriber->save()){
                        $redirect_link = $redirect->redirect_link;
                        return redirect()->away($redirect_link);
                    }
                }
            }
            return redirect('/');
        }
        return redirect('/');
    }


    function parseMailLog($file){
        $str_search = "#\*\* (.+?) #is";
        $str_search_2 = "#said: 452 (.+?) #is";
        $handle = fopen($file, "r");

        while (!feof($handle)) {
            $buffer = fgets($handle, 4096);

            if(stripos($buffer,'said: 452') !== false && strpos($buffer,'discarded') === false)
            {
                preg_match($str_search_2, $buffer, $match);
                $email = $match[1];
                $email = str_replace(':', '', $email);
                if($email == 'noreply')
                    continue;

                if($email && filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $buffer_str = str_replace('  ', ' ', $buffer);
                    $time = explode(' ',$buffer_str,3);
                    $date = explode('-',$time[0]);
                    $time = explode(':',$time[1]);
                    $time = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
                    $crowded = Crowded_emails::where(['email' => $email])->get()->first();
                    if(!is_object($crowded) && $email != '')
                    {
                        $new_crowded = new Crowded_emails;
                        $new_crowded->email = $email;
                        $new_crowded->created_at = date('Y-m-d H:i:s', $time);
                    }
                    else if(is_object($crowded) && ($time -  strtotime($crowded->created_at)) > 7776000){
                        $subscribers = Subscribers::where(['email' => $email])->get();
                        if(is_object($subscribers)){
                            foreach ($subscribers as $subscriber){
                                if($subscriber->status_id != 8) {
                                    $subscriber->status_id = 10;
                                    $subscriber->save();
                                    $logSubscribers = (new SubscriberLogController)->createLog('change_status', ['segment_id' => $subscriber->segment_id, 'subscriber_id' => $subscriber->id, 'params' => 10]);
                                }
                            }
                        }
                    }
                    continue;
                }
            }

            else if(strpos($buffer,'**') !== false)
            {
                preg_match($str_search, $buffer, $match);
                $email = $match[1];
                $email = str_replace(':','',$email);
                if($email == '')
                    continue;
                if($email == 'noreply')
                    continue;
                if($email && filter_var($email, FILTER_VALIDATE_EMAIL))
                {
                    if(strpos($buffer,'550') !== false && stripos($buffer,'spam') === false)
                    {
                        $subscribers = Subscribers::where(['email' => $email])->get();
                        if(is_object($subscribers)){
                            foreach ($subscribers as $subscriber){
                                if($subscriber->status_id != 8) {
                                    $subscriber->status_id = 11;
                                    $subscriber->save();
                                    $logSubscribers = (new SubscriberLogController)->createLog('change_status', ['segment_id' => $subscriber->segment_id, 'subscriber_id' => $subscriber->id, 'params' => 11]);

                                }
                            }
                        }
                    }
                }
            }
        }
        fclose($handle);
    }

    function noActiveUsers(){
        $segments = Segment::all();
        foreach($segments as $segment){
            $subscribers = Subscribers::where(['segment_id' => $segment->id])->get();
            foreach ($subscribers as $subscriber){
               if($subscriber->status_id != 8) {
                    $log_subscriber = Log_subscribers::where(['subscriber_id' => $subscriber->id])->orderBy('id', 'desc')->get()->first();
                    if(is_object($log_subscriber)) {
                        $log_date = $log_subscriber->created_at;
                        $current_time = time();
                        if ($current_time - strtotime($log_date) > 7776000) {
                            $subscriber->status_id = 11;
                            $subscriber->save();
                            $logSubscribers = (new SubscriberLogController)->createLog('change_status', ['segment_id' => $subscriber->segment_id, 'subscriber_id' => $subscriber->id, 'params' => 11]);
                        }

                    }
               }
            }
        }
    }
}