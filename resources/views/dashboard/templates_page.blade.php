@include('dashboard.header_v2')

<?php

$body_classes = ['columns' => 'f_type', 'column' => 's_type', 'rows' => 't_type'];
$logo_classes = ['left' => 'tlogo_left', 'center' => 'tlogo_center', 'right' => 'tlogo_right'];
$application_classes = ['left' => 'application_center', 'center' => 'application_left', 'right' => 'application_right'];


$inner_main_bg = isset($property_array['main_body']['style']['background']['value']) ? 'background: ' . $property_array['main_body']['style']['background']['color'] . ';' : '';
$logo_class = $logo_classes[$property_array['logo']['position']];
$logo_view = isset($property_array['logo']['value']) ? '' : 'display:none;';
$full_block_view = isset($property_array['main_block']['value']) ? '' : 'display:none;';
$images_view =  ($property_array['images']['value'] == '1') ? '' : 'display:none;';
$body_class = $body_classes[$property_array['body']['position']];
$header_bg = isset($property_array['header']['style']['background']['value']) ? 'background: ' . $property_array['header']['style']['background']['color'] . ';' : '';
$header_br = isset($property_array['header']['style']['border']['value']) ? 'border: 1px solid ' . $property_array['header']['style']['border']['color'] . ';' : '';
$header_title = isset($property_array['header_title']['value']) ? '' : 'display:none;';
$header_title_text = isset($property_array['header_title']['text']) ? $property_array['header_title']['text'] : 'Здравствуйте (имя)!';

//карточка статей
$article_cart_bg = isset($property_array['article']['style']['background']['value']) ? 'background: ' . $property_array['article']['style']['background']['color'] . ';' : '';
$article_cart_br = 'border-radius: ' . $property_array['article']['style']['border-radius']['value'] . ';';
$article_cart_br_color = isset($property_array['article']['style']['border']['value']) ? 'border: 1px solid ' . $property_array['article']['style']['border']['color'] . ';' : '';
$article_cart_style = $article_cart_bg . ' ' . $article_cart_br . ' ' . $article_cart_br_color;

//to do!!!!!!
$article_cart_text = isset($property_array['article_title']['text']) ? $property_array['article_title']['text'] : 'Заголовок статьи, заголовок';

//Кнопка на карточке статей
$article_button_bg = isset($property_array['article_button']['style']['background']['value']) ? 'background: ' . $property_array['article_button']['style']['background']['color'] . ';' : '';
$article_button_br = 'border-radius: ' . $property_array['article_button']['style']['border-radius']['value'] . ';';
$article_button_br_color = isset($property_array['article_button']['style']['border']['value']) ? 'border: 1px solid ' . $property_array['article_button']['style']['border']['color'] . ';' : '';
$article_button_style = $article_button_bg . ' ' . $article_button_br . ' ' . $article_button_br_color;
$article_button_text = isset($property_array['article_button']['text']) ? $property_array['article_button']['text'] : 'Подробнее';
$article_button_view = isset($property_array['article_button']['value']) ? '' : 'display:none;';

//Кнопка под карточками статей
$bottom_button_bg = isset($property_array['open_else']['style']['background']['value']) ? 'background: ' . $property_array['open_else']['style']['background']['color'] . ';' : '';
$bottom_button_br_color = isset($property_array['open_else']['style']['border']['value']) ? 'border: 1px solid ' . $property_array['open_else']['style']['border']['color'] . ';' : '';
$bottom_button_style = $bottom_button_bg . ' ' . $bottom_button_br_color;
$bottom_button_text = isset($property_array['open_else']['text']) ? $property_array['open_else']['text'] : 'Открыть еще';
$bottom_button_view = isset($property_array['open_else']['value']) ? '' : 'display:none;';

//Социальные сети
$social_block_view = isset($property_array['social_buttons']['value']) ? '' : 'display:none;';
$social_block_style = 'border-radius: ' . $property_array['social_buttons']['style']['border-radius']['value'] . ';';
$social_block_text = isset($property_array['sb_text']['text']) ? $property_array['sb_text']['text'] : 'Мы в социальных сетях';
$social_vk_view =  (isset($property_array['address_vk']['value']) && $property_array['address_vk']['link'])  ? '' : 'display:none;';
$social_vk_link =  isset($property_array['address_vk']['link']) ? $property_array['address_vk']['link'] : '';
$social_fb_view =  (isset($property_array['address_fb']['value']) && $property_array['address_fb']['link']) ? '' : 'display:none;';
$social_fb_link =  isset($property_array['address_fb']['link']) ? $property_array['address_fb']['link'] : 'Открыть еще';

