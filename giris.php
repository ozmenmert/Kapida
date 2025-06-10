<?php 

@ob_start();
@session_start();
if (isset($_SESSION["giris"])) {
	header('location:index.php');
}

include 'ayar.php';

$pageName = 'Giriş Yap';


$meta = array(
	'title' => $pageName . $separator .  $siteData['title'],
	'description' => $siteData['description'],
	'keywords' => $siteData['keywords'],
	'author' => $siteData['author']
);

?>
<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">	
	<title><?=$meta['title']?></title>	
	<meta name="title" content="<?=$meta['title']?>">
	<meta name="description" content="<?=$meta['description']?>">
	<meta name="keywords" content="<?=$meta['keywords']?>">

	<meta name="robots" content="noindex, follow">

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="language" content="Turkish">
	<meta name="revisit-after" content="1 days">
	<meta name="author" content="<?=$meta['author']?>">
	<meta property="og:title" content="<?=$meta['title']?>" />
	<meta property="og:description" content="<?=$meta['description']?>" />
	<meta property="og:image" content="<?php echo '../'.$siteData['ayar_icon']; ?>"/>
	
	<!-- Favicon -->
	<link rel="shortcut icon" href="<?php  echo '../'.$siteData['ayar_icon']; ?>" type="image/x-icon" />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">

	<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="custom.css">

 <style>
        :root {
            --anaRenk:
            #083355            ;
        }
    </style>
</head>
<body>

	<div class="main-wrapper login-body">
		<div class="login-wrapper">
			<div class="container">
				<img class="img-fluid logo-dark" src="<?='../'.$siteData['ayar_logo']?>" alt="Logo" style="height:5rem">
				<div class="loginbox">
					<div class="login-right">
						<div class="login-right-wrap">
							<h1><?=$siteData['title']?></h1>
							<p class="account-subtitle">Sisteme Giriş Yapınız</p>
							<form action="islemler.php" method="POST">
								<div class="form-group">
									<label class="form-control-label">Email Adresiniz</label>
									<input type="email" name="email" placeholder="Email Adresiniz" class="form-control">
								</div>
								<div class="form-group">
									<label class="form-control-label">Şifreniz</label>
									<div class="pass-group">
										<input type="password" name="sifre" placeholder="Şifreniz" class="form-control pass-input">
										<span class="fas fa-eye toggle-password" id="degistir"></span>
									</div>
								</div>
								
								<button class="btn btn-lg btn-block btn-primary w-100" name="girisYap" type="submit">Giriş</button>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<script src="assets/js/jquery-3.7.0.min.js"></script>
	<script src="assets/js/bootstrap.bundle.min.js"></script>

	<script>
		$(document).ready(function () {
			$("#degistir").click(function () {
				if ($(".pass-input").attr("type") == "password") {
					$(".pass-input").attr("type", "text");
				}
				else {
					$(".pass-input").attr("type", "password");
				}
			});
		}); 
	</script>

	<!-- <script src="assets/js/script.js"></script> -->


	<?php include 'alerts.php'; ?>

</body>
</html>