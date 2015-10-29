@include('dashboard.header_v2')


<div class="prepare_window">
    <div class="template__main col-xs-12 col-md-12">
        <?php echo Form::open(array('url' => URL::to('dashboard/templates', array(), true), 'method' => 'post', 'class' => 'change_template')); ?>
            <div class="inner__top row">
                <div class="templates__head col-md-4 col-xs-8">Редактирование шаблона</div>
                <a href="#" class="pull-right col-md-1 col-xs-2">Закрыть</a>
            </div>
            <div class="inner__main col-md-12">

                <div class="row">
                    <div class="col-xs-12 col-md-8 template__view" style="background: #e7e7e7;">

                        {{--<div class="col-md-12 col-xs-12" id="t_header">--}}
                            {{--<div class="tlogo tlogo_right">YOUR LOGO</div><p>Здравствуйте (Имя)!</p>--}}
                        {{--</div>--}}

                        {{--<div class="clb"></div>--}}

                        {{--<div class="col-md-12 col-xs-12 article_card" id="full_block">--}}
                            {{--<div class="template_img">Изображение</div>--}}
                            {{--<div class="article_title">Заголовок статьи, заголовок статьи, заголовок статьи, заголовок статьи...</div>--}}
                            {{--<a href="#" class="article_button">Подробнее</a>--}}
                        {{--</div>--}}

                        {{--<div class="clb"></div>--}}
                        {{--<div id="body_type" class="f_type">--}}
                                {{--<div class="article_card">--}}
                                    {{--<div class="template_img"></div>--}}
                                    {{--<div class="article_title">Заголовок статьи, заголовок статьи, заголовок статьи...</div>--}}
                                    {{--<a href="#" class="article_button">Подробнее</a>--}}
                                    {{--<div class="clb"></div>--}}
                                {{--</div>--}}
                                {{--<div class="article_card article_s">--}}
                                    {{--<div class="template_img"></div>--}}
                                    {{--<div class="article_title">Заголовок статьи, заголовок статьи, заголовок статьи...</div>--}}
                                    {{--<a href="#" class="article_button">Подробнее</a>--}}
                                    {{--<div class="clb"></div>--}}
                                {{--</div>--}}
                        {{--</div>--}}

                        {{--<div id="article_all" class="col-md-12 col-xs-12">Открыть еще</div>--}}
                        {{--<div class="col-md-12 col-xs-12 article_click">Если вы не видите картинки, пожалуйста <a href="" style="text-decoration: underline">нажмите сюда &#187;</a></div>--}}
                        {{--<div id="t_socials" class="col-md-12 col-xs-12"><span class="sb_text">Мы в социальных сетях</span><a href="#" class="t_vk"></a><a href="#" class="t_fb"></a></div>--}}
                        {{--<div id="t_applications" class="col-md-12 col-xs-12 af_type">--}}

                              {{--<a href="#" class="application_block app_store">Загрузите в</a>--}}
                              {{--<a href="#" class="application_block ggl_play">Загрузите на</a>--}}

                        {{--</div>--}}





                        {{--Верстка письма приходящего на почту--}}

                        start
                        <table width="100%" style="margin-bottom: 20px; max-width: 100%;" >
                            <tr style="background: white">
                                <td style="height: 90px;">
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse:collapse;line-height:100%;margin:0;padding:0;width:100%">
                                        <tr>
                                            <td align="right" valign="middle" style="border-collapse:collapse; padding:10px;">
                                                <span style="font-size: 18px; padding-right: 10px;">Здравствуйте (Имя)!</span>
                                            </td>
                                            <td align="right" valign="middle" >
                                                <div style="background: #F7CEE0;font-size: 23px; color: #A7AAA8;font-weight: 600;width: 180px;padding: 18px 0;text-align: center;margin-right: 31px;">YOUR LOGO</div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse:collapse;line-height:100%;margin:0;padding:0;width:100%; ">
                                        <tr>
                                            <td align="center" valign="middle" >
                                                <div style="background: #F7CEE0; font-size: 23px; color: #A7AAA8; font-weight: 600; padding: 150px 0; text-align: center; margin-top: 7px;">Изображение</div>
                                            </td>
                                        </tr>
                                        <tr style="background: white;">
                                            <td align="center" valign="middle" style="border-collapse:collapse;padding:10px; padding-bottom: 15px;">
                                                <span style="font-size: 18px; padding-top: 5px; margin-bottom: 4px; padding-left: 9px; font-weight: bold;text-align: left; display: block;line-height: 21px;">Заголовок статьи, заголовок статьи, заголовок статьи, заголовок статьи...</span>
                                                <a href="#" style="color: #C23B73; text-decoration: none; font-size: 12px;padding: 5px 5px; border: 1px solid #C23B73; border-radius: 3px;">Подробнее</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse:collapse;line-height:100%;margin:0;padding:0;width:100%; ">
                                        <tr>
                                            <td align="center" valign="middle" style="padding-right: 8px; padding-top: 12px;">
                                                <table cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse:collapse;line-height:100%;margin:0;padding:0;width:100%; ">
                                                    <tr>
                                                        <td align="center" valign="middle" >
                                                            <div style="background: #F7CEE0; padding: 102px 0;text-align: center;"></div>
                                                        </td>
                                                    </tr>
                                                    <tr style="background: white;">
                                                        <td align="center" valign="middle" style="border-collapse:collapse;padding:10px 10px 14px 10px;">
                                                            <span style="font-size: 15px; padding-top: 2px; margin-bottom: 21px; padding-left: 8px; font-weight: bold; text-align: left; display: block; line-height: 19px;">Заголовок статьи, заголовок статьи, заголовок статьи...</span>
                                                            <a href="#" style="color: #C23B73; text-decoration: none; font-size: 12px;padding: 5px 5px; border: 1px solid #C23B73; border-radius: 3px;">Подробнее</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="center" valign="middle" style="padding-top: 12px;">
                                                <table cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse:collapse;line-height:100%;margin:0;padding:0;width:100%; ">
                                                    <tr>
                                                        <td align="center" valign="middle" >
                                                            <div style="background: #F7CEE0; padding: 102px 0;text-align: center;"></div>
                                                        </td>
                                                    </tr>
                                                    <tr style="background: white;">
                                                        <td align="center" valign="middle" style="border-collapse:collapse;padding:10px 10px 14px 10px;">
                                                            <span style="font-size: 15px; padding-top: 2px; margin-bottom: 21px;  padding-left: 8px; font-weight: bold; text-align: left; display: block; line-height: 19px;">Заголовок статьи, заголовок статьи, заголовок статьи...</span>
                                                            <a href="#" style="color: #C23B73; text-decoration: none; font-size: 12px;padding: 5px 5px; border: 1px solid #C23B73; border-radius: 3px;">Подробнее</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 19px;">
                                    <a style="text-align: center;cursor: pointer; display: block; padding: 11px 0; font-size: 19px;color: #575B59; background: white;">Открыть еще</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="text-align: center; font-size: 17px; margin-top: 20px; display: block; margin-bottom: 17px;">Если вы не видите картинки, пожалуйста <a href="" style="text-decoration: underline">нажмите сюда &#187;</a></span>
                                </td>
                            </tr>
                            <tr>
                                <td style=" margin-top: 7px; text-align: center; padding: 21px 0; font-size: 16px; font-weight: bold; background: white;">
                                    <span style="margin: 24px 0 19px 0; text-align: center; font-size: 16px;">Мы в социальных сетях</span>
                                    <a href="#" style="padding: 2px 11px; margin: 0 0 0 10px; background: url(/images/t_icons.jpg) no-repeat 0px 1px;"></a>
                                    <a href="#" style="padding: 2px 11px; margin: 0 0 0 10px; background: url(/images/t_icons.jpg) no-repeat -27px 1px;"></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 14px;">
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" style="border-collapse:collapse;line-height:100%;margin:0;padding:0;width:100%; ">
                                        <tr>
                                            <td align="right" valign="middle" >
                                                <a style="width: 155px; color: white;padding: 2px 39px 29px 50px; background: url(/images/ap_bg.jpg) no-repeat 8px 5px black; border-radius: 9px; border: 1px solid black; font-size: 11px;">Загрузите в</a>
                                            </td>
                                            <td align="left" valign="middle" style="border-collapse:collapse;padding:10px;">
                                                <a style="width: 155px; color: white; padding: 2px 36px 29px 47px;background: url(/images/gp_bg.jpg) no-repeat 8px 4px black; border-radius: 9px; border: 1px solid black; font-size: 11px;">Загрузите на</a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        end
                    </div>


                    <div class="col-xs-12 col-md-4 template__change">
                        <p>Редактирование шаблона</p>
                        <div class="col-md-12 change__block">
                            <div class="row change__white__block">
                                <p>Тип шаблона(?)</p>
                                <div class="col-md-3 col-xs-6 change__block__input"><input type="radio" id="f1" name="images" value="y" /><label for="f1">С фото</label></div>
                                <div class="col-md-3 col-xs-6 change__block__input"><input type="radio" id="f2" name="images"  value="n" /><label for="f3">Без фото</label></div>
                                <div class="clb"></div>
                                <div class="row change_body_types">
                                    <div class="col-md-4 col-xs-4 change__block__window_1"><input type="radio" id="t1" name="body|position" value="columns" /><label for="t1"></label></div>
                                    <div class="col-md-4 col-xs-4 change__block__window_2"><input type="radio" id="t2" name="body|position"  value="column" /><label for="t2"></label></div>
                                    <div class="col-md-4 col-xs-4 change__block__window_3"><input type="radio" id="t3" name="body|position"  value="rows" /><label for="t3"></label></div>
                                </div>
                                <div class="col-md-12 col-xs-12 change__block__full__input">
                                   <input type="checkbox" id="b1" name="main_block" /><label for="b1">Полноразмерный блок для первой статьи (?)</label>
                                </div>
                                <div class="col-md-12  col-xs-12 change__block__full__input template__color">
                                    <input type="checkbox" id="c1" name="main_body|background" /><label for="c1">Цвет фона под шаблоном</label>
                                    <a class="change__color__button" href="#"></a>
                                    <input class="change__color__input" name="main_body|background:color" type="color" value="#EBEBEB"  />
                                </div>
                            </div>

                            <div class="row change__gray__block">
                                <p>Шапка шаблона(?)</p>
                                <div class="col-md-3 col-xs-3 change__block__input"><input type="checkbox" id="l1" name="logo"  /><label for="l1">Логотип</label></div>
                                <div class="col-md-3 col-xs-3 change__block__input">
                                    <input type="radio" name="logo|position" value="left" />
                                    <input type="radio" name="logo|position" value="center"/>
                                    <input type="radio" name="logo|position" value="right" />
                                </div>
                                <div class="col-md-3 col-xs-3 change__block__input">
                                    <a id="change__logo__button" href="#">Загрузить</a>
                                    <span id="change__file__text">Размер 600x350</span>
                                    <input id="change__logo__img" name="logo_image" type="file"  />
                                </div>
                                <div class="clb"></div>
                                <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                    <input type="checkbox" id="thbg" name="header|background" /><label for="thbg">Цвет окна</label>
                                    <a class="change__color__button" href="#"></a>
                                    <input class="change__color__input" name="header|background:color" type="color" value="#EBEBEB" />

                                </div>
                                <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                    <input type="checkbox" id="thbr" name="header|border" /><label for="thbr">Цвет рамки</label>
                                    <a class="change__color__button no__color" href="#"></a>
                                    <input class="change__color__input" name="header|border:color" type="color" value="#EBEBEB" />
                                </div>


                                <div class="col-md-12 col-xs-12 change__block__full__input change__block__textarea">
                                    <input type="checkbox" id="thtxt" name="header_title" /><label for="thtxt">Текст вашего приветствия</label>
                                    <span class="change__block__default" default="Здравствуйте (имя)!">По умолчанию</span>
                                    <div class="clb"></div>
                                    <textarea id="0_nic" style="width: 92%;" name="header_title|text">Здравствуйте (имя)!</textarea>
                                </div>
                            </div>

                            <div class="row change__white__block">
                                <p class="change__block__title">Карточки статей(?)</p>
                                <div class="col-md-12 col-xs-12 change__block__full__input change__design">
                                    <span>Дизайн:</span>
                                    <input type="radio" id="acart1" name="article|border-radius"  value="0px" /><label for="acart1"></label>
                                    <input type="radio" id="acart2" name="article|border-radius"  value="10px" /><label class="design__round" for="acart2"></label>
                                </div>
                                <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                    <input type="checkbox" id="acartbg" name="article|background" /><label for="acartbg">Цвет окна</label>
                                    <a class="change__color__button" href="#"></a>
                                    <input class="change__color__input" name="article|background:color" type="color" value="#EBEBEB"  />

                                </div>
                                <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                    <input type="checkbox" id="acartbr" name="article|border" /><label for="acartbr">Цвет рамки</label>
                                    <a class="change__color__button no__color" href="#"></a>
                                    <input class="change__color__input" name="article|border:color" type="color" value="#EBEBEB" />
                                </div>
                                <div class="col-md-12 col-xs-12 change__block__full__input">
                                    <span class="change__description">Настройки текста для заголовка статьи(?)</span>
                                    <div class="clb"></div>
                                    <textarea id="1_nic"  name="article_title|text" style="height: 23px;margin-bottom: 8px;width: 92%">Заголовок статьи, заголовок статьи</textarea>
                                </div>
                                <div class="col-md-12 col-xs-12 change__block__full__input">
                                    <input type="checkbox" id="abutton" name="article_button" /><label for="abutton">Кнопка на карточке статей</label>
                                </div>
                                <div class="col-md-12 col-xs-12 change__block__full__input change__design__small">
                                    <span>Дизайн:</span>
                                    <input type="radio" id="ab_br1" name="article_button|border-radius" value="0px" /><label for="ab_br1"></label>
                                    <input type="radio" id="ab_br2" name="article_button|border-radius"  value="4px" /><label class="design__round" for="ab_br2"></label>
                                    <input type="radio" id="ab_br3" name="article_button|border-radius" value="20px" /><label class="design__circle" for="ab_br3"></label>
                                </div>
                                <div class="clb"></div>
                                <div class="col-md-12 col-xs-12 change__block__full__input change__block__textarea">

                                    <span class="change__block__default" default="Подробнее">По умолчанию</span>
                                    <div class="clb"></div>
                                    <textarea id="2_nic" style="width: 92%;" name="article_button|text">Подробнее</textarea>

                                    <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                        <input type="checkbox" id="ab_bg" name="article_button|background" /><label for="ab_bg">Цвет кнопки</label>
                                        <a class="change__color__button" href="#"></a>
                                        <input class="change__color__input" name="article_button|background:color" type="color" value="#EBEBEB" />

                                    </div>
                                    <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                        <input type="checkbox" id="ab_br" name="article_button|border" /><label for="ab_br">Цвет рамки</label>
                                        <a class="change__color__button no__color" href="#"></a>
                                        <input class="change__color__input" name="article_button|border:color" type="color" value="#EBEBEB" />
                                    </div>

                                </div>
                                <div class="col-md-12 col-xs-12 change__block__full__input change__block__textarea change__block__margin">
                                    <input type="checkbox" id="a_all" name="open_else" /><label for="a_all">Кнопка под карточками статей</label><span class="change__block__default" default="Открыть еще">По умолчанию</span>
                                    <div class="clb"></div>
                                    <textarea id="3_nic"  style="width: 92%;" name="open_else|text">Открыть еще</textarea>

                                    <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                        <input type="checkbox" id="aa_bg" name="open_else|background" /><label for="aa_bg">Цвет кнопки</label>
                                        <a class="change__color__button" href="#"></a>
                                        <input class="change__color__input" name="open_else|background:color" type="color" value="#EBEBEB"  />
                                    </div>
                                    <div class="col-md-5 col-xs-5 change__block__full__input change__color__pickers">
                                        <input type="checkbox" id="aa_br" name="open_else|border" /><label for="aa_br">Цвет рамки</label>
                                        <a class="change__color__button no__color" href="#"></a>
                                        <input class="change__color__input" name="open_else|border:color" type="color" value="#EBEBEB" />
                                    </div>

                                </div>
                            </div>

                            <div class="row change__gray__block last__change__block">
                                <p class="change__block__title__gray">Футер(?)</p>
                                <div class="col-md-12 col-xs-12 change__block__full__input">
                                    <input type="checkbox" id="t_soc" name="social_buttons" /><label for="t_soc">Блок с социальными кнопками (?)</label>
                                </div>
                                <div class="col-md-12 col-xs-12 change__block__full__input change__design__small">
                                    <span>Дизайн:</span>
                                    <input type="radio" id="sb_br1" name="social_buttons|border-radius" value="0px" /><label for="sb_br1"></label>
                                    <input type="radio" id="sb_br2" name="social_buttons|border-radius" value="4px" /><label class="design__round" for="sb_br2"></label>
                                    <input type="radio" id="sb_br3" name="social_buttons|border-radius" value="20px"  /><label class="design__circle" for="sb_br3"></label>
                                    <span class="select__description">Размер</span>
                                    <select name="social_buttons|border-radius:value">
                                        <option value="5">5</option>
                                        <option value="7">7</option>
                                        <option value="10">10</option>
                                        <option value="13">13</option>
                                    </select>
                                </div>
                                <div class="clb"></div>

                                <div class="col-md-12 col-xs-12 change__block__full__input change__block__textarea">
                                    <input type="checkbox" id="sb_txt" name="sb_text" /><label for="sb_txt">Текст</label><span class="change__block__default" default="Мы в социальных сетях">По умолчанию</span>
                                    <div class="clb"></div>
                                    <textarea id="4_nic" style="width: 92%;" name="sb_text|text">Мы в социальных сетях</textarea>
                                </div>
                                <div class="col-md-12 col-xs-12 change__block__full__input change__block__text">
                                    <input type="checkbox" id="avk" name="address_vk" /><label for="avk">Адресс вашей страницы в Vk.com</label>
                                    <div class="clb"></div>
                                    <input type="text" name="address_vk|link">
                                </div>
                                <div class="col-md-12 col-xs-12 change__block__full__input change__block__text">
                                    <input type="checkbox" id="afb" name="address_fb" /><label for="afb">Адресс вашей страницы в Facebook.com</label>
                                    <div class="clb"></div>
                                    <input type="text" name="address_fb|link">
                                </div>

                                <div class="col-md-12 col-xs-12 change__block__full__input change__application__block">
                                    <input type="checkbox" id="ap_bl" name="application_block" /><label for="ap_bl">Блок с кнопками приложений (?)</label>
                                </div>

                                <div class="col-md-12 col-xs-12 change__block__full__input change__application__position">
                                    <div class="row">
                                        <div class="col-md-4 col-xs-4 change__position_1"><input type="radio" id="apt1" name="application_block|position" value="left" /><label for="apt1"></label><span>или</span></div>
                                        <div class="col-md-4 col-xs-4 change__position_2"><input type="radio" id="apt2" name="application_block|position"  value="center" /><label for="apt2"></label><span>или</span></div>
                                        <div class="col-md-3 col-xs-3 change__position_3"><input type="radio" id="apt3" name="application_block|position"  value="right" /><label for="apt3"></label></div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12 change__block__full__input change__design__small" style="margin-bottom: 22px;">
                                    <span>Дизайн:</span>
                                    <input type="radio" id="db1" name="application_link|border-radius" value="0px"   /><label for="db1"></label>
                                    <input type="radio" id="db2" name="application_link|border-radius" value="4px" /><label class="design__round" for="db2"></label>
                                    <input type="radio" id="db3" name="application_link|border-radius" value="20px"  /><label class="design__circle" for="db3"></label>
                                    <span class="select__description">Размер</span>
                                    <select name="application_link|border-radius:value">
                                        <option value="5">5</option>
                                        <option value="7">7</option>
                                        <option value="10">10</option>
                                        <option value="13">13</option>
                                    </select>
                                </div>

                                <div class="col-md-12 col-xs-12 change__block__full__input change__block__text">
                                    <input type="checkbox" id="aas" name="address_as" /><label for="aas">Адрес страницы вашего приложения в AppStore</label>
                                    <div class="clb"></div>
                                    <input type="text" name="address_as|link"  maxlength="40" />
                                </div>

                                <div class="col-md-12 col-xs-12 change__block__full__input change__block__text">
                                    <input type="checkbox" id="agp" name="address_gp" /><label for="agp">Адрес страницы вашего приложения в Google play</label>
                                    <div class="clb"></div>
                                    <input type="text" name="address_gp|link" maxlength="40" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clb"></div>
            <input type="submit" value="Сохранить" />
        </form>
    </div>
</div>
<div class="clb"></div>


<script type="text/javascript" src="/assets/js/niceEdit.js"></script>





@include('dashboard.footer')
