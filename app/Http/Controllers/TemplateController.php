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
use App\Models\Segment;
use App\Models\Subscriber_status;
use App\Models\Mailing_list;
use Cookie;
use Crypt;


class TemplateController extends BaseController {

    public function show_template(Request $request){
        /*=============================================================*/
        $user_name = Auth::user();
        $domen_id = null;
        $current_domen_cookie = $request->cookie('current_domen');

        if(isset($current_domen_cookie)) {
            foreach ($current_domen_cookie as $current_site) {
                $domen_id = $current_site->id;
            }
        }
        else {
            $default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
            $domen_id = $default_domen->id;
        }

        $match = ['user_id' => $user_name['id'], 'domen_id' => $domen_id];
        $email_template = Email_templates::where($match)->get()->first();


        $current_domen = Users_site::where('id', '=', $domen_id)->get();
        $domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();

        $domen_clear_list = null;
        $ready_site_name = null;
        if(isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
            foreach ($current_domen as $current_site_name) {
                $ready_site_name = $current_site_name->domen;
            }
            foreach ($domen_list as $site_name) {
                if($ready_site_name != $site_name->domen)
                    $domen_clear_list[$site_name->id] = $site_name->domen;

            }
        }

        if(is_object($email_template)){
            $property_array = json_decode($email_template->properties, true);
        }else{
            $property_array['images']['value'] = '1';
            $property_array['body']['position'] = 'columns';
            $property_array['logo']['position'] = 'left';
            $property_array['article_button']['style']['border-radius']['value'] = '0px';
            $property_array['application_link']['style']['border-radius']['value'] = '0px';
            $property_array['article']['style']['border-radius']['value'] = '0px';
            $property_array['social_buttons']['style']['border-radius']['value'] = '0px';
            $property_array['application_block']['position'] = 'left';

            return view('dashboard.templates_update', array(
                'property_array' => isset($property_array) ? $property_array : null,
                'current_domen' => isset($current_domen) ? $current_domen:null,
                'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
                'user_name' => isset($user_name) ? $user_name:null
            ));
        }

        /*=============================================================*/

        return view('dashboard.templates_new', array(
            'property_array' => isset($property_array) ? $property_array : null,
            'current_domen' => isset($current_domen) ? $current_domen:null,
            'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
            'user_name' => isset($user_name) ? $user_name:null
        ));

    }

    public function change_template(Request $request){

        $current_domen_cookie = $request->cookie('current_domen');
        $user_name = Auth::user();

        $domen_id = '';
        $property_array = array();

        if(isset($current_domen_cookie)) {
            foreach ($current_domen_cookie as $current_site) {
                $domen_id = $current_site->id;
            }
        }else {
            $default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
            $domen_id = $default_domen->id;
        }


        $match = ['user_id' => $user_name['id'], 'domen_id' => $domen_id];
        $email_template = Email_templates::where($match)->get()->first();

        if(is_object($email_template)){
            $property_array = json_decode($email_template->properties, true);
        }
        else{
            $property_array['images']['value'] = '1';
            $property_array['body']['position'] = 'columns';
            $property_array['logo']['position'] = 'left';
            $property_array['article_button']['style']['border-radius']['value'] = '0px';
            $property_array['application_link']['style']['border-radius']['value'] = '0px';
            $property_array['article']['style']['border-radius']['value'] = '0px';
            $property_array['social_buttons']['style']['border-radius']['value'] = '0px';
            $property_array['application_block']['position'] = 'left';
        }

        $user_name = Auth::user();
        $current_domen = Users_site::where('id', '=', $domen_id)->get();
        $domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();
        if (isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
            $domen_clear_list = null;
            foreach ($current_domen as $current_site_name) {
                $ready_site_name = $current_site_name->domen;
            }
            foreach ($domen_list as $site_name) {
                if ($ready_site_name != $site_name->domen)
                    $domen_clear_list[$site_name->id] = $site_name->domen;

            }
        }

        return view('dashboard.templates_update', array(
            'property_array' => isset($property_array) ? $property_array : null,
            'current_domen' => isset($current_domen) ? $current_domen:null,
            'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
            'user_name' => isset($user_name) ? $user_name:null
        ));
    }

