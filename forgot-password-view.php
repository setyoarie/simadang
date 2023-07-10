<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Login | Aplikasi Management Gudang Konveksi</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Aplikasi Persediaan barang ">
    <meta name="author" content="Kelompok" />

    <!-- favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.png" />
    <!--===============================================================================================-->	
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->	
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="assets/plugins/login-page/css/css_login/main.css">
        <link rel="stylesheet" type="text/css" href="assets/plugins/login-page/css/css_login/util.css">
    <!--===============================================================================================-->

    <!-- Bootstrap 3.3.2 -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="assets/plugins/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="assets/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="assets/plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet" type="text/css" />


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130795909-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-130795909-1');
    </script>



</head>

<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/11.png" alt="IMG">
				</div>

				<form method="POST" action="forgot-password.php" id="formlogin" class="login100-form validate-form" >
					<span class="login100-form-title">
						Forgot Password
					</span>
					<div class="wrap-input100 validate-input">
						<input class="input100" type="text" name="email" placeholder="E-mail">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button name="proses_login" type="submit" class="login100-form-btn">
							Submit
						</button>
					</div>

					<div class="text-center p-t-136">

					</div>
				</form>
			</div>
		</div>
	</div>

    <!-- jQuery 2.1.3 -->
    <script src="assets/plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<!--===============================================================================================-->
	<script src="assets/plugins/login-page/js/js_login/main.js"></script>
	<!-- Scripts below are for demo only -->
	<script type="text/javascript" src="assets/plugins/login-page/js/js_login/main.min.js?v=1628755089081"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script>
	!function(f,b,e,v,n,t,s)
	{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '658339141622648');
	fbq('track', 'PageView');
	// notifikasi gagal di hide
	<?php if(empty($_GET['get'])){?>
		$("#notifikasi").hide();
	<?php }?>
	var logingagal = function(){
		$("#logout").fadeOut('slow');
		$("#notifikasi").fadeOut('slow');
	};
	setTimeout(logingagal, 4000);
	</script>


</body>

</html>