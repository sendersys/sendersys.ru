@include('dashboard.header_v2')

<?
//echo '<pre>';
//dd($property_array);
//echo '</pre>';

//Вспомогательные массивы
$body_classes = ['columns' => 'f_type', 'column' => 's_type', 'rows' => 't_type'];
$logo_classes = ['left' => 'tlogo_left', 'center' => 'tlogo_center', 'right' => 'tlogo_right'];
$application_classes = ['left' => 'application_center', 'center' => 'application_left', 'right' => 'application_right'];


$inner_main_bg = isset($property_array['main_body']['style']['background']['value']) ? 'background: ' . $property_array['main_body']['style']['background']['color'] . ';' : '';
$logo_class = $logo_classes[$property_array['logo']['position']];
$logo_view = isset($property_array['logo']['value']) ? '' : 'display:none;';

$logo_main =  '<div class="tlogo '. $logo_class. '" style="' . $logo_view . '">YOUR LOGO</div>';
if($logo_src){
    $logo_main = '<img class="tlogo '. $logo_class. '" src="' . $logo_src . '" style="' . $logo_view . '" />';
}


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
$social_block_text_view = isset($property_array['sb_text']['value']) ? '' : 'display:none;';
$social_block_text = isset($property_array['sb_text']['text']) ? $property_array['sb_text']['text'] : 'Мы в социальных сетях';
$social_vk_view =  isset($property_array['address_vk']['value']) ? '' : 'display:none;';
$social_vk_link =  isset($property_array['address_vk']['link']) ? $property_array['address_vk']['link'] : '';
$social_fb_view =  isset($property_array['address_fb']['value']) ? '' : 'display:none;';
$social_fb_link =  isset($property_array['address_fb']['link']) ? $property_array['address_fb']['link'] : '';

//Блок с кнопками приложений
$applications_view =  isset($property_array['application_block']['value']) ? '' : 'display:none;';
$applications_style = 'border-radius: ' . $property_array['application_link']['style']['border-radius']['value'] . ';';
$applications_class = $application_classes[$property_array['application_block']['position']];
$applications_as_view =  isset($property_array['address_as']['value']) ? '' : 'display:none;';
$applications_as_link =  isset($property_array['address_as']['link']) ? $property_array['address_as']['link'] : '';
$applications_gp_view =  isset($property_array['address_gp']['value']) ? '' : 'display:none;';
$applications_gp_link =  isset($property_array['address_gp']['link']) ? $property_array['address_gp']['link'] : '';