    public function save_template(Request $request)
    {
        $current_domen_cookie = $request->cookie('current_domen');
        $template_inputs = Input::all();
        $user_name = Auth::user();


        $domen_id = '';
        $property_array = array();

        if(isset($current_domen_cookie)) {
            foreach ($current_domen_cookie as $current_site) {
                $domen_id = $current_site->id;
            }
        }else {
            $default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
            $domen_id = $default_domen->id;
        }


        foreach ($template_inputs as $k => $value){
            if(preg_match('/[|]/', $k)){
                $child_array = explode('|', $k);
                if(preg_match('/[:]/', $child_array[1])){
                    $child_options = explode(':', $child_array[1]);
                    $property_array[$child_array[0]]['style'][$child_options[0]][$child_options[1]] = $value;
                }
                else{
                    if($child_array[1] == 'text' || $child_array[1] == 'link' || $child_array[1] == 'position'){
                        $property_array[$child_array[0]][$child_array[1]] = $value;
                    }
                    else{
                        $property_array[$child_array[0]]['style'][$child_array[1]]['value'] = $value;
                    }

                }
            }else{
                $property_array[$k]['value'] = $value;
            }
        }

        $match = ['user_id' => $user_name['id'], 'domen_id' => $domen_id];
        $email_template = Email_templates::where($match)->get()->first();
        if(!is_object($email_template)){
            $email_template = new Email_templates;
            $email_template->domen_id = $domen_id;
            $email_template->user_id = $user_name['id'];
        }

        $property_json = json_encode($property_array);
        $email_template->properties = $property_json;


//
//        $validators = Validator::make(
//            [
//                'Domen' => $addsite_input['domen'],
//                'Посещаемость' => $addsite_input['visitor'],
//                'Размер базы' => $addsite_input['base'],
//                'Тип контента' => $addsite_input['content_type'],
//                'Категория контента' => $addsite_input['content_category'],
//            ],
//            [
//                'Domen' => 'required|max:28|unique:users_site',
//                'Посещаемость' => 'required|numeric',
//                'Размер базы' => 'required|numeric',
//                'Тип контента' => 'required|max:28',
//                'Категория контента' => 'required|max:28',
//
//            ],
//            [
//                'required' => 'Вы не заполнили поле :attribute',
//                'email' => 'Email быть корректным',
//                'unique' => 'Такой :attribute уже используется',
//                'min' => 'Поле :attribute должно содержать минимум :min символов',
//                'max' => 'Поле :attribute должно содержать максимум :max символов',
//                'numeric' => 'Поле :attribute должно содержать только цифры',
//            ]
//        );


//        // Корректность ссылки (URL)
//        function check_url($url)
//        {
//
//            if (!strstr($url,"://"))
//            {
//                $url="http://".$url;
//            }
//            if (preg_match('~^(http|https)://([A-Z0-9][A-Z0-9_-]*(?:.[A-Z0-9][A-Z0-9_-]*)+):?(d+)?/?~i', $url)) {
//                return $url;
//            }
//            return false;
//        }
//        // Существование ссылки (URL)
//        function open_url($url)
//        {
//            $url_c=parse_url($url);
//
//            if (!empty($url_c['host']) and checkdnsrr($url_c['host']))
//            {
//                // Ответ сервера
//                if ($otvet=@get_headers($url)){
//                    return substr($otvet[0], 9, 3);
//                }
//            }
//            return false;
//        }
//        $domen_check = "";
//        // Проверка ссылки
//        $url = $addsite_input['domen'];
//
//        if ($url=check_url($url))
//        {
//            // ссылка корректная
//            if ($o=open_url($url))
//            {
//                $domen_check = 'ok';
//            }
//            else
//            {
//                $domen_check = 'no'; //сервер не отвечает
//            }
//        }
//        else $domen_check = 'no'; //некорретрная ссылка

//       if ($validators->fails() || $domen_check == 'no' || $addsite_input['visitor'] < 0 || $addsite_input['base'] < 0) {
////            $errorMessage = $validators->messages();
//            $errors = "";
////            foreach ($errorMessage->all() as $messages) {
////                $errors .= $messages . " ";
////            }
//            if ($domen_check == 'no') $errors .= "Такого домена не существует" . " ";
//            if ($addsite_input['visitor'] < 0) $errors .= "Поле посещаемость должно быть ноль или больше" . " ";
//            if ($addsite_input['base'] < 0) $errors .= "Поле размер базы должно быть ноль или больше" . " ";
////
//        return \Redirect::back()->with('add_site_errors', $errors);
//        } else {
            $email_template->save(); //сохраняем сайт



            $user_name = Auth::user();
            $current_domen = Users_site::where('id', '=', $domen_id)->get();
            $domen_list = Users_site::where('user_id', '=', $user_name['id'])->get();
            if (isset($domen_list)) { //очищаем данные, чтобы уменьшить размер куки, берем только имя + id
                $domen_clear_list = null;
                foreach ($current_domen as $current_site_name) {
                    $ready_site_name = $current_site_name->domen;
                }
                foreach ($domen_list as $site_name) {
                    if ($ready_site_name != $site_name->domen)
                        $domen_clear_list[$site_name->id] = $site_name->domen;

                }
            }

            return redirect('dashboard/templates_update')->withCookie('current_domen', $current_domen)->withCookie('user_name', $user_name)->withCookie('domen_clear_list', $domen_clear_list);
        }


}