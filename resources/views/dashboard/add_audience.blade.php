<div class = "row welcome">
</div>
  <div class = "row">
    <div class="col-md-3"></div>
    <div class = "col-md-6 center-block">
        <section class="add_audience center-block">
        <article class="row add_audience__header">
            <div class="add_audience__first_title col-md-7 col-sm-7 col-xs-9">
            <?php
            $tmp_errors = Session::get('error_message_save');

                if(isset($current_segment_to_add)) {
                    // echo $current_segment_to_add['segment_name'];
                    echo 'Добавить подписчиков';
                }
                else echo 'Создать аудиторию';
            ?>
                
            </div>
            <div class="add_audience__button col-md-offset-2 col-sm-offset-2 col-md-3 col-sm-3 col-xs-3">Закрыть</div>
        </article>
        <?php echo Form::open(array('url' => URL::to('dashboard/add_audience_file', array(), true), 'method' => 'post', 'class' => 'add_audience__form', 'enctype'=>'multipart/form-data')); ?>
            <div class="center-text add_audience__title">
            <?php if(isset($current_segment_to_add)) {
                  echo 'Эти подписчики будут добавлены в '.'<b class="get_segment" data-segment="'.$current_segment_to_add['segment_name'].'">'.$current_segment_to_add['segment_name'].'</b>' ;  
                    }
                  else echo 'Если у вас уже собрана аудитория, добавьте её';
                ?>
            </div>
            <?php  
            if(isset($current_segment_to_add)) {
                echo Form::text('name', null, array('required', 'class' => 'add_audience__name form-control add_audience_hidden', 'placeholder'=>'Название аудитории')); 
            }
            else echo Form::text('name', null, array('required', 'class' => 'add_audience__name form-control', 'placeholder'=>'Название аудитории')); 
            ?>
            <?php echo Form::input('hidden', 'MAX_FILE_SIZE', '31457280'); ?>
            <div class="add_audience__name__ok ok_icon"></div>
            <?php echo Form::input('file', 'file', null, array('required', 'accept' => '.csv, .txt', 'required', 'class' => 'add_audience__form__file')); ?>
            <div class="add_audience__form__file__src"></div>
            <div class="add_audience__errors text-center"><?php if(isset($tmp_errors)) echo $tmp_errors; ?></div>
             <?php echo Form::submit('Загрузить файл', array('class' => 'add_audience__form__upload')); ?> 
            <div class="add_audience__form__submit btn btn-default btn-xs center-block">Загрузить файл</div>
            <div class="add_audience__form__submit__label">*Формат файла: <b>TXT</b> или <b>CSV</b> Кодировка <b>UTF-8</b> </div>
        <?php echo Form::close(); ?> 

        <div class="add_audience__FAQ row">
        <div class="sort_CSV">Необходимый порядок столбцов <b>CSV</b></div>
        <div class="table-responsive">
        <table class="table add_audience__CSV">
            <tr class="add_audience__CSV__row">
                <td class="add_audience__CSV__row__cell">1. Email</td>
                <td class="add_audience__CSV__row__cell">2. Имя</td>
                <td class="add_audience__CSV__row__cell">3. Фамилия</td>
                <td class="add_audience__CSV__row__cell">4. Пол</td>
                <td class="add_audience__CSV__row__cell">5. Возраст</td>
                <td class="add_audience__CSV__row__cell">6. Город</td>
            </tr>
        </table>
        </div>
        <div class="subscribe_CSV">Если какие-то данные о подписчике отсутствуют, оставьте столбцы пустыми</div>
        <div class="main_TXT">В файле <b>TXT</b> информация указывается последовательно в том же порядке, данные разделяются пробелом, каждый подписчик пишется с новой
        строки. Если какие-то данные отсутствуют, вместо них ставится символ «_».</div>
        <div class="example__TXT">
            1. Пример:<br/><br/>
            Email Имя Фамилия Пол Возраст Город<br/>
            Email Имя Фамилия Пол Возраст Город<br/>
            Email Имя Фамилия Пол Возраст Город<br/><br/>

            2. Пример:<br/><br/>
            Email Имя _ Пол _ Город<br/>
            Email Имя Фамилия Пол Возраст _<br/>
            Email Имя Фамилия Пол Возраст Город
        </div>
        </div>
        
        </section>
    </div>
  </div>