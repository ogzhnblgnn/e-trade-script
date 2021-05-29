<!doctype html>
<html lang="en">
  <head>
  	<title>Admin Giriş Sayfası</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/login/style.css">

	</head>
	<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Hoş Geldiniz</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-6 col-lg-4">
					<div class="login-wrap p-0">
		      	<h3 class="mb-4 text-center">Hesabınız var mı?</h3>
		      	<form action="../netting/islem.php" class="signin-form" method="POST">
		      		<div class="form-group">
		      			<input name="kullanici_mail" type="text" class="form-control" placeholder="Mail" required >
		      		</div>
	            <div class="form-group">
	              <input name="kullanici_sifre" type="password" class="form-control" placeholder="Şifre" required>
	              <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
	            </div>
	            <div class="form-group">
	            	<button name="admingiris" type="submit" class="form-control btn btn-primary submit px-3">Giriş Yap</button>
	            </div>
	            <div class="form-group d-md-flex">
	            	<div class="w-50">
		            	<label class="checkbox-wrap checkbox-primary">Beni Hatırla
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="w-50 text-md-right">
									<a href="#" style="color: #fff">Şifremi Unuttum</a>
								</div>
	            </div>
	          </form>
	          <p class="w-100 text-center">&mdash; Ya da şununla giriş yapın &mdash;</p>
	          <div class="social d-flex text-center">
	          	<a href="#" class="px-2 py-2 mr-md-1 rounded"><span class="ion-logo-facebook mr-2"></span> Facebook</a>
	          	<a href="#" class="px-2 py-2 ml-md-1 rounded"><span class="ion-logo-twitter mr-2"></span> Twitter</a>
	          </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/login/jquery.min.js"></script>
  <script src="js/login/popper.js"></script>
  <script src="js/login/bootstrap.min.js"></script>
  <script src="js/login/main.js"></script>

	</body>
</html>

