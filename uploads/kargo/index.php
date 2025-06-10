<?php
include('ayar.php');
$sorgu = $conn->prepare("SELECT * FROM urunler where urun_id= :urun_id");
$sorgu->execute(array('urun_id' => $urun_id));
$data = $sorgu->fetch(PDO::FETCH_ASSOC);
$sayi = $sorgu->rowCount();
if ($sayi > 0) {
	$pageName = ($data['urun_seo_title'] != '') ? $data['urun_seo_title'] : $data['urun_adi'];
	$meta = array(
		'title' => $pageName,
		'description' => $data['urun_seo_desc'],
		'keywords' => $data['urun_seo_keyw'],
		'author' => $siteData['author'],
		'ogTitle' => $pageName,
		'ogType' => 'Product',
		'ogUrl' => $data['urun_subdomain'],
		'ogImage' => $anasayfa_url . '/' . $data['urun_img']
	);
	$fiyatlandirma_sorgu = "SELECT * FROM urun_fiyatlandirma WHERE urun_id = $urun_id ORDER BY adet ASC LIMIT 1";
	$ilk_fiyatlandirma = $conn->query($fiyatlandirma_sorgu)->fetch(PDO::FETCH_ASSOC);


	$yorumSayiQuery = $conn->query("SELECT COUNT(*) AS toplam FROM yorumlar WHERE yorum_urun = $urun_id");
	$yorumSayi = $yorumSayiQuery->fetch(PDO::FETCH_ASSOC);
	$yorumSayi = $yorumSayi ? $yorumSayi['toplam'] : 0;

	$yorumToplamPuanQuery = $conn->query("SELECT SUM(yorum_puan) AS toplam FROM yorumlar WHERE yorum_urun = $urun_id");
	$yorumToplamPuan = $yorumToplamPuanQuery->fetch(PDO::FETCH_ASSOC);
	$yorumToplamPuan = $yorumToplamPuan ? $yorumToplamPuan['toplam'] : 0;

	$ortalamaYorumPuan = ($yorumSayi > 0) ? ($yorumToplamPuan / $yorumSayi) : 0;

} else {
	header('Location: ' . $anasayfa_url);
}
?>
<!doctype html>
<html lang="tr" >
<meta http-equiv="content-type" content="text/html;charset=uftf-8" />
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?= $meta['title'] ?></title>
	<meta name="title" content="<?= $meta['title'] ?>">
	<link rel="icon" href="<?= $anasayfa_url . '/' . $siteData['ayar_icon']; ?>" />
	<link rel="shortcut icon" type="image/x-icon" href="<?= $anasayfa_url . '/' . $siteData['ayar_icon']; ?>">
	<meta name="description" content="<?= $meta['description'] ?>">
	<meta name="keywords" content="<?= $meta['keywords'] ?>">
	<meta name="author" content="<?= $meta['author'] ?>">
	<meta property="og:title" content="<?= (isset($meta['ogTitle']) and $meta['ogTitle'] != '') ? $meta['ogTitle'] : $pageName . $separator . $siteData['title']; ?>" />
	<meta property="og:type" content="<?= (isset($meta['ogType']) and $meta['ogType'] != '') ? $meta['ogType'] : 'Website';  ?>" />
	<meta property="og:url" content="<?= (isset($meta['ogUrl']) and $meta['ogUrl'] != '') ? $meta['ogUrl'] : $anasayfa_url;  ?>" />
	<meta property="og:image" content="<?= (isset($meta['ogImage']) and $meta['ogImage'] != '') ? $meta['ogImage'] : $anasayfa_url . '/' . $siteData['ayar_logo'] ?>" />
	<link rel="stylesheet" href="assets/vendors/lightgallery/css/lightgallery-bundle.min.css">
	<link rel="stylesheet" href="assets/vendors/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="assets/vendors/animate/animate.min.css">
	<link rel="stylesheet" href="assets/vendors/slick/slick.css">
	<link rel="stylesheet" href="assets/vendors/mapbox-gl/mapbox-gl.min.css">
	<link rel="stylesheet" href="assets/font/bootstrap-icons.css">
	<link rel="stylesheet" href="assets/css/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
	<link rel="stylesheet" href="assets/css/theme.css">
	<?php
	if (isset($siteData['ek_script']) and $siteData['ek_script'] != '') {
		echo $siteData['ek_script'];
	}
	if (isset($data['urun_script']) and $data['urun_script'] != '') {
		echo $data['urun_script'];
	}
	?>

	<?php if (isset($data['urun_css']) and $data['urun_css'] != '') {
		echo $data['urun_css'];
	}
	?>
	<style>
		@keyframes yanip-son {
			0% { color: red; }
			50% { color: black; }
			100% { color: red; }
		}
		.yanip-sonen {
			animation: yanip-son 1s infinite;
		}
	</style>
