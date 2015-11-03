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
use Intervention\Image\ImageManagerStatic as Image;
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

        return view('dashboard.templates_page', array(
            'property_array' => isset($property_array) ? $property_array : null,
            'current_domen' => isset($current_domen) ? $current_domen:null,
            'domen_clear_list' => isset($domen_clear_list) ? $domen_clear_list:null,
            'user_name' => isset($user_name) ? $user_name:null
        ));

    }

    public function change_template(Request $request){

        $current_domen_cookie = $request->cookie('current_domen');
        $user_name = Auth::user();

        $domen_id = null;
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
            'logo_src' => isset($logo_src) ? $logo_src : null,
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
        $domen_id = null;
        $property_array = array();

        if (isset($current_domen_cookie)) {
            foreach ($current_domen_cookie as $current_site) {
                $domen_id = $current_site->id;
            }
        } else {
            $default_domen = Users_site::where('user_id', '=', $user_name['id'])->first();
            $domen_id = $default_domen->id;
        }

        foreach ($template_inputs as $k => $value) {
            if (preg_match('/[|]/', $k)) {
                $child_array = explode('|', $k);
                if (preg_match('/[:]/', $child_array[1])) {
                    $child_options = explode(':', $child_array[1]);
                    $property_array[$child_array[0]]['style'][$child_options[0]][$child_options[1]] = $value;
                } else {
                    if ($child_array[1] == 'text' || $child_array[1] == 'link' || $child_array[1] == 'position') {
                        $property_array[$child_array[0]][$child_array[1]] = $value;
                    } else {
                        $property_array[$child_array[0]]['style'][$child_array[1]]['value'] = $value;
                    }

                }
            } else {
                $property_array[$k]['value'] = $value;
            }
        }

        $match = ['user_id' => $user_name['id'], 'domen_id' => $domen_id];
        $email_template = Email_templates::where($match)->get()->first();
        if (!is_object($email_template)) {
            $email_template = new Email_templates;
            $email_template->domen_id = $domen_id;
            $email_template->user_id = $user_name['id'];
        }
        if(Input::hasFile('logo_image')){
            $logo = Input::file('logo_image');
            $logo_resize = Image::make($logo->getRealPath())->resize(600, null);
            $email_template->logo_storage = $logo_resize->encode('data-url');
        }


        $property_json = json_encode($property_array);
        $email_template->properties = $property_json;

        //TODO валидацию если необходимо
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