?>
<div class="template__main col-xs-12 col-md-12">
 <?php echo Form::open(array('url' => URL::to('dashboard/templates_save', array(), true), 'method' => 'post', 'class' => 'change_template', 'files' => true)); ?>
        <div class="inner__top row">
            <div class="templates__head col-md-4 col-xs-8">Редактирование шаблона</div>
            <a href="/dashboard/templates" class="pull-right col-md-1 col-xs-2">Закрыть</a>
        </div>
        <div class="inner__main col-md-12" style="<?php echo $inner_main_bg ?>" >
            <div class="row">
                <div class="col-xs-12 col-md-8 template__view">
                    <div class="col-md-12 col-xs-12" id="t_header" style="<?php echo $header_bg . ' ' . $header_br ?>">
                        <?php echo $logo_main ?>
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

                    <div id="t_socials" class="col-md-12 col-xs-12" style="<?php echo $social_block_view . ' ' . $social_block_style ?>">
                        <span style="<?php echo $social_block_text_view ?>"  class="sb_text"><?php echo $social_block_text ?></span>
                        <a href="#" class="t_vk" style="<?php echo $social_vk_view ?>"></a>
                        <a href="#" class="t_fb" style="<?php echo $social_fb_view ?>"></a>
                    </div>

                    <div id="t_applications" class="col-md-12 col-xs-12 <?php echo $applications_class ?>" style="<?php echo $applications_view . ' ' . $applications_style ?>">
                        <a href="#" class="application_block app_store" style="<?php echo $applications_as_view ?>">Загрузите в</a>
                        <a href="#" class="application_block ggl_play" style="<?php echo $applications_gp_view ?>">Загрузите на</a>
                    </div>


                    <div class="clb"></div>

                </div>



                <div class="col-xs-12 col-md-4 template__change">
                    <p>Редактирование шаблона</p>
                    <div class="col-md-12 change__block">
                        <div class="row change__white__block">
                            <p>Тип шаблона(?)</p>

                            <div class="col-md-3 col-xs-5 change__block__input"><?php echo Form::radio('images', '1', ($property_array['images']['value'] == '1') ? true : false, ['id' => 'f1']) ?><label for="f1">С фото</label></div>
                            <div class="col-md-3 col-xs-6 change__block__input"><?php echo Form::radio('images', '', ($property_array['images']['value'] == '') ? true : false, ['id' => 'f3']) ?><label for="f3">Без фото</label>
                            </div>
                            <div class="clb"></div>
                            <div class="row change_body_types">
                                <div class="col-md-4 col-xs-4 change__block__window_1">
                                    <?php echo Form::radio('body|position', 'columns', ($property_array['body']['position'] == 'columns') ? true : false, ['id' => 't1']) ?>
                                    <label for="t1"></label>
                                </div>
                                <div class="col-md-4 col-xs-4 change__block__window_2">
                                    <?php echo Form::radio('body|position', 'column', ($property_array['body']['position'] == 'column') ? true : false, ['id' => 't2']) ?>
                                    <label for="t2"></label>
                                </div>
                                <div class="col-md-4 col-xs-4 change__block__window_3">
                                    <?php echo Form::radio('body|position', 'rows', ($property_array['body']['position'] == 'rows') ? true : false, ['id' => 't3']) ?>
                                    <label for="t3"></label>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 change__block__full__input">
                                <?php echo Form::checkbox('main_block', 1, (isset($property_array['main_block']['value'])) ? true : false, ['id' => 'b1']) ?>
                                <label for="b1">Полноразмерный блок для первой статьи (?)</label>
                            </div>
                            <div class="col-md-12  col-xs-12 change__block__full__input template__color">
                                <?php echo Form::checkbox('main_body|background', 1, (isset($property_array['main_body']['style']['background']['value'])) ? true : false, ['id' => 'c1']) ?>
                                <label for="c1">Цвет фона под шаблоном</label>
                                <a class="change__color__button" style="background: <?php echo isset($property_array['main_body']['style']['background']['color']) ? $property_array['main_body']['style']['background']['color'] : '' ?>" href="#"></a>
                                <input class="change__color__input" name="main_body|background:color" type="color" value="<?php echo isset($property_array['main_body']['style']['background']['color']) ? $property_array['main_body']['style']['background']['color'] : '#EBEBEB' ?>"  />
                            </div>
                        </div>

                        <div class="row change__gray__block">
                            <p>Шапка шаблона(?)</p>
                            <div class="col-md-3 col-xs-3 change__block__input">
                                <?php echo Form::checkbox('logo', 1, (isset($property_array['logo']['value'])) ? true : false, ['id' => 'l1']) ?><label for="l1">Логотип</label>
                            </div>
                            <div class="col-md-3 col-xs-3 change__block__input change_logo_position">
                                <?php echo Form::radio('logo|position', 'left', ($property_array['logo']['position'] == 'left') ? true : false) ?>
                                <?php echo Form::radio('logo|position', 'center', ($property_array['logo']['position'] == 'center') ? true : false) ?>
                                <?php echo Form::radio('logo|position', 'right', ($property_array['logo']['position'] == 'right') ? true : false) ?>
                            </div>
                            <div class="col-md-3 col-xs-3 change__block__input">
                                <a id="change__logo__button" href="#">Загрузить</a>
                                <span id="change__file__text">Размер 600x350</span>
                                <input id="change__logo__img" name="logo_image" type="file"  />
                            </div>
                            <div class="clb"></div>
                            <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                <?php echo Form::checkbox('header|background', 1, (isset($property_array['header']['style']['background']['value'])) ? true : false, ['id' => 'thbg']) ?>
                                <label for="thbg">Цвет окна</label>
                                <a class="change__color__button" style="background: <?php echo isset($property_array['header']['style']['background']['color']) ? $property_array['header']['style']['background']['color'] : '' ?>" href="#"></a>
                                <input class="change__color__input" name="header|background:color" type="color" value="<?php echo isset($property_array['header']['style']['background']['color']) ? $property_array['header']['style']['background']['color'] : '#EBEBEB' ?>" />

                            </div>
                            <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                <?php echo Form::checkbox('header|border', 1, (isset($property_array['header']['style']['border']['value'])) ? true : false, ['id' => 'thbr']) ?>
                                <label for="thbr">Цвет рамки</label>
                                <a class="change__color__button no__color" style="background: <?php echo isset($property_array['header']['style']['border']['color']) ? $property_array['header']['style']['border']['color'] : '' ?>" href="#"></a>
                                <input class="change__color__input" name="header|border:color" type="color" value="<?php echo isset($property_array['header']['style']['border']['color']) ? $property_array['header']['style']['border']['color'] : '#EBEBEB' ?>" />
                            </div>
                            <div class="col-md-12 col-xs-12 change__block__full__input change__block__textarea">
                                <?php echo Form::checkbox('header_title', 1, (isset($property_array['header_title']['value'])) ? true : false, ['id' => 'thtxt']) ?>
                                <label for="thtxt">Текст вашего приветствия</label>
                                <span class="change__block__default" default="Здравствуйте (имя)!">По умолчанию</span>
                                <div class="clb"></div>
                                <textarea id="0_nic" name="header_title|text"><?php echo isset($property_array['header_title']['text']) ? $property_array['header_title']['text'] : 'Здравствуйте (имя)!' ?></textarea>
                            </div>
                        </div>

                        <div class="row change__white__block">
                            <p class="change__block__title">Карточки статей(?)</p>
                            <div class="col-md-12 col-xs-12 change__block__full__input change__design">
                                <span>Дизайн:</span>
                                <?php echo Form::radio('article|border-radius', '0px', ($property_array['article']['style']['border-radius']['value'] == '0px') ? true : false, ['id' => 'acart1']) ?>
                                <label for="acart1"></label>
                                <?php echo Form::radio('article|border-radius', '10px', ($property_array['article']['style']['border-radius']['value'] == '10px') ? true : false, ['id' => 'acart2']) ?>
                                <label class="design__round" for="acart2"></label>
                            </div>

                            <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                <?php echo Form::checkbox('article|background', 1, (isset($property_array['article']['style']['background']['value'])) ? true : false, ['id' => 'acartbg']) ?>
                                <label for="acartbg">Цвет окна</label>
                                <a class="change__color__button"  style="background: <?php echo isset($property_array['article']['style']['background']['color']) ? $property_array['article']['style']['background']['color'] : '' ?>" href="#"></a>
                                <input class="change__color__input" name="article|background:color" type="color" value="<?php echo isset($property_array['article']['style']['background']['color']) ? $property_array['article']['style']['background']['color'] : '#EBEBEB' ?>"  />

                            </div>
                            <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                <?php echo Form::checkbox('article|border', 1, (isset($property_array['article']['style']['border']['value'])) ? true : false, ['id' => 'acartbr']) ?>
                                <label for="acartbr">Цвет рамки</label>
                                <a class="change__color__button no__color" style="background: <?php echo isset($property_array['article']['style']['border']['color']) ? $property_array['article']['style']['border']['color'] : '' ?>" href="#"></a>
                                <input class="change__color__input" name="article|border:color" type="color" value="<?php echo isset($property_array['article']['style']['border']['color']) ? $property_array['article']['style']['border']['color'] : '#EBEBEB' ?>" />
                            </div>

                            <div class="col-md-12 col-xs-12 change__block__full__input">
                                <span class="change__description">Настройки текста для заголовка статьи(?)</span>
                                <div class="clb"></div>
                                <textarea id="1_nic"  name="article_title|text" style="height: 23px;"><?php echo isset($property_array['article_title']['text']) ? $property_array['article_title']['text'] : 'Заголовок статьи, заголовок статьи, заголовок статьи, заголовок статьи...' ?></textarea>
                            </div>

                            <div class="col-md-12 col-xs-12 change__block__full__input">
                                <?php echo Form::checkbox('article_button', 1, (isset($property_array['article_button']['value'])) ? true : false, ['id' => 'abutton']) ?>
                                <label for="abutton">Кнопка на карточке статей</label>
                            </div>
                            <div class="col-md-12 col-xs-12 change__block__full__input change__design__small">
                                <span>Дизайн:</span>
                                <?php echo Form::radio('article_button|border-radius', '0px', ($property_array['article_button']['style']['border-radius']['value'] == '0px') ? true : false, ['id' => 'ab_br1']) ?><label for="ab_br1"></label>
                                <?php echo Form::radio('article_button|border-radius', '4px', ($property_array['article_button']['style']['border-radius']['value'] == '4px') ? true : false, ['id' => 'ab_br2']) ?><label class="design__round" for="ab_br2"></label>
                                <?php echo Form::radio('article_button|border-radius', '20px', ($property_array['article_button']['style']['border-radius']['value'] == '20px') ? true : false, ['id' => 'ab_br3']) ?><label class="design__circle" for="ab_br3"></label>
                            </div>
                            <div class="clb"></div>
                            <div class="col-md-12 col-xs-12 change__block__full__input change__block__textarea">
                                <span class="change__block__default" default="Подробнее">По умолчанию</span>
                                <div class="clb"></div>
                                <textarea id="2_nic" name="article_button|text"><?php echo isset($property_array['article_button']['text']) ? $property_array['article_button']['text'] : 'Подробнее' ?></textarea>

                                <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                    <?php echo Form::checkbox('article_button|background', 1, (isset($property_array['article_button']['style']['background']['value'])) ? true : false, ['id' => 'ab_bg']) ?>
                                    <label for="ab_bg">Цвет кнопки</label>
                                    <a class="change__color__button" style="background: <?php echo isset($property_array['article_button']['style']['background']['color']) ? $property_array['article_button']['style']['background']['color'] : '' ?>" href="#"></a>
                                    <input class="change__color__input" name="article_button|background:color" type="color" value="<?php echo isset($property_array['article_button']['style']['background']['color']) ? $property_array['article_button']['style']['background']['color'] : '#EBEBEB' ?>" />
                                </div>
                                <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                    <?php echo Form::checkbox('article_button|border', 1, (isset($property_array['article_button']['style']['border']['value'])) ? true : false, ['id' => 'ab_br']) ?>
                                    <label for="ab_br">Цвет рамки</label>
                                    <a class="change__color__button no__color" style="background: <?php echo isset($property_array['article_button']['style']['border']['color']) ? $property_array['article_button']['style']['border']['color'] : '' ?>" href="#"></a>
                                    <input class="change__color__input" name="article_button|border:color" type="color" value="<?php echo isset($property_array['article_button']['style']['border']['color']) ? $property_array['article_button']['style']['border']['color'] : '#EBEBEB' ?>" />
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12 change__block__full__input change__block__textarea change__block__margin">
                                <?php echo Form::checkbox('open_else', 1, (isset($property_array['open_else']['value'])) ? true : false, ['id' => 'a_all']) ?>
                                <label for="a_all">Кнопка под карточками статей</label><span class="change__block__default" default="Открыть еще">По умолчанию</span>
                                <div class="clb"></div>
                                <textarea id="3_nic" name="open_else|text"><?php echo isset($property_array['open_else']['text']) ? $property_array['open_else']['text'] : 'Открыть еще' ?></textarea>

                                <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                    <?php echo Form::checkbox('open_else|background', 1, (isset($property_array['open_else']['style']['background']['value'])) ? true : false, ['id' => 'aa_bg']) ?>
                                    <label for="aa_bg">Цвет кнопки</label>
                                    <a class="change__color__button" style="background: <?php echo isset($property_array['open_else']['style']['background']['color']) ? $property_array['open_else']['style']['background']['color'] : '' ?>" href="#"></a>
                                    <input class="change__color__input" name="open_else|background:color" type="color" value="<?php echo isset($property_array['open_else']['style']['background']['color']) ? $property_array['open_else']['style']['background']['color'] : '#EBEBEB' ?>"  />
                                </div>
                                <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                    <?php echo Form::checkbox('open_else|border', 1, (isset($property_array['open_else']['style']['border']['value'])) ? true : false, ['id' => 'aa_br']) ?>
                                    <label for="aa_br">Цвет рамки</label>
                                    <a class="change__color__button no__color" style="background: <?php echo isset($property_array['open_else']['style']['border']['color']) ? $property_array['open_else']['style']['border']['color'] : '' ?>" href="#"></a>
                                    <input class="change__color__input" name="open_else|border:color" type="color" value="<?php echo isset($property_array['open_else']['style']['border']['color']) ? $property_array['open_else']['style']['border']['color'] : '#EBEBEB' ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="row change__gray__block last__change__block">
                            <p class="change__block__title__gray">Футер(?)</p>
                            <div class="col-md-12 col-xs-12 change__block__full__input">
                                <?php echo Form::checkbox('social_buttons', 1, (isset($property_array['social_buttons']['value'])) ? true : false, ['id' => 't_soc']) ?>
                                <label for="t_soc">Блок с социальными кнопками (?)</label>
                            </div>
                            <div class="col-md-12 col-xs-12 change__block__full__input change__design__small">
                                <span>Дизайн:</span>
                                <?php echo Form::radio('social_buttons|border-radius', '0px', ($property_array['social_buttons']['style']['border-radius']['value'] == '0px') ? true : false, ['id' => 'sb_br1']) ?><label for="sb_br1"></label>
                                <?php echo Form::radio('social_buttons|border-radius', '4px', ($property_array['social_buttons']['style']['border-radius']['value'] == '4px') ? true : false, ['id' => 'sb_br2']) ?><label class="design__round" for="sb_br2"></label>
                                <?php echo Form::radio('social_buttons|border-radius', '20px', ($property_array['social_buttons']['style']['border-radius']['value'] == '20px') ? true : false, ['id' => 'sb_br3']) ?><label class="design__circle" for="sb_br3"></label>

                                <span class="select__description">Размер</span>
                                <select name="social_buttons|border-radius:select">
                                    <option value="5">5</option>
                                    <option value="7">7</option>
                                    <option value="10">10</option>
                                    <option value="13">13</option>
                                </select>
                            </div>
                            <div class="clb"></div>

                            <div class="col-md-12 col-xs-12 change__block__full__input change__block__textarea">
                                <?php echo Form::checkbox('sb_text', 1, (isset($property_array['sb_text']['value'])) ? true : false, ['id' => 'sb_txt']) ?>
                                <label for="sb_txt">Текст</label><span class="change__block__default" default="Мы в социальных сетях">По умолчанию</span>
                                <div class="clb"></div>
                                <textarea id="4_nic" name="sb_text|text"><?php echo isset($property_array['sb_text']['text']) ? $property_array['sb_text']['text'] : 'Мы в социальных сетях' ?></textarea>
                            </div>
                            <div class="col-md-12 col-xs-12 change__block__full__input change__block__text">
                                <?php echo Form::checkbox('address_vk', 1, (isset($property_array['address_vk']['value'])) ? true : false, ['id' => 'avk']) ?>
                                <label for="avk">Адресс вашей страницы в Vk.com</label>
                                <div class="clb"></div>
                                <input type="text" name="address_vk|link" value="<?php echo isset($property_array['address_vk']['link']) ? $property_array['address_vk']['link'] : '' ?>" />
                            </div>
                            <div class="col-md-12 col-xs-12 change__block__full__input change__block__text">
                                <?php echo Form::checkbox('address_fb', 1, (isset($property_array['address_fb']['value'])) ? true : false, ['id' => 'afb']) ?>
                                <label for="afb">Адресс вашей страницы в Facebook.com</label>
                                <div class="clb"></div>
                                <input type="text" name="address_fb|link" value="<?php echo isset($property_array['address_fb']['link']) ? $property_array['address_vk']['link'] : '' ?>" />
                            </div>

                            <div class="col-md-12 col-xs-12 change__block__full__input change__application__block">
                                <?php echo Form::checkbox('application_block', 1, (isset($property_array['application_block']['value'])) ? true : false, ['id' => 'ap_bl']) ?>
                                <label for="ap_bl">Блок с кнопками приложений (?)</label>
                            </div>

                            <div class="col-md-12 col-xs-12 change__block__full__input change__application__position">
                                <div class="row">
                                    <div class="col-md-4 col-xs-4 change__position_1">
                                        <?php echo Form::radio('application_block|position', 'left', ($property_array['application_block']['position'] == 'left') ? true : false, ['id' => 'apt1']) ?>
                                        <label for="apt1"></label><span>или</span>
                                    </div>
                                    <div class="col-md-4 col-xs-4 change__position_2">
                                        <?php echo Form::radio('application_block|position', 'center', ($property_array['application_block']['position'] == 'center') ? true : false, ['id' => 'apt2']) ?>
                                        <label for="apt2"></label><span>или</span>
                                    </div>
                                    <div class="col-md-3 col-xs-3 change__position_3">
                                        <?php echo Form::radio('application_block|position', 'right', ($property_array['application_block']['position'] == 'right') ? true : false, ['id' => 'apt3']) ?>
                                        <label for="apt3"></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12 change__block__full__input change__design__small" style="margin-bottom: 22px;">
                                <span>Дизайн:</span>
                                <?php echo Form::radio('application_link|border-radius', '0px', ($property_array['application_link']['style']['border-radius']['value'] == '0px') ? true : false, ['id' => 'db1']) ?><label for="db1"></label>
                                <?php echo Form::radio('application_link|border-radius', '4px', ($property_array['application_link']['style']['border-radius']['value'] == '4px') ? true : false, ['id' => 'db2']) ?><label class="design__round" for="db2"></label>
                                <?php echo Form::radio('application_link|border-radius', '20px', ($property_array['application_link']['style']['border-radius']['value'] == '20px') ? true : false, ['id' => 'db3']) ?><label class="design__circle" for="db3"></label>

                                <span class="select__description">Размер</span>
                                <select name="application_link|border-radius:select">
                                    <option value="5">5</option>
                                    <option value="7">7</option>
                                    <option value="10">10</option>
                                    <option value="13">13</option>
                                </select>
                            </div>

                            <div class="col-md-12 col-xs-12 change__block__full__input change__block__text">
                                <?php echo Form::checkbox('address_as', 1, (isset($property_array['address_as']['value'])) ? true : false, ['id' => 'aas']) ?>
                                <label for="aas">Адрес страницы вашего приложения в AppStore</label>
                                <div class="clb"></div>
                                <input type="text" name="address_as|link"  maxlength="40" value="<?php echo isset($property_array['address_as']['link']) ? $property_array['address_as']['link'] : '' ?>"/>
                            </div>

                            <div class="col-md-12 col-xs-12 change__block__full__input change__block__text">
                                <?php echo Form::checkbox('address_gp', 1, (isset($property_array['address_gp']['value'])) ? true : false, ['id' => 'agp']) ?>
                                <label for="agp">Адрес страницы вашего приложения в Google play</label>
                                <div class="clb"></div>
                                <input type="text" name="address_gp|link" maxlength="40" value="<?php echo isset($property_array['address_gp']['link']) ? $property_array['address_gp']['link'] : '' ?>" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clb"></div>
        <?php echo Form::submit('Сохранить'); ?>
        <?php echo Form::close(); ?>
</div>

<div class="clb"></div>
<script type="text/javascript" src="/assets/js/niceEdit.js"></script>
</div>
@include('dashboard.footer')