<div class = "row welcome">

    <div class="col-md-4 col-md-offset-4 welcome__block">
        <?php if(!isset($second_site_code)):?><span class="welcome__block__title">Здравствуйте,
         <?php
         if($user_name['attributes']['name']) echo $user_name['attributes']['name'];
         else echo $user_name['attributes']['username'];
         ?>!</span>
        <span class="welcome__block__text">Чтобы начать использовать сервис, вам необходимо добавить информацию о вашем сайте</span>
        <?php endif; ?>
    </div>
</div>
  <div class = "row">
    <div class="col-md-3"></div>
    <div class = "col-md-6 center-block">
        <section class="add_site center-block">
        <article class="row add_site__header">
            <div class="add_site__header__title col-md-6 col-sm-6 col-xs-6">Добавить сайт</div>
            {{-- <div class="add_site__header__button col-md-6 col-sm-6 col-xs-6">Закрыть</div> --}}
        </article>
<?php echo Form::open(array('url' => URL::to('dashboard/add_site', array(), true), 'method' => 'post', 'class' => 'add_site__form')); ?>
            <?php echo Form::text('domen', null, array('id' => 'domen', 'required', 'class' => 'add_site__form__domen form-control', 'placeholder'=>'Название сайта (домен)')); ?>
            <div class="add_site__form__domen__ok ok_icon"></div>
            <div class="add_site__form__domen__label">*Это название будут видеть ваши подписчики в графе «От кого»</div>
            <?php
            foreach ($content_type as $key_type => $value_type) {
                      
                        $content_type_arr[$value_type->id] = $value_type->name;
                    } 
            echo Form::select('content_type[]', $content_type_arr, null, array('id' => 'content_type', 'required', 'multiple', 'class' => 'content_type')); ?>
            <div class="add_site__content_type__ok ok_icon"></div>
            <div class="add_site__form__content__label">*Вы можете выбрать несколько вариантов</div>
                <?php
                    foreach ($content_category as $key => $value) {
                        $content_category_arr[$value->id] = $value->name;
                    }
                    echo Form::select('content_category[]', $content_category_arr, null, array('id' => 'content_category', 'required', 'multiple', 'class' => 'content_category'));
                ?>
            <div class="add_site__content_category__ok ok_icon"></div>
            <div class="add_site__form__content__label">*Вы можете выбрать несколько вариантов</div>
            <?php echo Form::input('number', 'visitor', null, array('id' => 'visitor', 'required', 'class' => 'add_site__form__visitor form-control', 'placeholder'=>'Ежедневная посещаемость')); ?>
            <div class="add_site__form__visitor__ok ok_icon"></div>
            <div class="add_site__form__visitor__label">*Укажите среднее кол-во уникальных посетителей</div>
            <?php echo Form::input('number', 'base', null, array('id' => 'base', 'required', 'class' => 'add_site__form__base form-control', 'placeholder'=>'Размер имеющейся базы')); ?>
            <div class="add_site__form__base__ok ok_icon"></div>
            <div class="add_site__form__base__label">*Если вы хотите загрузить имеющуюся базу пользователей укажите её размер, если базы нет, напишите «0»</div>
            <p class="add_site_errors text-center"><?php echo Session::get('add_site_errors');?></p>
            <?php echo Form::submit('Отправить', array('class' => 'add_site__form__submit btn btn-default btn-xs center-block')); ?> 
         <?php echo Form::close(); ?> 
        </section>
    </div>
  </div>