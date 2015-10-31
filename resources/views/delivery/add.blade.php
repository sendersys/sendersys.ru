@include('dashboard.header_v2')

<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="add-delivery">
            <h3 class="add-delivery__title">
                Добавить рассылку
                <a href="{{ route('mailing.main')}}" class="add-delivery__title__close">закрыть</a>
            </h3>
            <div class="row">
                <div class="col-md-12">
                    {!! Form::open(array('url' => URL::to('dashboard/add_site', array(), true), 'method' => 'post')) !!}

                    <div class="col-md-12">
                            <div class="col-xs-12 col-md-8 add-delivery__template-container">

                            </div>
                            <div class="col-xs-12 col-md-4 add-delivery__configs">



                                <h5 class="add-delivery__configs__h5">Редактирование рассылки</h5>
                                <div class="input-group">
                                    {!! Form::text('name', null, array('required', 'class' => 'add_audience__name form-control', 'placeholder'=>'Название рассылки')) !!}
                                </div>
                                <br>
                                <div class="input-group">
                                    {!! Form::select('template_select', $templates_array, null, array('id' => 'template_select', 'required', 'class' => 'template_select', 'placeholder' => 'Выберите шаблон')) !!}
                                </div>
                                <br>
                                <div class="input-group">
                                    {!! Form::select('auditors_select[]', $auditors_array, null, array('id' => 'auditors_select', 'required', 'multiple', 'class' => 'auditors_select')) !!}
                                </div>
                                <div class="add_site__content_type__ok ok_icon"></div>
                                <div class="add_site__form__content__label">*Вы можете выбрать несколько вариантов</div>
                                <div class="input-group">
                                    {!! Form::checkbox('autoforming', 1, null, array('id'=>'autoforming')) !!}
                                    {!!  Form::label('autoforming', 'Формировать тему рассылки автоматически') !!}
                                </div>
                                <div class="input-group">
                                    {!! Form::text('theme', null, array('required', 'class' => 'add_audience__name form-control', 'placeholder'=>'Тема рассылки')) !!}
                                </div>
                                <div class="add_site__content_type__ok ok_icon"></div>
                                <div class="add_site__form__content__label">*Рекомендуется писать тему в формате превью</div>
                                <div class="input-group">
                                    {!! Form::text('email', null, array('required', 'class' => 'add_audience__name form-control', 'placeholder'=>'Обратный адрес')) !!}
                                </div>
                                <div class="add_site__content_type__ok ok_icon"></div>
                                <div class="add_site__form__content__label">*Укажите email для ответов пользователей</div>
                                <div class="panel-group">
                                    <h5 class="add-delivery__configs__h5">Контент</h5>
                                    <div class="input-group">
                                        <div class="col-md-6">
                                            {!! Form::radio('content', 1, true, array( 'id'=>'contentOne', 'value' => 1)) !!}
                                            {!!  Form::label('contentOne', 'Контент из XML файла') !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! Form::radio('content', 2, null, array('id'=>'contentTwo', 'value' => 2)) !!}
                                            {!!  Form::label('contentTwo', 'Добавить вручную') !!}
                                        </div>
                                    </div>
                                    <div class="input-group">
                                        {!! Form::text('xml', null, array('required', 'class' => 'add_audience__name form-control', 'placeholder'=>'Адрес XML файла')) !!}
                                    </div>
                                    <div class="add_site__content_type__ok ok_icon"></div>
                                    <div class="add_site__form__content__label">*Укажите ссылку на XML файл с контентом</div>
                                </div>
                                <h5 class="add-delivery__configs__h5">Настройки рассылки</h5>
                                <div class="input-group">
                                    <div class="col-md-6">
                                        {!! Form::radio('delivery_period', 1, true, array( 'id'=>'deliveryPeriodOne', 'value' => 1)) !!}
                                        {!!  Form::label('deliveryPeriodOne', 'Постоянная рассылка') !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::radio('delivery_period', 2, null, array('id'=>'deliveryPeriodTwo', 'value' => 2)) !!}
                                        {!!  Form::label('deliveryPeriodTwo', 'Разовая рассылка') !!}
                                    </div>
                                </div>
                                <div class="input-group">
                                    {!! Form::select('deliveryPeriod[]', $delivery_periods, null, array('id' => 'deliveryPeriod', 'required', 'multiple', 'class' => 'deliveryPeriod')) !!}
                                </div>
                                <div class="add_site__content_type__ok ok_icon"></div>
                                <div class="add_site__form__content__label">*Укажите периодичность рассылки</div>
                                <div class="input-group">
                                    {!! Form::select('deliveryTimes[]', $delivery_times, null, array('id' => 'deliveryTimes', 'required', 'multiple', 'class' => 'deliveryTimes')) !!}
                                </div>
                                <div class="add_site__content_type__ok ok_icon"></div>
                                <div class="add_site__form__content__label">*Укажите время отправки рассылки</div>
                                <div class="input-group">
                                    {!! Form::text('deliveryDate', null, array('required', 'class' => 'add_audience__name form-control', 'placeholder'=>'Дата рассылки')) !!}
                                </div>
                                <div class="add_site__content_type__ok ok_icon"></div>
                                <div class="add_site__form__content__label">*Укажите дату начала рассылки</div>


                            </div>
                        {{--<input class="btn btn-default btn-xs center-block change_subscribers_ok" type="submit" value="Сохранить">--}}

                    </div>
                    <div class="col-md-12">
                        {!! Form::submit('Сохранить', ['class' => 'btn btn-default btn-xs center-block save_delivery_ok']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.footer')