</head>
<body>
	<header id="header" class="header header-sticky header-sticky-smart disable-transition-all z-index-5">
		<div class="sticky-area">
			<div class="main-header nav navbar bg-body navbar-light navbar-expand-xl py-6 py-xl-6">
				<div class="container-wide container flex-nowrap">
					<a href="./" class="navbar-brand px-8 py-4 mx-auto">
						<img class="light-mode-img" src="<?= $anasayfa_url . '/' . $siteData['ayar_icon']; ?>" style="height:50px;width:90%" alt="<?=$siteData['title'] ?>">
					</a>
				</div>
			</div>
		</div>
		
	</header>
	<main id="content" class="wrapper layout-page">
		<section class="container pt-6 pb-13 pb-lg-20">
			<div class="row">
				<div class="col-md-6 pe-lg-13">
					<div class="col"> <img src="#" data-src="assets/images/footer/banner2.webp" width="100%" height="auto" alt="Paypal" class="img-fluid lazy-image"></div>
					<div class="row">	
						<div class="col-12 order-0 position-relative">
							<div id="vertical-slider-slides" class="slick-slider slick-slider-arrow-inside g-0"
									data-slick-options="{&quot;arrows&quot;:true,&quot;dots&quot;:false,&quot;slidesToShow&quot;:1,&quot;autoplay&quot;:true,&quot;autoplaySpeed&quot;:3000,&quot;asNavFor&quot;:&quot;#vertical-slider-thumb&quot;}">
								<?php
								$veriCek = $conn->prepare("SELECT * FROM urun_gorselleri WHERE urun_id = :urun_id ORDER BY sira");
								$veriCek->execute(array('urun_id' => $urun_id));
								while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
									<a href="<?= $anasayfa_url . '/' . $var['img']; ?>" data-gallery="product-gallery"
									data-thumb-src="<?= $anasayfa_url . '/' . $var['img']; ?>">
										<img src="#" data-src="<?= $anasayfa_url . '/' . $var['img']; ?>" width="540" height="720"
											title class="h-auto lazy-image" alt="<?= $data['urun_adi']; ?>">
									</a>
								<?php } ?>
							</div>

							<?php if($data['urun_video']) { ?>
							<div class="col-12 text-center urunVideoBtn-bosluk">
								<a href="<?=$data['urun_video']?>" class="view-video btn btn-warning text-white urunVideoBtn px-4 py-2">
									<i class="fa fa-play"></i> Ürün videosunu izle
								</a>
							</div>
        					<?php } ?>
           
        				</div>

						<div class="col-12 order-1 mt-3">
							<div id="vertical-slider-thumb" class="slick-slider slick-slider-thumb ps-1"
									data-slick-options="{&quot;arrows&quot;:false,&quot;dots&quot;:false,&quot;slidesToShow&quot;:4,&quot;focusOnSelect&quot;:true,&quot;asNavFor&quot;:&quot;#vertical-slider-slides&quot;,&quot;infinite&quot;:true}">
								<?php
								$veriCek = $conn->prepare("SELECT * FROM urun_gorselleri WHERE urun_id = :urun_id ORDER BY sira");
								$veriCek->execute(array('urun_id' => $urun_id));
								while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
									<img src="#" data-src="<?= $anasayfa_url . '/' . $var['img']; ?>"
										class="cursor-pointer lazy-image mx-2 px-0 mb-2" width="75" height="100" title
										alt="<?= $data['urun_adi']; ?>">
								<?php } ?>
							</div>
						</div>
       
					</div>
				</div>
				<div class="col-md-6 pt-md-0 pt-10">

					<h1 class="mb-4 pb-2 fs-4"><?=$data['urun_adi'] ?></h1>
					<div class="d-flex align-items-center fs-15px mb-10">
						<p class="mb-0 fw-semibold-puan text-body-emphasis"><?php echo number_format($ortalamaYorumPuan,2); ?></p>
						<div class="d-flex align-items-center fs-12px justify-content-center mb-0 px-6 rating-result">
							<div class="rating">
								<?= yuvarlaVeYildizGoster($ortalamaYorumPuan); ?>
							</div>
						</div>
						<a href="#yorumlar" class="border-start ps-6 text-body"><?=$yorumSayi;?> Değerlendirme</a>
					</div>

					
					 <div class="topbar">
						<div class="container-wide sayacrenk container pb-5 pt-5 d-flex flex-wrap align-items-center justify-content-center">
							<div class="text-white text-center">
								<span class="fw-bolder fs-5 pb-3">SINIRLI STOK | Kampanya Bitimine </span>
							</div>
							<div class="d-flex justify-content-center align-items-center">
								<div class="mx-4 d-flex align-items-center">
									<span class="bg-white text-dark rounded px-2 py-0 mx-3 fs-5 saat"></span>
									<span class="text-white">Saat</span>
								</div>
								<div class="mx-4 d-flex align-items-center">
									<span class="bg-white text-dark rounded px-2 py-0 mx-3 fs-5 dakika"></span>
									<span class="text-white">Dakika</span>
								</div>
								<div class="mx-4 d-flex align-items-center">
									<span class="bg-white text-dark rounded px-2 py-0 mx-3 fs-5 saniye"></span>
									<span class="text-white">Saniye</span>
								</div>
							</div>
						</div>
					</div>
		
					<form class="product-info-custom">
					  <div style="background-color: #dddddd;padding: 8px;border-radius: 15px;" >
					  <h4 class="mb-101" style="text-align: center;">Ürün Adedini Seç</h4>
						<?php
						$sayac = 0;
						$veriCek = $conn->prepare("SELECT * FROM urun_fiyatlandirma WHERE urun_id = :urun_id ORDER BY adet");
						$veriCek->execute(array('urun_id' => $urun_id));
						while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>

							<div class="form-checkmb-2 pb-4 adetSecim d-flex border border-primary">
								<input type="radio" 
                                  name='adet' 
                                     data-adet="<?= $var['adet']; ?>" 
                                     data-onceki="<?= $var['onceki']; ?>" 
                                     data-fiyat="<?= $var['fiyat']; ?>" 
                                     data-kargo="<?= $var['kargo_tutar']; ?>"
                                     class="optionsRadios form-check-input product-info-input"
                                     id='optionsRadios<?= $var['urun_fiyatlandirma_id']; ?>' 
                                     value='<?= $var['urun_fiyatlandirma_id'] . ':' . $var['adet'] . ':' . $var['fiyat'] . ':' . $var['kargo_tutar'] . ':' . $var['kargo_durum']; ?>'  <?= ($sayac === 0) ? 'checked' : ''; ?>

								class="me-4 form-check-input product-info-input">
								<label for="optionsRadios<?= $var['urun_fiyatlandirma_id']; ?>" class="mx-3 text-body-emphasis-sabit-form form-check-label">
									<?= $var['adet']; ?> Adet 
									<span class="text-decoration-line-through mx-3 text-body-form"><?= $var['onceki']; ?> TL Yerine</span>
									<span class="fw-bold"><?= $var['fiyat']; ?> TL</span><br>
									<?php if ($var['kargo_durum'] == 1 and $var['kargo_tutar'] > 0) { ?>
										<span class="badge badge-danger fs-6 border text-danger fw-bold ms-4">
											+ KARGO (<?= $var['kargo_tutar'] . ' TL' ?>)
										</span>
									<?php } else { ?>
										<span class="badge badge-success fs-6 border text-success-form fw-bold ms-4">
											ÜCRETSİZ KARGO
										</span>
									<?php } ?>

								</label>



							</div>

						

							<div class="varyantlar"  id="varyantSecim<?= $var['adet']; ?>"></div>
							<?php
							$sayac++;
						} ?>
 

						<button type="button"  class="satinAlBtn btn btn-lg urun-aciklamasi mb-7 mt-7 w-100 btn-hover-bg-primary btn-hover-border-primary"> SİPARİŞİ OLUŞTUR
						</button>



										<div class="mt-10">
						<h4 class="mb-101" style="text-align: center;">Ürün Adedini Seç</h4>
						<div class="accordion" id="faqAccordion">
							<?php
							$veriCek = $conn->prepare("SELECT * FROM sss  ORDER BY id");
							$veriCek->execute();
							while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>

								<div class="accordion-item">
									<h2 class="accordion-header mb-3" id="heading<?=$var['id'] ?>">
										<button class="accordion-button collapsed bg-light border rounded" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$var['id'] ?>" aria-expanded="false" aria-controls="collapse<?=$var['id'] ?>">
											<?=$var['soru'] ?>
										</button>
									</h2>
									<div id="collapse<?=$var['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$var['id'] ?>" data-bs-parent="#faqAccordion">
										<div class="accordion-body">
											<?=$var['cevap'] ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>


					</form>					
				</div> 
			</div>
		</section>
		<div class="border-top w-100"></div>
		<section class="container pt-10 pb-12 pt-lg-10 pb-lg-20">
			<div class="collapse-tabs">
				<ul class="nav nav-tabs border-0 justify-content-center pb-12 d-none d-md-flex" id="productTabs" role="tablist">
					<li class="nav-item" role="presentation">
						<button class="nav-link m-auto fw-semiboldformfom py-0 px-8 fs-4 fs-lg-3 border-0 text-body-emphasis-sabit active" id="product-details-tab" data-bs-toggle="tab" data-bs-target="#product-details" role="tab" aria-controls="product-details" aria-selected="true">Ürün Detayları
						</button>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-inner">
						<div class="tab-pane fade active show" id="product-details" role="tabpanel" aria-labelledby="product-details-tab" tabindex="0">
							<div class="card border-0 bg-transparent">
								<div class="card-header border-0 bg-transparent px-0 py-4 product-tabs-mobile d-block d-md-none">
									<h5 class="mb-0">
										<button class="lh-2 fs-5 px-6  w-100 border"  data-bs-toggle="collapse" data-bs-target="#collapse-product-detail" aria-expanded="false" aria-controls="collapse-product-detail">
											Ürün Detayları
										</button>
									</h5>
								</div>
								
								<div class="collapse show border-md-0 border p-md-0 p-6" id="collapse-product-detail">
									<?php if ($data['urun_aciklama']!=''){ ?>
										<?=$data['urun_aciklama'] ?>
									<?php } else { ?>
										<div class="alert alert-warning">
											<h4>Açıklama eklenmedi</h4>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="border-top w-100"></div>
		<section class="container pt-15 pb-15 pt-lg-17 pb-lg-20" id="yorumlar">
			<div class="mb-1" style="background:#fff9eb !important;border-radius: 17.5px;">
				<div class="text-center p-4"><h4 class="mb-101" style="text-align: center;">Ürün Değerlendirmeleri</h4></div>
				<div class="  p-5 rounded">
					<div class="p-0 text-center">
						<div class="d-flex justify-content-center align-items-center fs-6 ls-0 mb-4">
							<div class="rating fs-5 ">
								<span class="mx-2 fw-bold fw-semiboldform-puan">
									<?php echo number_format($ortalamaYorumPuan,2); ?>
								</span>

								<?= yuvarlaVeYildizGoster($ortalamaYorumPuan); ?>
							</div>
							<span class="mx-3"> | </span>

							<span class=" fs-5"><?php echo $yorumSayi; ?> Değerlendirme</span>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-1">
				<?php if ($yorumSayi > 0) {
					$veriCek = $conn->prepare("SELECT * FROM yorumlar WHERE yorum_urun = :yorum_urun ORDER BY sira");
					$veriCek->execute(array('yorum_urun' => $urun_id));
					while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
						<div class="col-12 col-lg-4">
							<div class="border shadow my-3 py-5 px-4" style="border-radius: 17.5px;">
								<div class="d-flex flex-column mb-5">

									<div class="d-flex justify-content-between align-items-center">
										<div class="d-flex flex-column align-items-center fs-15px ls-0">
											<h5 class="mt-0 mb-0 mx-3 fs-14px text-uppercase ls-1">
												<?= $var['yorum_adi']; ?>
											</h5>
											<div class="rating">
												<?= yuvarlaVeYildizGoster($var['yorum_puan']); ?>
											</div>
										</div>
										<div class="d-flex flex-column justify-content-end align-items-end">
                                           <i class="bg-success rounded-circle border border-light bi bi-check-circle text-light fs-6 p-2"></i>
                                             <span class="fs-20 commentDate"><?= date('d.m.Y',strtotime($var['tarih'])); ?></span>
                                                 </div>
									</div>
								</div>
								<div class="py-7 px-5">
									<p class="mb-5 fs-6">
										<?= $var['yorum_aciklama']; ?>
									</p>
									<div class="mb-5">
										<?php 

										$gorsel_url = $anasayfa_url . '/' . $var['yorum_img'];
										$default_gorsel = $anasayfa_url . '/img/no-image.png';

										$yorum_images = json_decode($var['yorum_img'], true);
										if (!empty($yorum_images)) {
											foreach ($yorum_images as $image) { ?>

												<a href="<?= $anasayfa_url . '/' . $image; ?>" data-gallery="product-gallery" data-thumb-src="<?= $anasayfa_url . '/' . $image; ?>">
													<img src="#" data-src="<?= $anasayfa_url . '/' . $image; ?>" style="border-radius: 17.5px;object-fit:cover;max-height:200px;width: 100%;"  title class="h-auto lazy-image" alt="<?= $data['urun_adi']; ?>">
												</a>

											<?php }
										}                                   ?>

									</div>
								</div>
							</div>
						</div>
					<?php }
				} 
				else {
					echo '<div class="alert alert-warning"><h4>Henüz yorum eklenmedi</h4></div>';
				} ?>
			</div>

		</section>
	</main>
	<footer class="pt-15 pt-lg-20 pb-20 footer bg-section-4">
		<div class="container container-xxl pt-4">

			<div class="row align-items-center mt-0 ">
				<div class="col-sm-12 col-md-6 col-lg-4 d-flex align-items-center order-2 order-lg-1 fs-6 mt-8 mt-lg-0">
					<p class="mb-0">© <?=$siteData['title'] ?> <br> <?=date('Y') ?></p>
				</div>
				<div class="col-sm-12 col-lg-4 text-md-center order-1 order-lg-2 ">
					<a class="d-inline-block" href="<?=$anasayfa_url ?>">
						<img class="lazy-image img-fluid light-mode-img" src="#" data-src="<?= $anasayfa_url . '/' . $siteData['ayar_logo']; ?>" width="179" height="26" alt="<?=$siteData['title'] ?>">
					</a>
				</div>
				<footer>

  <div class="footer-container">
    <div class="address">
      <h4>Head Office</h4>
      <p>Eski Büyükdere Caddesi, Özcan Sk. No: 213/32, 34415 Kâğıthane/İstanbul</p>
    </div>
    <div class="address">
      <h4>TOPTAN MAĞAZA</h4>
	  <h6>Sadece Toptan Satılmaktadır.</h6>
      <p>Sururi, Hacı Küçük Sk. Sultanhamam Eminönü no:15/103, 34120 Fatih/İstanbul</p>
    </div>
	<div class="address">
      <h4>KARGO DEPO</h4>
      <p>İsmetpaşa, 85. Sk. No:92/2, 34270 Sultangazi/İstanbul</p>
    </div>

    <div class="contact">
      <h4>İletişim</h4>
	  <h6>Bu iletişim kanalları üzerinden sipariş oluşturulmamaktır. Lütfen site üzerinden sipariş oluşturunuz.</h6>
      <p>Telefon: <a href="tel:+90535 029 62 52">+90535 029 62 52</a></p>
      <p>E-posta: <a href="mailto:example@example.com">info@faworim.online</a></p>
    </div>
    <div class="location">
      <h4>Konum</h4>
      <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d188.15701328001768!2d28.970315290029237!3d41.014048529159844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14cab994a03e9e89%3A0x7cacfa6d1599267f!2zU3VydXJpLCBIYWPEsSBLw7zDp8O8ayBTay4gTm86MTUsIDM0MTIwIEZhdGloL8Swc3RhbmJ1bA!5e0!3m2!1str!2str!4v1730107382603!5m2!1str!2str"
                width="300" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      </div>
     </div>
  </div>
