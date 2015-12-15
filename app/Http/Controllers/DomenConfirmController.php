<?php
namespace App\Http\Controllers;


use App\Models\Users_site;

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




class DomenConfirmController extends Controller {

    function confirm(Request $request){
        $user_name = Auth::user();
        $domen_id = Input::get('confirm_id');

        $current_domen = Users_site::where(['user_id' => $user_name['id'], 'id' => $domen_id])->first();
        if(isset($current_domen)){
            $confirm_hash = $current_domen->confirm_hash;
            $url = $current_domen->domen;
            if (!strstr($url, "://")){
                $url = "http://" . $url;
            }
            $tags = get_meta_tags($url);
            if(isset($tags['sendersys-confirm']) && $tags['sendersys-confirm'] == $confirm_hash){
                $current_domen->confirm = 1;
                $current_domen->save();
            }else{
                $fp = @file_get_contents($url . '/sendersys_' . $confirm_hash . '.html');
                if($fp){
                    if ($k = strpos($fp, 'Confirm: ' . $confirm_hash)){
                        $current_domen->confirm = 1;
                        $current_domen->save();
                    }
                }
            }
        }else{
            return redirect()->back()->with('error_message_save', 'ƒанный домен отсутствует у данного пользовател€');
        }
        return redirect()->back();
    }

}