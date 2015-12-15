@include('errors.header_error')


<div class="modal fade" id="signup_form" tabindex="-1" role="dialog" aria-labelledby="login_label" aria-hidden="true">
    <?php echo Form::open(array('url' => URL::to('signup', array(), true), 'method' => 'post', 'class' => 'modal-dialog modal-lg')); ?>
    <div class="modal-content login-content">
        <div class="modal-header login_header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title text-center" id="login_label">����������� ��� ������� �� ���������� ����:</h4>
            <span class = "text-center login_bottom_label center-block">(�������������)</span>
        </div>
        <div class="modal-body login_body signup_body">
            <div class = "row">
                <div class = "col-md-6 col-xs-12 col-sm-6 f_login">
                    <a class="btn btn-block btn-social btn-facebook login_link" href="/login/facebook">
                        <i class="fa fa-facebook"></i> Facebook
                    </a>
                </div>
                <div class = "col-md-6 col-xs-12 col-sm-6 vk_login">
                    <a class="btn btn-block btn-social btn-vk login_link" href="/login/vkontakte">
                        <i class="fa fa-vk"></i> VKontakte
                    </a>
                </div>
            </div>

            <div class = "row">
                <h4 class="text-center second_login">��� ��� email:</h4>
            </div>
            <?php echo Form::text('username', null, array('id' => 'username', 'required', 'class' => 'form-control signup_name', 'placeholder'=>'������� ���� ���')); ?>
            <?php echo Form::email('email', null, array('id' => 'email', 'required', 'class' => 'form-control signup_email', 'placeholder'=>'������� ��� Email')); ?>
            <div class="signup_message"></div>
            <div class = "row">
                <p class = "signup_link col-md-12 col-xs-12 col-sm-12 text-center offer_accept" href = "">*������ ����� ������ �� ��������� email</a>

            </div>


        </div>
        <div class="modal-footer login_footer signup_footer">

            <?php echo Form::submit('������������������', array('class' => 'btn btn-default btn-xs center-block enter')); ?>

            <div class = "row login_support">
                <p class = "signup_link col-md-12 col-xs-12 col-sm-12 text-center offer_accept" href = "">�� ������������ � <a class = "text-underline" href="http://sendersys.ru/assets/docs/����������������_����������.docx">���������������� �����������<a></p>
            </div>
        </div>
    </div>
    <?php echo Form::close(); ?>
</div>

<div class = "row">
    <div class = "col-md-12 center-block logo-block">

        <img class = "img-responsive logo center-block" src = "/images/main-icon.jpg"/>
    </div>
</div>
<div class = "row">
    <div class = "col-md-12">
        <p class = "text-center error_page_big center-block">503</p>
    </div>
</div>
<div class = "row">
    <div class = "col-md-12">
        <p class = "text-center medium-text">������ �������� �� ��������.<br/>���������� ����� �������..<br/>
           �� ����� ���� ������ ��� ;)</p>

    </div>
</div>

</div>
</div>
</div>



<?php if(isset($emailSend) && $emailSend !=null): ?>
            
<?php endif;?>


@include('errors.footer_error')
    