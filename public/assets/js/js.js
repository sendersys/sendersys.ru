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


if($('#change__logo__button').length)
{
    $('#change__logo__button').click(function(){
        $('#change__logo__img').click();
        return(false);
    });

    $('#change__logo__img').change(function(){
        var text = $(this).val();
        if(text) {
            $('#change__file__text').html(text);
        }
    }).change();
}


    $('.change__color__button').click(function(){
        $(this).siblings('.change__color__input')[0].click();
        return(false);
    });

    $('.change__color__input').change(function(){
        var color = $(this).val();
        if(color) {
            $(this).siblings('.change__color__button').css('background', color);
        }
    });

});

var Tchange = {
    blocks: {
        header: '#t_header',
        header_title: '#t_header p',
        logo: '.tlogo',
        main_body: '.inner__main',
        main_block: '#full_block',
        body: '#body_type',
        article: '.article_card',
        article_title: '.article_title',
        article_button: '.article_button',
        images: '.template_img',
        open_else: '#article_all',
        social_buttons: '#t_socials',
        application_block: '#t_applications',
        application_link: '#t_applications a',
        change_column: '.template__change',
        sb_text: '.sb_text',
        address_vk: '.t_vk',
        address_fb: '.t_fb',
        address_as: '.app_store',
        address_gp: '.ggl_play'

    },
    position:{
        logo:{
            left: 'tlogo_left',
            center: 'tlogo_center',
            right: 'tlogo_right'
        },
        application_block:{
            left: 'application_center',
            center: 'application_left',
            right: 'application_right'
        },
        body:{
            columns: 'f_type',
            column: 's_type',
            rows: 't_type'
        }
    },

    changeStyle: function(input, optionList) {
        var blockId = this.blocks[optionList[0]];
        var style = 'none';
        var color = '';
        var radius = input[0].value;

        if(/[:]/.test(optionList[1])) {
            var property = optionList[1].split(':');
            var main_input = $('input[name="' + optionList[0] + '|' + property[0] + '"]');
            var main_input_checked = $('input[name="' + optionList[0] + '|' + property[0] + '"]:checked');
            switch (input[0].tagName) {
                case 'INPUT':
                    if (main_input.is(':checked')) {
                        color = input[0].value;
                        style = color;
                        if (property[0] == 'border') {
                            style = '1px solid ' + style;
                        }
                        $(blockId).css(property[0], style);
                    }
                    break;
                case 'SELECT':
                    radius = radius + 'px';
                    if (main_input_checked.val() == '0px' ||  parseInt(main_input_checked.val()) > 19){
                        return false;
                    }
                    else{
                        $(blockId).css(property[0], radius);
                    }
                    break;
            }
        }
        else{
            switch (input[0].type) {
                case 'radio':
                    if(input[0].value != '0px' && parseInt(input[0].value) < 20 && (optionList[0] == 'social_buttons' || optionList[0] == 'application_link')) {
                       radius = $('select[name="' + input[0].name + ':select"]').val() + 'px';
                    }
                    $(blockId).css('border-radius', radius);
                    break;
                case 'checkbox':
                    if(input.is(':checked')){
                        color = $('input[name="' + input[0].name + ':color"]').val();
                        style = color;
                        if(optionList[1] == 'border'){
                            style = '1px solid ' + style;
                        }
                    }
                    $(blockId).css(optionList[1], style);
                    break;
            }
        }
    },

    changeView: function(input) {
        var blockId = this.blocks[input[0].name];
        switch (input[0].type) {
            case 'checkbox':
                if (input.is(':checked')) {
                   $(blockId).show();
                }
                else {
                    $(blockId).hide();
                }
                break;
            case 'radio':
                if (input.is(':checked') && input[0].value == "1") {
                    $(blockId).show();
                }
                else {
                    $(blockId).hide();
                }
                break;
        }

    },

    changeLink: function(input) {

    },

    changePosition: function(input, optionList) {
        var blockId = this.blocks[optionList[0]];
        var pos = this.position[optionList[0]];
        for (var i in pos) {
            if (pos.hasOwnProperty(i)) {
                $(blockId).removeClass(pos[i]);
            }
        }
        $(blockId).addClass(pos[input[0].value]);
    },

    handleSelected: function(input) {

        if (!input[0]) {return false;}
        var name = input.prop('name');
        if(/[|]/.test(name)) {
            var optionList = name.split('|');
            //alert(optionList.join(',,'));
            switch (optionList[1]) {
                case 'position':
                    this.changePosition(input, optionList);
                    break;
                case 'link':
                    this.changeLink(input);
                    break;
                default : this.changeStyle(input, optionList);
            }
        }
        else{
           this.changeView(input);
        }
    },


    initialize: function(selector) {
        var t = this;

        var selectors = [
            this.blocks.change_column + ' input[type="checkbox"]',
            this.blocks.change_column + ' input[type="radio"]',
            this.blocks.change_column + ' input[type="color"]',
            this.blocks.change_column + ' select'
        ];
        var text = this.blocks.change_column + ' input[type="text"]';
        var area = this.blocks.change_column + ' textarea';


        $(document).on('change', selectors.join(', '), function(e) {
            Tchange.handleSelected($(this));
        });


        bkLib.onDomLoaded(function() {
            var editor = [];
            var i = 0;
            $(area).each(function(){
                var id = $(this).attr('id');
                editor[i] = new nicEditor({
                    buttonList : ['fontFamily','bold','italic','underline', 'fontCustomSize', 'left', 'center', 'right', 'forecolor'],
                    iconsPath: "/images/nicEditorIcons.gif"
                }).panelInstance(id).addEvent('blur', function(){
                        if(this.lastContent != undefined){
                            var currentContent = editor[parseInt(id)].instanceById(id).getContent();
                            var area = $('#' + id);
                            if(currentContent != this.lastContent){
                                // content changed
                                this.lastContent = currentContent;
                                area.html(currentContent);
                                var areaList = area.attr('name').split('|');
                                $(t.blocks[areaList[0]]).html(currentContent);
                            }
                        }
                    }).addEvent('focus', function(){
                        if(this.lastContent==undefined){
                            this.lastContent = editor[parseInt(id)].instanceById(id).getContent();
                    }
                    });
                i++;
            });
        });

    }
};

if($('form.change_template').length){
    Tchange.initialize('form.change_template');
}