</footer>

				<div class="col-sm-12 col-md-6 col-lg-4 order-3 text-sm-start text-lg-end mt-8 mt-lg-0">
					<img src="#" data-src="assets/images/footer/banner03.webp" width="313" height="28" alt="Paypal" class="img-fluid lazy-image">
				</div>
			</div>
		</div>
	</footer>

	<div class="modal fade" id="quickViewModal" aria-labelledby="quickViewModal" aria-hidden="true">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header border-0 py-5">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pt-0">
					<form id="siparisForm">
		             <div id="step1" class="step">
							<div class="checkout">
								<h4 class="fs-4 text-center">Teslimat Bilgileriniz</h4>
								<h6 class="text-warningform">Eksik bilgi girilirse siparişiniz tamamlanamayabilir, lütfen doğru ve eksiksiz doldurun.</h6>

								<div class="mb-7">
									<label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">İsim Soyisim<span style="color: red; font-weight: bold;">*</span></label>
									<input type="text" class="form-controlform" id="name" name="name" placeholder="İsim Soyisim" required="">
								</div>

								<div class="mb-7">
									<label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">Telefon Numaranız<span style="color: red; font-weight: bold;">*</span></label>
									<input type="text" class="form-controlform" id="telefon" name="telefon" placeholder="(0 ile başlayınız) 0 5..." required="">
								</div>

								<div class="mb-7">
									<div class="row">
										<div class="col-md-6">
											<label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">Şehir<span style="color: red; font-weight: bold;">*</span></label>
											<select id="il" name="il" class="validate[required] line-one il form-controlform">
												<option value="">Şehir Seçiniz</option>
												<?php
												$veriCek = $conn->prepare("SELECT * FROM iller ORDER BY il_adi ASC");
												$veriCek->execute();
												while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
													<option value="<?= $var['id'] ?>"><?= $var['il_adi'] ?></option>
												<?php } ?>
											</select>
											<input type="hidden" name="ip_adres" value="<?= $_SERVER["REMOTE_ADDR"]; ?>">
										</div>
										<div class="col-md-6">
											<label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">İlçe<span style="color: red; font-weight: bold;">*</span></label>
											<select id="ilce" name="ilce" class="validate[required] line-one ilce form-controlform">
												<option value="">İlçe Seçiniz</option>
											</select>
										</div>
									</div>
								</div>

								<div class="mb-7">
									<label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase">Teslimat Adresi<span style="color: red; font-weight: bold;">*</span></label>
									<textarea class="form-controlform" rows="1" id="textarea-1" name="adres" placeholder="Mahalle, cadde & sokak, kapı ve daire no yazınız" required=""></textarea>
								</div>

								<div class="mb-7">
									<label class="mb-5 fs-13px letter-spacing-01 fw-semiboldform text-uppercase" for="textarea-2">Sipariş Notunuz</label>
									<div class="row">
										<div class="col-md-12 mb-md-0 mb-7">
											<textarea class="form-controlform" rows="1" id="textarea-2" name="not" placeholder="" required=""></textarea>
										</div>
									</div>
								</div>
						         <div style="background-color: #f0f8ff; border: 1px solid #b0c4de; padding: 5px; border-radius: 10px; font-size: 16px; color: #333;">
                                    <p style="margin: 0; line-height: 1.5;">
                                       Değerli müşterimiz, lütfen gereksiz siparişler oluşturmaktan kaçının. 
                                       Verdiğiniz siparişi özenle takip etmenizi ve zamanında teslim almanızı rica ederiz.
                                    </p>
                                 </div>


								<div class="d-flex policy mb-3" style="margin-top: 20px;">
									<input checked class="policyCheck" type="checkbox" value="1" name="policy" />
									<div style="margin-left: 4%;">
										<a id="showContract" data-fancybox="" data-id="1" href="javascript:void(0);"> Mesafeli Satış Sözleşme</a>'sini okudum ve kabul ediyorum.
									</div>
								</div>

								<button type="button" class="btn urun-aciklamasi w-100 nextStep">Devam Et</button>
							</div>
						</div>

						<div id="step2" class="step" style="display: none;">
						<div class="extra-product-offer" style="text-align: center; background-color: #f8f9fa; padding: 9px; border-radius: 0px 0px 15px 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
						<button type="button" class="btn urun-aciklamasi w-100 mt-4 siparisTamamla">Siparişi Tamamla</button>
						<button type="button" class="btn urun-aciklamasi-geri w-100 prevStep">Geri Git</button>
						<div class="checkout">
								<?php
								$promosyonSayi = $conn->query("SELECT COUNT(*) AS toplam FROM promosyon_urunler WHERE urun_id = $urun_id")->fetch(PDO::FETCH_ASSOC);
								if ($promosyonSayi['toplam'] > 0) { ?>
								<div class="form-group shop-swatch mb-7 promosyon-background align-items-center">
										
										<div class="container mb-5">
											<div class="row">
												<div class="col-12 col-lg-4"></div>
												<div class="col-12 col-lg-4">
													<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
														<div class="carousel-inner">
															<?php
															$sayac =0;
															$veriCek = $conn->prepare("SELECT * FROM promosyon_gorseller WHERE urun_id = :urun_id ORDER BY sira");
															$veriCek->execute(array('urun_id' => $urun_id));
															while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>



																<div class="carousel-item <?=($sayac==0) ? 'active' :'' ; ?>">
																	<img class="d-block w-100" src="<?= $anasayfa_url . '/' . $var['img']; ?>" alt="<?=$data['urun_adi'] ?>" style="max-height: 300px;width: auto;">
																</div>
																<?php $sayac++; } ?>
															</div>
															<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
																<span class="fa fa-arrow-left text-whitepro fs-3" aria-hidden="true"></span>
																<span class="visually-hidden">previous</span>
															</button>
															<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
																<span class="fa fa-arrow-right text-whitepro fs-3" aria-hidden="true"></span>
																<span class="visually-hidden">next</span>
															</button>

															<?php if($data['promosyon_video']) {?>
																<div class="text-center">
																	<a href="<?=$data['promosyon_video']?>" class=" view-video btn btn-info text-white urunPromoBtn px-2 py-1">
																		<i class="fa fa-play"></i>  Promosyon videosunu izle
																	</a>
																</div>
															<?php } ?>
														</div>
                                              <h4 style="color: #27ae60; font-size: 22px; font-weight: bold; margin-top:5px; text-transform: uppercase;"> Ekstra Ürün Al | %50 İNDİRİM! </h4>
                                              <p>  <span style="color: #2c3e50; font-weight: bold; font-size:16px;"> SÜRPRİZ YOK! MASRAF YOK! KARGO BİZDEN! </span> </p>
													</div>
													<div class="col-12 col-lg-4"></div>
												</div>

											</div>                                            

											<ul class="list-inline flex-column justify-content-start mb-0form">
                                                 <?php
                                                 $veriCek = $conn->prepare("SELECT * FROM promosyon_urunler WHERE urun_id = :urun_id ORDER BY promosyon_ucret");
                                                 $veriCek->execute(array('urun_id' => $urun_id));
                                                 $firstItem = true; // Variable to check if it's the first item
                                                  while ($var = $veriCek->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <li class="list-inline-item me-4 mb-3 fw-semibold position-relative" style="width:100%" >
                                             <input type="checkbox" id="checkbox-<?= $var['promosyon_id']; ?>" 
                                                     value='<?= $var['promosyon_id']; ?>:<?= $var['promosyon_ucret']; ?>'
                                                name='promosyon[]' data-fiyat="<?= $var['promosyon_ucret']; ?>"
                                                  class="product-info-size d-none">

                                                     <label for="checkbox-<?= $var['promosyon_id']; ?>" class="promosyon-isim p-4 d-block rounded text-decoration-none border" style="border:1px solid #a0a0a0" data-var="full size">
                                                                 <span><?= $var['promosyon_adi']; ?></span><br>
                                                           <span class="text-decoration-line-through mx-3 onceki-text-body"><?= $var['promosyon_onceki']; ?> TL</span>
                                                                  <b> +<?= $var['promosyon_ucret']; ?> TL</b>
                                                      </label>
													  <?php if ($firstItem) { ?> 
                                                      <i class="fas fa-fire flame-icon" aria-hidden="true"></i>
                                                       <?php $firstItem = false; // Set it to false after the first item ?>
                                                               <?php } ?>
													                                                        
                                             </li>
                                              <?php } ?>
                                        </ul>										

										</div>
									</div>


									<?php } ?>

                                 
													
									<div class="form-group shop-swatch mb-7 promosyon-background align-items-center">
										<div class="container mb-5">
										
									
										<div style="background-color: #dddddd;padding: 8px;border-radius: 15px; margin-top:10px;" >
											<h4 class="mb-101" style="text-align: center;">Ödeme Şekli</h4>

											<div class="mb-7-step22 mb-100 d-flex justify-content-start radio-container">
											<div class="form-check mb-2 pb-4 adetSecimpro d-flex border border-primary active" data-odeme="1">
													<input class="form-check-input odemeSecim" type="radio" name="odeme" id="odeme1" value="Kapıda Nakit Ödeme" style="display:none" checked>
													<label class="form-check-label text-body-emphasis-sabit-form " for="odeme1">Kapıda Nakit</label>
												</div>
												<div class="form-check mb-2 pb-4 adetSecimpro d-flex border border-primary" data-odeme="0">
												<input class="form-check-input odemeSecim" type="radio" name="odeme" id="odeme2" style="display:none" value="Kapıda Kart ile Ödeme">
												<label class="form-check-label text-body-emphasis-sabit-form " for="odeme2">  Kapıda Kredi Kartı </label>
												</div>
											</div>
				    					</div>

					                    <div class="mb-7-step2 mb-100 d-flex flex-column justify-content-center">
										<h4 class="mb-101" style="text-align: center;">Kargo Firmasını Seç</h4>								
										<div class="mb-7 text-center">
											<table style="width:100%!important; text-align: left;">
													<?php
														$sayac=0;
														$veriCek=$conn->prepare("SELECT * FROM kargo_firmalar WHERE durum = 1 ORDER BY kargo_adi ASC");
														$veriCek->execute();														
														while ($var=$veriCek->fetch(PDO::FETCH_ASSOC)) {?>
														<tr>
															<td style="width:30%;">
															</td>
															<td align="left">
																<input type="radio" name="siparis_kargo_firma" id="siparis_kargo_firma" style="font-size:18px;" value="<?=$var['kargo_id']?>" <?= ($sayac === 0) ? 'checked' : ''; ?>/>
																<img src="https://faworim.online/<?=$var['kargo_img']; ?>" alt="<?=$var['kargo_adi'] ?>" style="max-height: 30px;width: auto; margin-bottom: 10px;">
															</td>
														</tr>
													<?php $sayac++; } ?>
											</table>
										</div>

										<div class="text-center" style="font-size:15px">
										<p>Siparişiniz <strong style="color:red;">1-5 iş günü</strong> içerisinde şeffaf kargo ile adresinize teslim edilecektir.</p>
										</div>
										
									</div>
									<div class="text-center">
									            <h4 class="mb-101" style="text-align: center;">Toplam Ödemeniz:</h4>
												<p class="toplamOdemesayafasi toplamtutar-tamamla"></p>
											</div>
											
									
									                               
							        </div>	
                                    </div>
									<button type="button" class="btn urun-aciklamasi w-100 mt-4 siparisTamamla">Siparişi Tamamla</button>
									<button type="button" class="btn urun-aciklamasi-geri w-100 prevStep">Geri Git</button>

								</div>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
	</div>

		<div class="altMenu bg-light pb-0 pt-3">
			<div class="row d-flex justify-content-between align-items-center p-415">
				<div class="col">
					<div class="d-flex w-100 align-items-center">
						<div class="me-6 mobile-hidden">
							<img src="<?=$anasayfa_url.'/'.$data['urun_img'] ?>" class="loaded" width="60" height="50" alt="<?=$data['urun_adi'] ?>" loading="lazy" data-ll-status="loaded">
						</div>
						<div class="d-flex flex-column p-3">

						     <h4 id="product-title-adet" class="product-title card-title text-body-emphasis-sabitform fs-15px fw-500 mb-3">
                                 <?=$data['urun_adi'] ?>
                             </h4>

							<div id="adetBilgisi" class="price altmenufiyatcolor fw-bold justify-content-center fs-6 badge toplamOdeme">		
                            </div>

						</div>
					</div>
				</div>
				
			</div>
		</div>

		<div class="position-fixed z-index-10 end-0 p-5" style="bottom: 185px !important;">
			<a href="#" class="gtf-back-to-top text-decoration-none bg-body text-primary bg-primary-hover text-light-hover shadow square p-0 rounded-circle d-flex align-items-center justify-content-center" title="Back To Top" style="--square-size: 48px"><i class="fa-solid fa-arrow-up"></i></a>
		</div>