//Блок с кнопками приложений
$applications_view =  isset($property_array['application_block']['value']) ? '' : 'display:none;';
$applications_style = 'border-radius: ' . $property_array['application_link']['style']['border-radius']['value'] . ';';
$applications_class = $application_classes[$property_array['application_block']['position']];
$applications_as_view =  (isset($property_array['address_as']['value']) && $property_array['address_as']['link']) ? '' : 'display:none;';
$applications_as_link =  isset($property_array['address_as']['link']) ? $property_array['address_as']['link'] : '';
$applications_gp_view =  (isset($property_array['address_gp']['value']) && $property_array['address_gp']['link'])  ? '' : 'display:none;';
$applications_gp_link =  isset($property_array['address_gp']['link']) ? $property_array['address_gp']['link'] : '';
?>

<div class="row main__template__view">
    <div class="your__template col-md-12 col-xs-12">Ваш шаблон</div>
    <div class="update__your__template col-md-12 col-xs-12">
        <span>Настройте ваш шаблон, для этого нажмите - редактировать &#187;</span> <a href="/dashboard/templates_update">редактировать</a>
    </div>
    <div class="clb"></div>
    <div id="show__template" style="<?php echo $inner_main_bg ?>" >
        <div class="template__body">

            <div class="col-md-12 col-xs-12" id="t_header" style="<?php echo $header_bg . ' ' . $header_br ?>">
                <div class="tlogo <?php echo $logo_class ?>" style="<?php echo $logo_view ?>">YOUR LOGO</div>
                <p style="<?php echo $header_title ?>"><?php echo $header_title_text ?></p>
            </div>

            <div class="clb"></div>

            <div class="col-md-12 col-xs-12 article_card" id="full_block" style="<?php echo $full_block_view . ' ' . $article_cart_style ?>">
                <div class="template_img" style="<?php echo $images_view ?>" >Изображение</div>
                <div class="article_title"><?php echo $article_cart_text ?></div>
                <a href="#" class="article_button" style="<?php echo $article_button_view . ' ' . $article_button_style ?>"><?php echo $article_button_text ?></a>
            </div>

            <div class="clb"></div>
            <div id="body_type" class="<?php echo $body_class ?>">
                <div class="article_card" style="<?php echo $article_cart_style ?>">
                    <div class="template_img" style="<?php echo $images_view ?>" ></div>
                    <div class="article_title"><?php echo $article_cart_text ?></div>
                    <a href="#" class="article_button" style="<?php echo $article_button_view . ' ' . $article_button_style ?>"><?php echo $article_button_text ?></a>
                    <div class="clb"></div>
                </div>
                <div class="article_card article_s" style="<?php echo $article_cart_style ?>">
                    <div class="template_img" style="<?php echo $images_view ?>" ></div>
                    <div class="article_title"><?php echo $article_cart_text ?></div>
                    <a href="#" class="article_button" style="<?php echo $article_button_view . ' ' . $article_button_style ?>"><?php echo $article_button_text ?></a>
                    <div class="clb"></div>
                </div>
            </div>

            <div id="article_all" class="col-md-12 col-xs-12" style="<?php echo $bottom_button_view . ' ' . $bottom_button_style ?>"><?php echo $bottom_button_text ?></div>
            <div class="col-md-12 col-xs-12 article_click">Если вы не видите картинки, пожалуйста <a href="#" style="text-decoration: underline">нажмите сюда &#187;</a></div>

            <div id="t_socials" class="col-md-12 col-xs-12" style="<?php echo $social_block_view . ' ' . $social_block_style ?>"><span class="sb_text"><?php echo $social_block_text ?></span>
                <a href="#" class="t_vk" style="<?php echo $social_vk_view ?>"></a>
                <a href="#" class="t_fb" style="<?php echo $social_fb_view ?>"></a>
            </div>

            <div id="t_applications" class="col-md-12 col-xs-12 <?php echo $applications_class ?>" style="<?php echo $applications_view . ' ' . $applications_style ?>">
                <a href="#" class="application_block app_store" style="<?php echo $applications_as_view ?>">Загрузите в</a>
                <a href="#" class="application_block ggl_play" style="<?php echo $applications_gp_view ?>">Загрузите на</a>
            </div>
        </div>
        <div class="clb"></div>
    </div>
</div>
</div>
@include('dashboard.footer')
