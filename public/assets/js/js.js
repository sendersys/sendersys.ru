$(function(){
	$('.signup_link').click(function() {
    	$('#login_form').modal('hide');
	});

	$('.login_forgot').click(function() {
    	$('#login_form').modal('hide');
	});

	$('#success_signup').modal('show');

 $('.content_type').multiselect({
 	 buttonClass: 'btn btn-default dropdown-toggle content_type__button',
 	 buttonContainer: '<div class="btn-group content_type__group" />',
 	 buttonText: function(options, select) {
                    return 'Тип контента';
                },
     selectedClass: 'multiselect-selected content_type__element',
     onChange: function(element, checked) {
	                if(checked === true) {
	                    // console.log(element);
	                }
            	}
                
 });
    $('.template_select').multiselect({
         buttonClass: 'btn btn-default dropdown-toggle content_type__button',
         buttonContainer: '<div class="btn-group content_type__group" />',
         buttonText: function(options, select) {
                        return 'Выберите шаблон';
                    },
         selectedClass: 'multiselect-selected content_type__element',
         onChange: function(element, checked) {
                        if(checked === true) {
                            // console.log(element);
                        }
                    }
    });
    $('.auditors_select').multiselect({
         buttonClass: 'btn btn-default dropdown-toggle content_type__button',
         buttonContainer: '<div class="btn-group content_type__group" />',
         buttonText: function(options, select) {
                        return 'Выберите аудиторию';
                    },
         selectedClass: 'multiselect-selected content_type__element',
         onChange: function(element, checked) {
                        if(checked === true) {
                            // console.log(element);
                        }
                    }
    });
    $('.deliveryPeriod').multiselect({
         buttonClass: 'btn btn-default dropdown-toggle content_type__button',
         buttonContainer: '<div class="btn-group content_type__group" />',
         buttonText: function(options, select) {
                        return 'Периодичность рассылки';
                    },
         selectedClass: 'multiselect-selected content_type__element',
         onChange: function(element, checked) {
                        if(checked === true) {
                            // console.log(element);
                        }
                    }
    });
    $('.deliveryTimes').multiselect({
         buttonClass: 'btn btn-default dropdown-toggle content_type__button',
         buttonContainer: '<div class="btn-group content_type__group" />',
         buttonText: function(options, select) {
                        return 'Время отправки';
                    },
         selectedClass: 'multiselect-selected content_type__element',
         onChange: function(element, checked) {
                        if(checked === true) {
                            // console.log(element);
                        }
                    }
    });

 $('.content_category').multiselect({
 	 buttonClass: 'btn btn-default dropdown-toggle content_type__button',
 	 buttonContainer: '<div class="btn-group content_type__group" />',
 	 buttonText: function(options, select) {
                    return 'Категории контента';
                },
     selectedClass: 'multiselect-selected content_type__element',
     onChange: function(element, checked) {
	                if(checked === true) {
	                    // console.log(element);
	                }
            	}
                
 });

$('.add_audience__button').click(function(){
 	$('.add_audience').css({'visibility':'hidden'});
    window.location.replace("https://sendersys.ru/dashboard/");
});

$('.add_audience__form__submit').click(function(){ //
    if($('.get_segment')) $('.add_audience__name').attr('value', $('.get_segment').attr('data-segment'));

	if($('.add_audience__name').val() && !$('.add_audience__form__file').val()) {
 		$('.add_audience__form__file').click();
 	}
    else if (!$('.add_audience__name').val()) {
        $('.add_audience__form__upload').click();
    }
    else if($('.add_audience__form__file').val()) {
        $('.add_audience__form__upload').click();
    }
});

//отображаем имя прикрепленного файла
$('.add_audience__form__file').change(function(){
	var str = $('.add_audience__form__file').val();
	if (str.lastIndexOf('\\')){
        var i = str.lastIndexOf('\\')+1;
    }
    else{
        var i = str.lastIndexOf('/')+1;
    }			
	var filename = str.slice(i);

  $('.add_audience__form__file__src').html(filename);
});

//стилизуем выпадающий список в шапке личного кабинета
$('.current_domen').click(function(){
    if($('.site_name__block').css('display')==='none' && $('.site_name__block').find('.site_name__second').length > 0) { //проверяем наличие вложенных элементов
        $('.site_name__block').fadeIn(100);
    }
    else $('.site_name__block').fadeOut(100);
});

$(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $(".site_name__block"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            div.hide(); // скрываем его
        }
});

//реализация логики вывода иконки "ок" напротив селектов

if($('.content_type').val()) $('.add_site__content_type__ok').show(); 
    else $('.add_site__content_type__ok').hide(); 

if($('.content_category').val()) $('.add_site__content_category__ok').show(); 
    else $('.add_site__content_category__ok').hide(); 

$('.content_type').change(function(){
    if($('.content_type').val()) $('.add_site__content_type__ok').show(); 
    else $('.add_site__content_type__ok').hide(); 
});

$('.content_category').change(function(){
    if($('.content_category').val()) $('.add_site__content_category__ok').show(); 
    else $('.add_site__content_category__ok').hide(); 
});


//копирование ссылки на удаление для модального окна и имени сегмента
$('.add_audience__delete__link').click(function(){
   $('.delete_segment_body .text_mail').html('Подписчики из сегмента ' + '"' + $(this).attr('data-segment-name') + '"' + ' будут удалены');
   $('.delete_segment_ok').attr('href', $(this).attr('data-link'));
});

$('.delete_segment_no').click(function(){
    $('#delete_segment').modal('hide');
});

//редактирование подписчика

$('.change_subscribers_no').click(function(){
    $('#change_subscribers').modal('hide');
});

$('#change_subscribers').modal('show');

//ajax тестовый запуск

$('.mailing__table__start__link').click(function() {
  $.ajax({
      url: "https://78.47.250.95/send_message/sender.php",
        crossDomain: true,
        data: '123',
        xhrFields: {
        withCredentials: true
        },
        success: function(out) {
        console.log(out);
        }
      });
});




});

 	