<footer class="error_page">
	<div class = "container">
		<div class = "row">
			{{-- <div class =""></div> --}}
			<div class = "col-md-6 col-md-offset-2 col-xs-12 col-sm-12">
				<a class = "agreement center-block text-center" href="http://sendersys.ru/assets/docs/Пользовательское_соглашение.docx">Пользовательское соглашение и политика конфиденциальности</a>
			</div>
			<div class = "col-md-1 col-xs-12 col-sm-12">
				<a href = "mailto:support@sendersys.ru" class = "support center-block text-center">Поддержка</a>
			</div>
		</div>
		
		<div class = "row">
			<div class = "col-md-12">
				<p class = "coop center-block text-center">2015 SenderSys</p>
			</div>
		</div>
	</div>

</footer>
<script src="/assets/js/jquery-2.1.4.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/bootstrap/js/docs.js"></script>
<script src="/assets/js/jquery-ui.min.js"></script>
<script src="/bootstrap/js/bootstrap-multiselect.js"></script>
<script src="/bootstrap/js/bootstrap-multiselect-collapsible-groups.js"></script>
<script src="/assets/js/js.js"></script>
<?php 
$login_message=null;
$signup_message=null;
if(isset($login_errors) && $login_errors !=null){
	foreach ($login_errors as $key => $login_message) {
		$login_message;
	}
}

if(isset($signup_errors) && $signup_errors !=null){
	foreach ($signup_errors as $key => $signup_message) {
		$signup_message;
	}
}

?>

<script type="text/javascript">
	var login_errors = '<?=$login_message?>';
	var signup_errors = '<?=$signup_message?>';
	if(login_errors) {
		$('.login_message').html(login_errors);
		$('.login').click();
	}

	if(signup_errors) {
		$('.signup_message').html(signup_errors);
		$('.signup_link').click();
	}
</script>
</body>
</html>
    
    
    
    
    
        