<div class="notification-container" id="orderNotification" style="display: none;">
    <i class="fa fa-bell"></i>
    <span id="orderMessage"></span>
    <button class="close-notification" onclick="hideOrderNotification()">×</button>
</div>
<div class="feature-container" id="featureNotification"></div>





		<?php if ($data['urun_whatsapp'] != '') { ?>
			<a href="https://api.whatsapp.com/send/?phone=+<?= $data['urun_whatsapp']; ?>&text=<?= urlencode($data['urun_adi'] . ' ürününden sipariş vermek istiyorum'); ?>" target="_blank" id="whatsapBtn">
				<img src="<?= $anasayfa_url . '/'; ?>img/whatsapp.svg" alt="<?= $data['urun_adi']; ?>" style="width: 50px;height: 50px;">
			</a>
		<?php } ?>

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/vendors/bootstrap/js/bootstrap.bundle.js"></script>
		<script src="assets/vendors/clipboard/clipboard.min.js"></script>
		<script src="assets/vendors/vanilla-lazyload/lazyload.min.js"></script>
		<script src="assets/vendors/waypoints/jquery.waypoints.min.js"></script>
		<script src="assets/vendors/lightgallery/lightgallery.min.js"></script>
		<script src="assets/vendors/lightgallery/plugins/zoom/lg-zoom.min.js"></script>
		<script src="assets/vendors/lightgallery/plugins/thumbnail/lg-thumbnail.min.js"></script>
		<script src="assets/vendors/lightgallery/plugins/video/lg-video.min.js"></script>
		<script src="assets/vendors/lightgallery/plugins/vimeoThumbnail/lg-vimeo-thumbnail.min.js"></script>
		<script src="assets/vendors/isotope/isotope.pkgd.min.js"></script>
		<script src="assets/vendors/slick/slick.min.js"></script>
		<script src="assets/vendors/gsap/gsap.min.js"></script>
		<script src="assets/vendors/gsap/ScrollToPlugin.min.js"></script>
		<script src="assets/vendors/gsap/ScrollTrigger.min.js"></script>
		<script src="assets/vendors/mapbox-gl/mapbox-gl.js"></script>
		<script src="assets/js/theme.min.js"></script>
		<script src="assets/js/ziyaretci.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
		<script src="assets/js//sweetalert2.min.js"></script>

