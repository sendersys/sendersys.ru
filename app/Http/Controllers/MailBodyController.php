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


class MailBodyController extends BaseController {

    public function create_body($id){

        $match = ['id' => $id];
        $email_template = Email_templates::where($match)->get()->first();

        if(is_object($email_template)){
            $property_array = json_decode($email_template->properties, true);
        }
        else{
            return false;
        }

        ////////////////////////////// Шапка шаблона и ее стили //////////////////////////////////
        $header_bg = isset($property_array['header']['style']['background']['value']) ? 'background: ' . $property_array['header']['style']['background']['color'] . ';' : '';
        $header_br = isset($property_array['header']['style']['border']['value']) ? 'border: 1px solid ' . $property_array['header']['style']['border']['color'] . ';' : '';

        $logo_center_img_style = ($property_array["logo"]["position"] == "center" && isset($property_array['header_title']['value'])) ? "margin: 20px auto 0px;" : "margin: 20px auto 20px;";
        $logo_title_style = ($property_array["logo"]["position"] == "center") ? "padding: 20px;" : "padding: 10px;";
        $logo_img_style = ($property_array["logo"]["position"] == "center") ? $logo_center_img_style : "margin-" . $property_array["logo"]["position"] . ": 31px;";
        $logo_between = ($property_array["logo"]["position"] == "center") ? "</tr><tr>" : "";

        $logo_hello =  $logo_image  = $header_block = '';
        if(isset($property_array['logo']['value'])){
            $logo_image = "<td align='" . $property_array['logo']['position'] . "' valign='middle' >
                                           <div style='background: #F7CEE0;font-size: 23px; color: #A7AAA8;font-weight: 600;width: 180px;padding: 18px 0;text-align: center;" . $logo_img_style . "'>YOUR LOGO</div>
                                      </td>" . $logo_between;
        }else{
            $property_array['logo']['position'] = 'center';
        }

        if(isset($property_array['header_title']['value'])){
            $logo_hello = "<td align='" . $property_array['logo']['position'] . "' valign='middle' style='border-collapse:collapse;" . $logo_title_style . "'>
                                           <span style='font-size: 18px;font-weight: bold;'>Здравствуйте {*name*}!</span>
                                        </td>";
        }
        $logo_position =  ($property_array["logo"]["position"] == "right")? $logo_hello . $logo_image : $logo_image . $logo_hello;

        if($logo_position){
            $header_block =  "<tr>
                                <td style='" . $header_bg . $header_br ."'>
                                   <table cellpadding='0'  width='100%' cellspacing='0' border='0' align='center' style='border-collapse:collapse;line-height:100%;margin:0;padding:0;'>
                                      <tr>
                                          " . $logo_position . "
                                     </tr>
                                  </table>
                                </td>
                              </tr>";
        }

        ////////////////////////////// Кнопка на карточке статей //////////////////////////////////
        $article_button_bg = isset($property_array['article_button']['style']['background']['value']) ? 'background: ' . $property_array['article_button']['style']['background']['color'] . ';' : '';
        $article_button_br = 'border-radius: ' . $property_array['article_button']['style']['border-radius']['value'] . ';';
        $article_button_br_color = isset($property_array['article_button']['style']['border']['value']) ? 'border: 1px solid ' . $property_array['article_button']['style']['border']['color'] . ';' : '';
        $article_button_style = $article_button_bg . ' ' . $article_button_br . ' ' . $article_button_br_color;
        $article_button_text = isset($property_array['article_button']['text']) ? $property_array['article_button']['text'] : 'Подробнее';

        $article_button = [];
        if( isset($property_array['article_button']['value'])){
            for($i = 0; $i < 3; $i++){
                $article_button[] = "<a href='{*link".$i."*}' style='color: #C23B73; text-decoration: none; font-size: 12px;padding: 5px 5px; " . $article_button_style . "'>Подробнее</a>";
            }
        }

        ///////////////////////////// Карточки статей и их стили ////////////////////////////////////
        $middle_tr = ($property_array["body"]["position"] == "columns") ? "" : "</tr><tr>";
        $article_td_style = ($property_array['body']['position'] == 'columns') ? 'padding-right: 8px;' : '';
        $columns_tr =  ($property_array['body']['position'] == 'rows') ? '' : '</tr><tr>';
        $rows_padding_style = ($property_array['body']['position'] == 'rows') ? 'padding: 70px 109px;' : 'padding: 102px 0;';
        $column_width_style = ($property_array['body']['position'] == 'column') ? 'width: 544px;' : '';
        $rows_v_align = ($property_array['body']['position'] == 'rows') ? 'top' : 'middle';

        $article_cart_bg = isset($property_array['article']['style']['background']['value']) ? 'background: ' . $property_array['article']['style']['background']['color'] . ';' : '';
        $article_cart_br = 'border-radius: ' . $property_array['article']['style']['border-radius']['value'] . ';';
        $article_cart_br_color = isset($property_array['article']['style']['border']['value']) ? 'border: 1px solid ' . $property_array['article']['style']['border']['color'] . ';' : '';
        $article_cart_style = $article_cart_bg . ' ' . $article_cart_br . ' ' . $article_cart_br_color;

        $body_types = "<tr>
                           <td>
                                <table cellpadding='0' cellspacing='0' border='0' align='center' style='border-collapse:collapse;line-height:100%;margin:0;padding:0;width:100%; '>
                                    <tr>
                                        <td align='center' valign='middle' style='" . $article_td_style  . " '>
                                            <table cellpadding='0' cellspacing='0' border='0' align='center' style='border-collapse:collapse;line-height:100%;margin:12px 0 0 0;padding:0;width:100%;".$article_cart_style." overflow: hidden; display: block;'>
                                                <tr>
                                                    <td align='center' valign='middle' >
                                                        <div class='change__template__image' style='background: #F7CEE0; " . $rows_padding_style . $column_width_style . " text-align: center;'></div>
                                                    </td>
                                                  " . $columns_tr . "
                                                     <td align='center' valign=' " .$rows_v_align. " ' style='border-collapse:collapse;padding:10px 10px 14px 10px;'>
                                                        <a href='{*link1*}' style='color: black; cursor: pointer; font-size: 15px; padding-top: 2px; margin-bottom: 21px; padding-left: 8px; font-weight: bold; text-align: left; display: block; line-height: 19px;'>Заголовок статьи, заголовок статьи, заголовок статьи...</a>
                                                         " . $article_button[1] . "
                                                     </td>
                                                  </tr>
                                            </table>
                                         </td>" . $middle_tr . "
                                         <td align='center' valign='middle'>
                                              <table cellpadding='0' cellspacing='0' border='0' align='center' style='border-collapse:collapse;line-height:100%;margin:12px 0 0 0;padding:0;width:100%;".$article_cart_style." overflow: hidden; display: block;'>
                                                   <tr>
                                                      <td align='center' valign='middle' >
                                                         <div class='change__template__image' style='background: #F7CEE0; " . $rows_padding_style . $column_width_style . " text-align: center;'></div>
                                                      </td>
                                                   " . $columns_tr . "
                                                    <td align='center' valign=' " .$rows_v_align. " ' style='border-collapse:collapse;padding:10px 10px 14px 10px;'>
                                                       <a href='{*link2*}' style='color: black; cursor: pointer; font-size: 15px; padding-top: 2px; margin-bottom: 21px; padding-left: 8px; font-weight: bold; text-align: left; display: block; line-height: 19px;'>Заголовок статьи, заголовок статьи, заголовок статьи...</a>
                                                        " . $article_button[2] . "
                                                    </td>
                                                 </tr>
                                              </table>
                                         </td>
                                    </tr>
                                </table>
                           </td>
                       </tr>";

        $full_block = "<tr>
                          <td >
                             <table cellpadding='0' cellspacing='0' align='center' style='" . $article_cart_style . "border-collapse:collapse;line-height:100%;margin:8px 0 0 0;padding:0;width:100%; overflow: hidden; display: block;'>
                                  <tr>
                                    <td align='center' valign='middle' >
                                      <div class='change__template__image' style='background: #F7CEE0; font-size: 23px; color: #A7AAA8; font-weight: 600; padding: 150px 0; text-align: center;'>Изображение</div>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td align='center' valign='middle' style='border-collapse:collapse;padding:10px 10px 15px 10px;'>
                                      <a href='{*link0*}' style=' color: black; cursor: pointer; font-size: 18px; padding-top: 5px; margin-bottom: 4px; padding-left: 9px; font-weight: bold;text-align: left; display: block;line-height: 21px;'>Заголовок статьи, заголовок статьи, заголовок статьи, заголовок статьи...</a>
                                      " . $article_button[0] . "
                                    </td>
                                 </tr>
                             </table>
                          </td>
                        </tr>";

        $full_block = isset($property_array['main_block']['value']) ? $full_block : '';

        ///////////////////////////// Открыть еще ////////////////////////////////////
        $bottom_button_bg = isset($property_array['open_else']['style']['background']['value']) ? 'background: ' . $property_array['open_else']['style']['background']['color'] . ';' : '';
        $bottom_button_br_color = isset($property_array['open_else']['style']['border']['value']) ? 'border: 1px solid ' . $property_array['open_else']['style']['border']['color'] . ';' : '';
        $bottom_button_style = $bottom_button_bg . ' ' . $bottom_button_br_color;


        $bottom_button_text = isset($property_array['open_else']['text']) ? $property_array['open_else']['text'] : 'Открыть еще';

        $open_more = "<tr>
                            <td style='padding-top: 19px;'>
                              <a href='{*open_else*}' style='text-align: center;cursor: pointer; display: block; padding: 11px 0; font-size: 19px;color: #575B59; " . $bottom_button_style . "'>Открыть еще</a>
                           </td>
                        </tr>";

        $open_more = isset($property_array['open_else']['value']) ? $open_more : '';

        ///////////////////////////// Ссылки на социальные сети и их стили ////////////////////////////////////

        $social_block_style = 'border-radius: ' . $property_array['social_buttons']['style']['border-radius']['value'] . ';';
        $social_block_text = isset($property_array['sb_text']['text']) ? $property_array['sb_text']['text'] : 'Мы в социальных сетях';


        $vk_link = $fb_link = $sb_text = $social_links = '';
        if($property_array['address_vk']['link'] && isset($property_array['address_vk']['value'])){
            $vk_link = "<a href='" . $property_array['address_vk']['link'] . "' style='padding: 2px 11px; margin: 0 0 0 10px; background: url(/images/t_icons.jpg) no-repeat 0px 1px;'></a>";
        }
        if($property_array['address_fb']['link'] && isset($property_array['address_fb']['value'])){
            $fb_link = " <a href='" . $property_array['address_fb']['link'] . "' style='padding: 2px 11px; margin: 0 0 0 10px; background: url(/images/t_icons.jpg) no-repeat -27px 1px;'></a>";
        }
        if(isset($property_array['sb_text']['value'])){
            $sb_text =  "<span style='margin: 24px 0 19px 0; text-align: center; font-size: 16px;'>Мы в социальных сетях</span>";
        }

        if(($vk_link || $fb_link) && !empty($property_array['social_buttons']['value'])){
            $social_links = "<tr>
                                        <td style='margin-top: 7px; text-align: center; padding: 21px 0; font-size: 16px; font-weight: bold; background: white;".$social_block_style."'>
                                           " . $sb_text . $vk_link . $fb_link . "
                                        </td>
                                     </tr>";
        }

        $middle_footer_tr = ($property_array["application_block"]["position"] == "left") ? "" : "</tr><tr>";
        $appstore_td_align = ($property_array["application_block"]["position"] == "center") ? "left" : "right";
        $google_td_align = ($property_array["application_block"]["position"] == "right") ? "right" : "left";
        $google_td_style = ($property_array["application_block"]["position"] == "left") ? "padding-left: 10px" : "padding-top: 10px";
        $applications_style = 'border-radius: ' . $property_array['application_link']['style']['border-radius']['value'] . ';';


        $app_positions = $as_link = $gp_link = '';
        if($property_array['address_as']['link'] && isset($property_array['address_as']['value'])){
            $as_link = "<a href='" . $property_array['address_as']['link'] . "' style='display: block; width: 155px; color: white;padding: 2px 39px 29px 50px; background: url(/images/ap_bg.jpg) no-repeat 8px 5px black; border: 1px solid black; font-size: 11px;" . $applications_style . "'>Загрузите в</a>";
        }
        if($property_array['address_gp']['link'] && isset($property_array['address_gp']['value'])){
            $gp_link = "<a href='" . $property_array['address_gp']['link'] . "' style='display: block; width: 155px; color: white; padding: 2px 36px 29px 47px; background: url(/images/gp_bg.jpg) no-repeat 8px 4px black; border: 1px solid black; font-size: 11px;" . $applications_style . "'>Загрузите на</a>";
        }

        if((!$gp_link || !$as_link) && $property_array["application_block"]["position"] == 'left'){
            $appstore_td_align = $google_td_align = 'center';
        }
        if(!$gp_link || !$as_link){
            $google_td_style = '';
        }


        if(isset($property_array['application_block']['value'])){
            $app_positions = "<tr>
                                  <td style='padding-top: 15px;'>
                                    <table cellpadding='0' cellspacing='0' border='0' align='center' style='border-collapse:collapse;line-height:100%;margin:0;padding:0;width:100%; '>
                                      <tr>
                                        <td align='" . $appstore_td_align . "' valign='middle'>
                                           " . $as_link . "
                                        </td>
                                      " . $middle_footer_tr . "
                                        <td align='" . $google_td_align . "' valign='middle' style='border-collapse:collapse;" . $google_td_style . "'>
                                           " . $gp_link . "
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                               </tr>";
        }
        ///////////////// Формирование шаблона /////////////////////////
        $str_template = "<div style=''><table width='100%' style='margin-bottom: 20px; max-width: 620px;'>"
                            . $header_block . $full_block . $body_types . $open_more .
                              "<tr><td><span style='text-align: center; font-size: 17px; margin-top: 20px; display: block; margin-bottom: 17px;'>
                                    Если вы не видите картинки, пожалуйста <a href='' style='text-decoration: underline'>нажмите сюда &#187;</a></span>
                               </td></tr>" . $social_links . $app_positions . "</table></div>";


        return $str_template;
    }
}