<script>
			const ToastTopEnd = Swal.mixin({
				toast: true,
				position: 'center',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			});

			$('#telefon').inputmask('9 999 999 99 99');
			$(document).on('change', 'select.il', function(e) {
				e.preventDefault();
				var pr_id = $(this).val();
				$.ajax({
					type: 'POST',
					url: 'town.php',
					data: {
						city_code: pr_id,
					},
					success: function(data) {
						$('select.ilce').html('');
						$('select.ilce').html(data);
					}
				});
			});

			<?php if (isset($_GET['status']) and $_GET['status'] == 'error_order') { ?>
				swal({
					title: "İşlem Başarısız!",
					text: "10 Dakika İçerisinde En Fazla 2 Sipariş Verebilirsiniz. Bir Sonraki Sipariş İçin 10 Dakika Bekleyiniz.",
					icon: "error",
					buttons: false
				})
				.then(() => {
					window.location = './';
				});
			<?php } ?>	$('#quickViewModal').on('shown.bs.modal', function() {
				$('.adetSecimpro').click(function() {
					var selectedOdeme = $(this).data('odeme');
					$('#kargo').val('');

					if (selectedOdeme == 1) {
						console.log('Kapıda Nakit Ödeme seçildi.');
						$('#kargo option').each(function() {
							$(this).prop('disabled', false).show();
						});
					} else if (selectedOdeme == 0) {
						console.log('Kapıda Kart ile Ödeme seçildi.');
						$('#kargo option').each(function() {
							var kargoID = $(this).val();
							console.log('Kargo ID: ', kargoID);
							if (kargoID == 5 || kargoID == 11) {
								$(this).prop('disabled', true).hide();
							} else {
								$(this).prop('disabled', false).show();
							}
						});
					}
				});				

				$('.adetSecimpro input[type="radio"]:checked').closest('.adetSecimpro').trigger('click');
			});

			$('.form-check-label').click(function() {
				$(this).prev('input[type="radio"]').prop('checked', true).trigger('change');
			});
			$('.siparisTamamla').click(function(event) {
				event.preventDefault();

				var telefon = $('#telefon').val();
				var numericTelefon = telefon.replace(/\D/g, '');

				var adet = $('input[name="adet"]:checked').val();
				if (!adet) {
					$('#quickViewModal').modal('hide');
					ToastTopEnd.fire({
						icon: 'warning',
						title: 'Lütfen bir ürün seçimi yapınız'
					});
					$('input[name="adet"]').first()[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				}

				if (numericTelefon.length !== 11) {
					$('#step2').hide();
					$('#step1').show();
					ToastTopEnd.fire({
						icon: 'error',
						title: 'Telefon Numaranızı Eksik Yazdınız.'
					});
					$('#telefon')[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				} else if (!numericTelefon.startsWith('05')) {
					$('#step2').hide();
					$('#step1').show();
					ToastTopEnd.fire({
						icon: 'error',
						title: 'Telefon Numaranızı Doğru Formatta Girmelisiniz. Örnek: 0 500 000 00 00'
					});
					$('#telefon')[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				}

				var isim = $('input[name="name"]').val();
				if (!isim || isim.trim() === "") {
					$('#step2').hide();
					$('#step1').show();
					ToastTopEnd.fire({
						icon: 'warning',
						title: 'Lütfen Ad ve Soyadınızı Giriniz.'
					});
					$('input[name="name"]')[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				}

				var adres = $('textarea[name="adres"]').val();
				if (!adres || adres.trim() === "") {
					$('#step2').hide();
					$('#step1').show();
					ToastTopEnd.fire({
						icon: 'warning',
						title: 'Lütfen Adres Giriniz.'
					});
					$('textarea[name="adres"]')[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				}

				var il = $('select[name="il"]').val();
				if (!il || il.trim() === "") {
					$('#step2').hide();
					$('#step1').show();
					ToastTopEnd.fire({
						icon: 'warning',
						title: 'Lütfen İl Seçiniz.'
					});
					$('select[name="il"]')[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				}

				var ilce = $('select[name="ilce"]').val();
				if (!ilce || ilce.trim() === "") {
					$('#step2').hide();
					$('#step1').show();
					ToastTopEnd.fire({
						icon: 'warning',
						title: 'Lütfen İlçe Seçiniz.'
					});
					$('select[name="ilce"]')[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				}

				/*var kargo = $('select[name="kargo"]').val();
				if (!kargo || kargo.trim() === "") {
					$('#step1').hide();
					$('#step2').show();
					ToastTopEnd.fire({
						icon: 'warning',
						title: 'Lütfen Kargo Firması Seçiniz.'
					});
					$('select[name="kargo"]')[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				}*/

				var policy = $('input[name="policy"]').is(':checked');
				if (!policy) {
					$('#step2').hide();
					$('#step1').show();
					ToastTopEnd.fire({
						icon: 'warning',
						title: 'Mesafeli Satış Sözleşmesi’ni Kabul Etmeden Sipariş Veremezsiniz.',
					});
					$('input[name="policy"]')[0].scrollIntoView({
						behavior: 'smooth',
						block: 'center'
					});
					return;
				}

				var varyantEksik = false;
				$('select[name="varyant[]"]').each(function() {
					if ($(this).val() === "") {
						varyantEksik = true;
						$(this)[0].scrollIntoView({
							behavior: 'smooth',
							block: 'center'
						});
						return false;
					}
				});

				if (varyantEksik) {
					$('#quickViewModal').modal('hide');
					ToastTopEnd.fire({
						icon: 'warning',
						title: 'Lütfen Tüm Varyantları Seçiniz.'
					});
					return;
				}

				var formData = {
					name: $('input[name="name"]').val(),
					telefon: numericTelefon,
					adres: $('textarea[name="adres"]').val(),
					not: $('textarea[name="not"]').val(),
					il: $('select[name="il"]').val(),
					ilce: $('select[name="ilce"]').val(),
					ip_adres: $('input[name="ip_adres"]').val(),
					odeme : $('input[name="odeme"]:checked').val(),
					kargo: $('select[name="kargo"]').val(),
					siparis_kargo_firma : $('input[name="siparis_kargo_firma"]:checked').val(),
					adet: adet,
					policy: policy,
					varyant: $('select[name="varyant[]"]').map(function() {
						return $(this).val();
					}).get()
				};

				var promosyonlar = [];
				$('input[name="promosyon[]"]:checked').each(function() {
					promosyonlar.push($(this).val());
				});

				formData.promosyon = promosyonlar;


				$.ajax({
					url: 'tesekkurler.php',
					type: 'POST',
					data: formData,
					success: function(response) {
						console.log(response);

						if (response === 'success') {
							window.location.href = 'tesekkurler.php';
						} else if (response === 'error_order') {
							Swal.fire({
								icon: 'error',
								title: 'Sipariş Hatası',
								text: 'Son 10 dakika içerisinde bu üründen sipariş verildi. Lütfen biraz bekleyip tekrar deneyin.',
								timer: 10000,
								showConfirmButton: true,
								confirmButtonText: 'Tamam'
							});
						} else if (response === 'error') {
							Swal.fire({
								icon: 'error',
								title: 'Bir Hata Oluştu',
								text: 'Siparişiniz işlenirken bir hata oluştu. Lütfen tekrar deneyin.',
								showConfirmButton: true,
								confirmButtonText: 'Tamam'
							});
						}

						console.log(response);
						console.log(formData);					
					},
					error: function(xhr, status, error) {
						console.log("Bir hata oluştu: " + error);
						Swal.fire({
							icon: 'error',
							title: 'Bağlantı Hatası',
							text: 'Sunucuya bağlanırken bir sorun oluştu. Lütfen tekrar deneyin.',
							showConfirmButton: true,
							confirmButtonText: 'Tamam'
						});
					}
				});
			});



$('.optionsRadios').click(function() {
	var adet = $(this).data('adet');
	ekleVaryant(adet);
});

function ekleVaryant(adet) {
	$('.varyantlar').empty();
	var urun_id = <?= $urun_id; ?>;
	var varyantHTML = '';
	$.ajax({
		url: 'varyant_ajax.php',
		type: 'POST',
		data: {
			adet: adet,
			urun_id: urun_id
		},
		success: function(response) {
			$('#varyantSecim' + adet).html(response);
		}
	});
}

$('.nextStep').on('click', function() {

	$('#siparisForm').first()[0].scrollIntoView({
		behavior: 'smooth',
		block: 'start'
	});
	event.preventDefault();

	var telefon = $('#telefon').val();
	var numericTelefon = telefon.replace(/\D/g, '');

	var adet = $('input[name="adet"]:checked').val();
	if (!adet) {
		$('#quickViewModal').modal('hide');
		ToastTopEnd.fire({
			icon: 'warning',
			title: 'Lütfen bir ürün seçimi yapınız'
		});
		$('input[name="adet"]').first()[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	if (numericTelefon.length !== 11) {
		$('#step2').hide();
		$('#step1').show();
		ToastTopEnd.fire({
			icon: 'error',
			title: 'Telefon numaranızı eksik yazdınız.'
		});
		$('#telefon')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	} else if (!numericTelefon.startsWith('05')) {
		$('#step2').hide();
		$('#step1').show();
		ToastTopEnd.fire({
			icon: 'error',
			title: 'Telefon numaranızı doğru formatta girmelisiniz. Örn: 0 500 000 00 00'
		});
		$('#telefon')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var isim = $('input[name="name"]').val();

// Boşluk kontrolü
if (!isim || isim.trim() === "") {
    $('#step2').hide();
    $('#step1').show();
    ToastTopEnd.fire({
        icon: 'warning',
        title: 'Lütfen Ad ve Soyadınızı Giriniz.'
    });
    $('input[name="name"]')[0].scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });
    return;
}

// İsim ve soyisim kontrolü
var isimParcalari = isim.trim().split(" ");
if (isimParcalari.length < 2 || isimParcalari.some(word => word.length === 0)) {
    $('#step2').hide();
    $('#step1').show();
    ToastTopEnd.fire({
        icon: 'warning',
        title: 'Lütfen hem adınızı hem soyadınızı giriniz.'
    });
    $('input[name="name"]')[0].scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });
    return;
}


	var adres = $('textarea[name="adres"]').val();
	if (!adres || adres.trim() === "") {
		$('#step2').hide();
		$('#step1').show();
		ToastTopEnd.fire({
			icon: 'warning',
			title: 'Lütfen adres giriniz.'
		});
		$('textarea[name="adres"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var il = $('select[name="il"]').val();
	if (!il || il.trim() === "") {
		$('#step2').hide();
		$('#step1').show();
		ToastTopEnd.fire({
			icon: 'warning',
			title: 'Lütfen il seçiniz.'
		});
		$('select[name="il"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var ilce = $('select[name="ilce"]').val();
	if (!ilce || ilce.trim() === "") {
		$('#step2').hide();
		$('#step1').show();
		ToastTopEnd.fire({
			icon: 'warning',
			title: 'Lütfen ilçe seçiniz.'
		});
		$('select[name="ilce"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}

	var policy = $('input[name="policy"]').is(':checked');
	if (!policy) {
		$('#step2').hide();
		$('#step1').show();
		ToastTopEnd.fire({
			icon: 'warning',
			title: 'Mesafeli Satış Sözleşme kabul etmeden sipariş veremezsiniz.',
		});
		$('input[name="policy"]')[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});
		return;
	}


	$('#step1').hide();
	$('#step2').show();
});

$('.prevStep').on('click', function() {
	$('#step2').hide();
	$('#step1').show();
});


$(document).ready(function() {
	function calculateTotal() {
		var selectedRadio = $('input[name="adet"]:checked');
		var selectedRadioPrice = parseFloat(selectedRadio.data('fiyat')) || 0;
		var selectedAdet = selectedRadio.data('adet') || 1; // Seçili adet sayısı
		var selectedPromoPrice = 0;
		var selectedKargoPrice = parseFloat(selectedRadio.data('kargo')) || 0;

		$('input[name="promosyon[]"]:checked').each(function() {
			selectedPromoPrice += parseFloat($(this).data('fiyat')) || 0;
		});

		var totalPrice = selectedRadioPrice + selectedPromoPrice;

		if (selectedKargoPrice > 0) {
			totalPrice += selectedKargoPrice;
		}

		if (selectedKargoPrice === 0) {
			$('.toplamOdeme').html(selectedAdet + " Adet - " + totalPrice.toFixed(2) + ' TL <span class="kargo-bedava"> | KARGO BEDAVA</span>');
		} else {
			$('.toplamOdeme').html(selectedAdet + " Adet - " + totalPrice.toFixed(2) + ' TL <span class="kargo-dahil"> | Kargo Dahil</span>');
		}

		if (selectedKargoPrice === 0) {
			$('.toplamOdemesayafasi').html(totalPrice.toFixed(2) + ' TL <br><span class="kargo-bedava">KARGO BEDAVA</span>');
		} else {
			$('.toplamOdemesayafasi').html(totalPrice.toFixed(2) + ' TL <br><span class="kargo-dahil">Kargo Dahil</span>');
		}
	}

	calculateTotal();

	$('input[name="adet"], input[name="promosyon[]"]').on('change', function() {
		calculateTotal();
	});
});


$('.satinAlBtn').on('click', function(event) {
	var selectedAdet = $('input[name="adet"]:checked').length > 0;
	var allVaryantsSelected = true;
	$('.varyantSecim').each(function() {
		if ($(this).val() === "") {
			allVaryantsSelected = false;
		}
	});

	if (!selectedAdet) {
		event.preventDefault();
		$('#quickViewModal').modal('hide');
		ToastTopEnd.fire({
			icon: 'warning',
			title: 'Lütfen bir ürün seçimi yapınız!'
		});
		$('input[name="adet"]').first()[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});

	} else if (!allVaryantsSelected) {
		event.preventDefault();
		$('#quickViewModal').modal('hide');

		ToastTopEnd.fire({
			icon: 'warning',
			title: 'Lütfen Ürün Rengini Seçiniz.'
		});

		$('select[name="varyant[]"]').first()[0].scrollIntoView({
			behavior: 'smooth',
			block: 'center'
		});

	} else {
		$('#quickViewModal').modal('show');
	}
});


function geriSayim() {
	var now = new Date();
	var kalanZaman = new Date().setHours(23, 59, 59, 999) - now;

	if (kalanZaman > 0) {
		var saniye = Math.floor((kalanZaman / 1000) % 60).toString().padStart(2, '0');
		var dakika = Math.floor((kalanZaman / 1000 / 60) % 60).toString().padStart(2, '0');
		var saat = Math.floor(kalanZaman / (1000 * 60 * 60)).toString().padStart(2, '0');

		$('.saat').text(saat);
		$('.dakika').text(dakika);
		$('.saniye').text(saniye);
	} else {
		$('.saat, .dakika, .saniye').text('00');
	}
}

setInterval(geriSayim, 1000);
geriSayim();
$('#showContract').on('click', function(){
	var id = $(this).data('id');
	$.ajax({
		url: 'page.php',
		type: 'GET',
		data: { page: id },
		success: function(response) {
			$('#modalContent').html(response);
			$('#contentModal').modal('show');
			$('.modal').on('shown.bs.modal', function () {
				var zIndex = 9999 + ($('.modal:visible').length * 10);
				$(this).css('z-index', zIndex);
				$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
			});
		},
		error: function() {
			alert('Bir hata oluştu, lütfen tekrar deneyin.');
		}
	});
});
$(document).on('hidden.bs.modal', '.modal', function () {
	$('.modal:visible').length && $(document.body).addClass('modal-open');
	$('.modal-backdrop').not('.modal:visible').remove();
});


document.querySelectorAll('.product-info-size').forEach(function(checkbox) {
	checkbox.addEventListener('change', function() {
		if (this.checked) {
			this.nextElementSibling.classList.add('checked');
		} else {
			this.nextElementSibling.classList.remove('checked');
		}
	});
});

const buttons = document.querySelectorAll('.adetSecim');
buttons.forEach(button => {
	button.addEventListener('click', () => {
    		buttons.forEach(btn => btn.classList.remove('active'));
		button.classList.add('active');
	});
});


const paymentOptions = document.querySelectorAll('.adetSecimpro');

paymentOptions.forEach(option => {
	option.addEventListener('click', () => {
  		paymentOptions.forEach(opt => opt.classList.remove('active'));
		option.classList.add('active');
  		option.querySelector('input').checked = true;
	});
});


</script>

<script>
function getRandomTimeAgo() {
    const timeUnits = [
        { unit: "dakika", max: 60 },
        { unit: "saat", max: 24 },
        { unit: "gün", max: 30 }
    ];

    const chosenUnit = timeUnits[Math.floor(Math.random() * timeUnits.length)];
    const value = Math.floor(Math.random() * chosenUnit.max) + 1;

    switch (chosenUnit.unit) {
        case "dakika":
            return `${value} dakika önce`;
        case "saat":
            return `${value} saat önce`;
        case "gün":
            return `${value} gün önce`;
        default:
            return "Şimdi";
    }
}

document.querySelectorAll('.commentDate').forEach(function(element) {
    element.innerText = getRandomTimeAgo();
});




$(document).ready(function() {
 
    $('.adetSecim').first().addClass('active');
    $('.optionsRadios').on('change', function() {
        $('.adetSecim').removeClass('active');
        $(this).closest('.adetSecim').addClass('active');
    });
});


</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const firstSelectedRadio = document.querySelector('.optionsRadios:checked');
        if (firstSelectedRadio) {
            firstSelectedRadio.click();
        }
    });


</script>


<script>




$('#vertical-slider-slides').slick({
    arrows: true,
    dots: false, // Dots göstergelerini etkinleştir
    asNavFor: '#vertical-slider-thumb',
    slidesToShow: 1,
    autoplay: true,
    infinite: true, // Sonsuz döngüyü kapatıyoruz
    autoplaySpeed: 3000,
    prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
    nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
});



</script>




</body>
</html>
