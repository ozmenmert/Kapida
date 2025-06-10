<?php
session_start();
ob_start();
include '../ayar.php';
include '../lib/php-image-resize-master/lib/ImageResize.php';

use \Gumlet\ImageResize;

if (isset($_POST['girisYap'])) {
	$email = $_POST['email'];
	$kullanicisor = $conn->prepare("SELECT * FROM kullanicilar WHERE email = :email AND sifre = :sifre ");
	$kullanicisor->execute(
		array(
			'email' => $_POST['email'],
			'sifre' => $_POST['sifre']
		)
	);
	$say = $kullanicisor->rowCount();
	if ($say > 0) {
		$kulEmailData = $conn->query("SELECT * FROM kullanicilar  WHERE email = '$email' ")->fetch(PDO::FETCH_ASSOC);
		$kul_id = $kulEmailData['kul_id'];
		$guncelleSorgu = $conn->prepare("UPDATE kullanicilar SET son_giris_tarih = :son_giris_tarih WHERE kul_id = :kul_id");
		$guncelleSorgu->execute(
			array(
				'son_giris_tarih' => date('Y-m-d H:i:s'),
				'kul_id' => $kul_id
			)
		);
		$_SESSION['giris'] = 'true';
		$_SESSION['kul_id'] = $kul_id;
		header("Location: index.php?durum=giris");
	} else {
		header("Location: giris.php?durum=girisBasarisiz");
	}
}
if (isset($_POST['siteAyarGuncelle'])) {
	$sayfa_hizmet_id = 9;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	if ($_FILES['logo']["size"] > 0) {
		$uploads_dir = '../uploads/';
		@$tmp_name = $_FILES['logo']["tmp_name"];
		$name = $_FILES['logo']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo('logo') . '-' . time() . '.' . $ext;
		$imgyol = substr($target_file, 3);
		@move_uploaded_file($tmp_name, $target_file);
		$query = $conn->prepare("UPDATE ayarlar SET       
			ayar_logo = :ayar_logo
			");
		$update = $query->execute(
			array(
				"ayar_logo" => $imgyol
			)
		);
	}
	if ($_FILES['favicon']["size"] > 0) {
		$uploads_dir = '../uploads/';
		@$tmp_name = $_FILES['favicon']["tmp_name"];
		$name = $_FILES['favicon']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo('favicon') . '-' . time() . '.' . $ext;
		$imgyol = substr($target_file, 3);
		@move_uploaded_file($tmp_name, $target_file);
		$query = $conn->prepare("UPDATE ayarlar SET       
			ayar_icon = :ayar_icon
			");
		$update = $query->execute(
			array(
				"ayar_icon" => $imgyol
			)
		);
	}
	$query = $conn->prepare("UPDATE ayarlar SET       
		title = :title,
		description = :description,
		keywords = :keywords,
		author = :author,
		ek_script = :ek_script,
		ek_detay = :ek_detay,
		ek_purchase = :ek_purchase,
		anasayfa_url = :anasayfa_url,
		ek_css = :ek_css
		");
	$update = $query->execute(
		array(
			'title' => $_POST['title'],
			'description' => $_POST['description'],
			'keywords' => $_POST['keywords'],
			'author' => $_POST['author'],
			'ek_script' => $_POST['ek_script'],
			'ek_detay' => $_POST['ek_detay'],
			'ek_purchase' => $_POST['ek_purchase'],
			'anasayfa_url' => $_POST['anasayfa_url'],
			'ek_css' => $_POST['ek_css']
		)
	);
	if ($update) {
		header("Location: genel-ayarlar?durum=basarili");
	} else {
		header("Location: genel-ayarlar?durum=basarisiz");
	}
}
if (isset($_POST['kullaniciEkle'])) {
	$sayfa_hizmet_id = 10;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');


	$email = trim($_POST['email']);
	$kullanicisor = $conn->prepare("SELECT * FROM kullanicilar WHERE email = :email");
	$kullanicisor->execute(
		array(
			'email' => $email
		)
	);
	$say = $kullanicisor->rowCount();
	if ($say > 0) {
		header("Location: kullanici-ekle?durum=emailVar");
		die();
	}
	$query = $conn->prepare("INSERT INTO kullanicilar SET       
		email = :email,
		sifre = :sifre,
		adi = :adi,
		tel = :tel
		");
	$insert = $query->execute(
		array(
			"email" => $email,
			"sifre" => $_POST['sifre'],
			"adi" => $_POST['adi'],
			"tel" => $_POST['tel']
		)
	);
	if ($insert) {
		header("Location: kullanici-listesi?durum=basarili");
	} else {
		header("Location: kullanici-listesi?durum=basarisiz");
	}
}
if (isset($_POST['kullaniciDuzenle'])) {
	$sayfa_hizmet_id = 10;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$email = trim($_POST['email']);
	$kul_id = trim($_POST['kul_id']);
	$backUrl = trim($_POST['backUrl']);
	$kullanicisor = $conn->prepare("SELECT * FROM kullanicilar WHERE email = :email AND kul_id != :kul_id ");
	$kullanicisor->execute(
		array(
			'email' => $email,
			'kul_id' => $kul_id,
		)
	);
	$say = $kullanicisor->rowCount();
	if ($say > 0) {
		header("Location: {$backUrl}?durum=emailVar&id={$kul_id}");
		die();
	}
	$query = $conn->prepare("UPDATE kullanicilar SET        
		email = :email,
		sifre = :sifre,
		adi = :adi,
		tel = :tel
		WHERE kul_id = :kul_id
		");
	$insert = $query->execute(
		array(
			"email" => $email,
			"sifre" => $_POST['sifre'],
			"adi" => $_POST['adi'],
			"tel" => $_POST['tel'],
			"kul_id" => $_POST['kul_id']
		)
	);
	if ($insert) {
		header("Location: {$backUrl}?durum=basarili&id={$kul_id}");
	} else {
		header("Location: {$backUrl}?durum=basarisiz&id={$kul_id}");
	}
}

if (isset($_POST['yorumEkle'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$uploads_dir = '../uploads/';
	$uploaded_images = array(); // Yüklenen resimlerin tutulacağı dizi

	// Eğer resim dosyaları yüklenmişse
	if (!empty($_FILES['gorseller']['name'][0])) {
		// Yüklenen her bir dosya için işlem yap
		foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
			$name = $_FILES['gorseller']['name'][$key];
			$ext = pathinfo($name, PATHINFO_EXTENSION);
			$target_file = $uploads_dir . seo('banner-') . time() . '-' . $key . '.' . $ext;
			$yorum_img = substr($target_file, 3);

			// Dosyayı hedefe taşı
			if (@move_uploaded_file($tmp_name, $target_file)) {
				// Yüklenen dosya yolunu diziye ekle
				$uploaded_images[] = $yorum_img;
			}
		}

		// Görselleri JSON formatına dönüştür
		$yorum_img_json = json_encode($uploaded_images);
	} else {
		// Eğer resim yüklenmemişse, resim değeri boş kalacak
		$yorum_img_json = null;
	}

	// Veritabanına kaydet
	$query = $conn->prepare("INSERT INTO yorumlar SET  
    	yorum_adi = :yorum_adi,
    	yorum_puan = :yorum_puan,
    	yorum_aciklama = :yorum_aciklama,
    	yorum_urun = :yorum_urun,
    	yorum_img = :yorum_img
    	");
	$insert = $query->execute(
		array(
			"yorum_adi" => $_POST['yorum_adi'],
			"yorum_puan" => $_POST['yorum_puan'],
			"yorum_aciklama" => $_POST['yorum_aciklama'],
			"yorum_urun" => $_POST['yorum_urun'],
			"yorum_img" => $yorum_img_json // Resim varsa JSON formatında kaydedilir, yoksa null
		)
	);

	if ($insert) {
		header("Location: yorumlar?durum=basarili");
	} else {
		header("Location: yorumlar?durum=basarisiz");
	}
}



if (isset($_POST['yorumDuzenle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	if ($_FILES['yorum_img']["size"] > 0) {
		$uploads_dir = '../uploads/';
		@$tmp_name = $_FILES['yorum_img']["tmp_name"];
		$name = $_FILES['yorum_img']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo('banner') . '-' . time() . '.' . $ext;
		$imgyol = substr($target_file, 3);
		@move_uploaded_file($tmp_name, $target_file);
		$query = $conn->prepare("UPDATE yorumlar SET      
			yorum_img = :yorum_img
			WHERE yorum_id = :yorum_id
			");
		$update = $query->execute(
			array(
				"yorum_img" => $imgyol,
				"yorum_id" => $_POST['yorum_id']
			)
		);
	}
	$query = $conn->prepare("UPDATE yorumlar SET      
		yorum_urun = :yorum_urun
		WHERE yorum_id = :yorum_id
		");
	$update = $query->execute(
		array(
			"yorum_urun" => $_POST['yorum_urun'],
			"yorum_id" => $_POST['yorum_id']
		)
	);
	if ($update) {
		header("Location: yorumlar?durum=basarili");
	} else {
		header("Location: yorumlar?durum=basarisiz");
	}
}

if (isset($_POST['yorumSayisiDuzenle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$query = $conn->prepare("UPDATE urunler SET      
		yorum_sayisi = :yorum_sayisi
		WHERE urun_id = :urun_id
		");
	$update = $query->execute(
		array(
			"yorum_sayisi" => abs($_POST['yorum_sayisi']),
			"urun_id" => $_POST['urun_id']
		)
	);
	if ($update) {
		header("Location: urun-duzenle?id=" . $_POST['urun_id'] . "&durum=basarili");
	} else {
		header("Location: urun-duzenle?id=" . $_POST['urun_id'] . "&durum=basarisiz");
	}
}

if (isset($_POST['yorumSayisiSil'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$query = $conn->prepare("UPDATE urunler SET      
		yorum_sayisi = :yorum_sayisi
		WHERE urun_id = :urun_id
		");
	$update = $query->execute(
		array(
			"yorum_sayisi" => NULL,
			"urun_id" => $_POST['urun_id']
		)
	);
	if ($update) {
		header("Location: urun-duzenle?id=" . $_POST['urun_id'] . "&durum=basarili");
	} else {
		header("Location: urun-duzenle?id=" . $_POST['urun_id'] . "&durum=basarisiz");
	}
}

if (isset($_POST['icerikEkle'])) {

	$sayfa_hizmet_id = 6;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');


	$query = $conn->prepare("INSERT INTO icerik SET     
		baslik = :baslik,
		icerik = :icerik
		");
	$insert = $query->execute(
		array(
			"baslik" => $_POST['baslik'],
			"icerik" => $_POST['icerik']
		)
	);
	if ($insert) {
		header("Location: icerik-listesi?durum=basarili");
	} else {
		header("Location: icerik-listesi?durum=basarisiz");
	}
}
if (isset($_POST['icerikDuzenle'])) {

	$sayfa_hizmet_id = 6;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');


	$query = $conn->prepare("UPDATE icerik SET      
		baslik = :baslik,
		icerik = :icerik
		WHERE id = :id
		");
	$insert = $query->execute(
		array(
			"baslik" => $_POST['baslik'],
			"icerik" => $_POST['icerik'],
			"id" => $_POST['id']
		)
	);
	if ($insert) {
		header("Location: icerik-listesi?durum=basarili");
	} else {
		header("Location: icerik-listesi?durum=basarisiz");
	}
}
if (isset($_POST['urunEkle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');


	$urun_img = null;
	if ($_FILES['urun_img']["size"] > 0) {
		$uploads_dir = '../uploads/';
		@$tmp_name = $_FILES['urun_img']["tmp_name"];
		$name = $_FILES['urun_img']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo($_POST['urun_adi']) . '-' . time() . '.' . $ext;
		$urun_img = substr($target_file, 3);
		@move_uploaded_file($tmp_name, $target_file);
	}
	$query = $conn->prepare("INSERT INTO urunler SET      
		urun_img = :urun_img,
		urun_subdomain = :urun_subdomain,
		urun_whatsapp = :urun_whatsapp,
		urun_script = :urun_script,
		urun_tesekkur_script = :urun_tesekkur_script,
		urun_css = :urun_css,
		urun_stok = :urun_stok,
		urun_aciklama = :urun_aciklama,
		urun_video = :urun_video,
		promosyon_video = :promosyon_video,
		urun_stok_kodu = :urun_stok_kodu,
		urun_adi = :urun_adi,
		urun_kisa_adi = :urun_kisa_adi,
		urun_fiyat = :urun_fiyat,
		urun_maliyet = :urun_maliyet,
		urun_iade_orani = :urun_iade_orani,
		urun_seo_title = :urun_seo_title,
		urun_seo_desc = :urun_seo_desc,
		urun_seo_keyw = :urun_seo_keyw
		");
	$insert = $query->execute(
		array(
			'urun_img' => $urun_img,
			'urun_subdomain' => $_POST['urun_subdomain'],
			'urun_whatsapp' => $_POST['urun_whatsapp'],
			'urun_script' => $_POST['urun_script'],
			'urun_tesekkur_script' => $_POST['urun_tesekkur_script'],
			'urun_css' => $_POST['urun_css'],
			'urun_stok' => $_POST['urun_stok'],
			'urun_aciklama' => $_POST['urun_aciklama'],
			'urun_video' => $_POST['urun_video'],
			'promosyon_video' => $_POST['promosyon_video'],
			'urun_stok_kodu' => $_POST['urun_stok_kodu'],
			'urun_adi' => trim($_POST['urun_adi']),
			'urun_kisa_adi' => trim($_POST['urun_kisa_adi']),
			'urun_fiyat' => $_POST['urun_fiyat'],
			'urun_maliyet' => $_POST['urun_maliyet'],
			'urun_iade_orani' => $_POST['urun_iade_orani'],
			'urun_seo_title' => SEOLink($_POST['urun_seo_desc']),
			'urun_seo_desc' => $_POST['urun_seo_desc'],
			'urun_seo_keyw' => $_POST['urun_seo_keyw']
		)
	);
	$fiyat_urun = $conn->lastInsertId();
	if (isset($_POST['adet']) and $_POST['adet'] != '') {
		foreach ($_POST['adet'] as $key => $fiyat_adet) {
			$query = $conn->prepare("INSERT INTO urun_fiyatlandirma SET      
				urun_id = :urun_id,     
				adet = :adet,
				onceki = :onceki,
				fiyat = :fiyat,
				kargo_tutar = :kargo_tutar,
				kargo_durum = :kargo_durum
				");
			$insert = $query->execute(
				array(
					'urun_id' => $fiyat_urun,
					'adet' => $fiyat_adet,
					'onceki' => $_POST['onceki'][$key],
					'fiyat' => $_POST['fiyat'][$key],
					'kargo_tutar' => $_POST['kargo_tutar'][$key],
					'kargo_durum' => $_POST['kargo_durum'][$key]
				)
			);
		}
	}
	if ($insert) {
		header("Location: urun-duzenle?durum=basarili&id=" . $fiyat_urun);
	} else {
		header("Location: urun-duzenle?durum=basarisiz&id=" . $fiyat_urun);
	}
}
if (isset($_POST['urunDuzenle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');


	if ($_FILES['urun_img']["size"] > 0) {
		$uploads_dir = '../uploads/';
		@$tmp_name = $_FILES['urun_img']["tmp_name"];
		$name = $_FILES['urun_img']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo($_POST['urun_adi']) . '-' . time() . '.' . $ext;
		$urun_img = substr($target_file, 3);
		@move_uploaded_file($tmp_name, $target_file);
		$query = $conn->prepare("UPDATE urunler SET      
			urun_img = :urun_img
			WHERE urun_id = :urun_id
			");
		$update = $query->execute(
			array(
				'urun_img' => $urun_img,
				'urun_id' => $_POST['urun_id']
			)
		);
	}
	$query = $conn->prepare("UPDATE urunler SET
		urun_subdomain = :urun_subdomain,
		urun_whatsapp = :urun_whatsapp,
		urun_script = :urun_script,
		urun_tesekkur_script = :urun_tesekkur_script,
		urun_css = :urun_css,
		urun_aciklama = :urun_aciklama,
		urun_video = :urun_video,
		promosyon_video = :promosyon_video,
		urun_stok = :urun_stok,
		urun_stok_kodu = :urun_stok_kodu,
		urun_adi = :urun_adi,
		urun_fiyat = :urun_fiyat,
		urun_maliyet = :urun_maliyet,
		urun_iade_orani = :urun_iade_orani,
		urun_seo_title = :urun_seo_title,
		urun_seo_desc = :urun_seo_desc,
		urun_seo_keyw = :urun_seo_keyw
		WHERE urun_id = :urun_id
		");
	$insert = $query->execute(
		array(
			'urun_subdomain' => $_POST['urun_subdomain'],
			'urun_whatsapp' => $_POST['urun_whatsapp'],
			'urun_script' => $_POST['urun_script'],
			'urun_tesekkur_script' => $_POST['urun_tesekkur_script'],
			'urun_css' => $_POST['urun_css'],
			'urun_aciklama' => $_POST['urun_aciklama'],
			'urun_video' => $_POST['urun_video'],
			'promosyon_video' => $_POST['promosyon_video'],
			'urun_stok' => $_POST['urun_stok'],
			'urun_stok_kodu' => $_POST['urun_stok_kodu'],
			'urun_adi' => $_POST['urun_adi'],
			'urun_fiyat' => $_POST['urun_fiyat'],
			'urun_maliyet' => $_POST['urun_maliyet'],
			'urun_iade_orani' => $_POST['urun_iade_orani'],
			'urun_seo_title' => SEOLink($_POST['urun_seo_desc']),
			'urun_seo_desc' => $_POST['urun_seo_desc'],
			'urun_seo_keyw' => $_POST['urun_seo_keyw'],
			'urun_id' => $_POST['urun_id']
		)
	);
	$urun_id = $_POST['urun_id'];
	if (isset($_POST['adet']) and $_POST['adet'] != '') {
		$sonuc = $conn->exec("DELETE FROM urun_fiyatlandirma WHERE urun_id = $urun_id ");
		foreach ($_POST['adet'] as $key => $fiyat_adet) {
			$query = $conn->prepare("INSERT INTO urun_fiyatlandirma SET      
				urun_id = :urun_id,     
				adet = :adet,
				onceki = :onceki,
				fiyat = :fiyat,
				kargo_tutar = :kargo_tutar,
				kargo_durum = :kargo_durum
				");
			$insert = $query->execute(
				array(
					'urun_id' => $urun_id,
					'adet' => $fiyat_adet,
					'onceki' => $_POST['onceki'][$key],
					'fiyat' => $_POST['fiyat'][$key],
					'kargo_tutar' => $_POST['kargo_tutar'][$key],
					'kargo_durum' => $_POST['kargo_durum'][$key]
				)
			);
		}
	}
	if (empty($_POST['varyasyon_adi'])) {
		$sonuc = $conn->exec("DELETE FROM urun_varyantlar WHERE urun_id = $urun_id ");
	}
	if (isset($_POST['varyasyon_adi']) and $_POST['varyasyon_adi'] != '') {
		$sonuc = $conn->exec("DELETE FROM urun_varyantlar WHERE urun_id = $urun_id ");
		foreach ($_POST['varyasyon_adi'] as $key => $varyant_adi) {
			$query = $conn->prepare("INSERT INTO urun_varyantlar SET      
				urun_id = :urun_id,     
				varyant_adi = :varyant_adi,
				degerler = :degerler
				");
			$insert = $query->execute(
				array(
					'urun_id' => $urun_id,
					'varyant_adi' => $varyant_adi,
					'degerler' => $_POST['varyasyon_degerleri'][$key]
				)
			);
		}
	}

	if (isset($_POST['promosyon_adi']) and $_POST['promosyon_adi'] != '') {
		$sonuc = $conn->exec("DELETE FROM promosyon_urunler WHERE urun_id = $urun_id ");
		foreach ($_POST['promosyon_adi'] as $key => $promosyon_adi) {
			$query = $conn->prepare("INSERT INTO promosyon_urunler SET      
				urun_id = :urun_id,     
				promosyon_adi = :promosyon_adi,
				promosyon_onceki = :promosyon_onceki,
				promosyon_ucret = :promosyon_ucret
				");
			$insert = $query->execute(
				array(
					'urun_id' => $urun_id,
					'promosyon_adi' => $promosyon_adi,
					'promosyon_onceki' => $_POST['promosyon_onceki'][$key],
					'promosyon_ucret' => $_POST['promosyon_ucret'][$key]
				)
			);
		}
	}
	if ($insert) {
		header("Location: urun-duzenle?durum=basarili&id=" . $urun_id);
	} else {
		header("Location: urun-duzenle?durum=basarisiz&id=" . $urun_id);
	}
}
if (isset($_POST['urunGorselEkle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');


	$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');
	$uploads_dir = '../uploads/';
	foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
		$name = $_FILES['gorseller']['name'][$key];
		$size = $_FILES['gorseller']['size'][$key];
		$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		if ($size > 0 && in_array($ext, $allowedExtensions)) {
			$target_file = $uploads_dir . 'urungorsel' . time() . '_' . mt_rand(0, 999) . '_' . $key . '.' . $ext;
			move_uploaded_file($tmp_name, $target_file);
			$imgyol = substr($target_file, 3);
			$query = $conn->prepare("INSERT INTO urun_gorselleri SET     
				urun_id = :urun_id,
				img = :img
				");
			$insert = $query->execute(
				array(
					"urun_id" => $_POST['urun_id'],
					"img" => $imgyol
				)
			);
		}
	}
	if ($insert) {
		header("Location: urun-duzenle?durum=basarili&tap=gorseller&id=" . $_POST['urun_id']);
	} else {
		header("Location: urun-duzenle?durum=basarisiz&tap=gorseller&id=" . $_POST['urun_id']);
	}
}


if (isset($_POST['yorumGorselEkle'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$uploads_dir = '../uploads/';
	$uploaded_images = array();

	foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
		$name = $_FILES['gorseller']['name'][$key];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo('banner-') . time() . '-' . $key . '.' . $ext;
		$yorum_img = substr($target_file, 3);

		if (@move_uploaded_file($tmp_name, $target_file)) {
			$uploaded_images[] = $yorum_img;
		}
	}

	$yorum_img_json = json_encode($uploaded_images);

	$query = $conn->prepare("INSERT INTO yorumlar SET  
		yorum_adi = :yorum_adi,
		yorum_puan = :yorum_puan,
		yorum_aciklama = :yorum_aciklama,
		yorum_urun = :yorum_urun,
		yorum_img = :yorum_img
		");
	$insert = $query->execute(
		array(
			"yorum_adi" => $_POST['yorum_adi'],
			"yorum_puan" => $_POST['yorum_puan'],
			"yorum_aciklama" => $_POST['yorum_aciklama'],
			"yorum_urun" => $_POST['urun_id'],
			"yorum_img" => $yorum_img_json
		)
	);

	if ($insert) {
		header("Location: urun-duzenle?durum=basarili&tap=yorumlar&id=" . $_POST['urun_id']);
	} else {
		header("Location: urun-duzenle?durum=basarisiz&tap=yorumlar&id=" . $_POST['urun_id']);
	}
}
if (isset($_POST['yorumGorselDuzenle'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$uploads_dir = '../uploads/';
	$uploaded_images = array();
	$yorum_id = $_POST['yorum_id'];

	$stmt = $conn->prepare("SELECT yorum_img FROM yorumlar WHERE yorum_id = :yorum_id");
	$stmt->execute(array("yorum_id" => $yorum_id));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$existing_images = json_decode($row['yorum_img'], true) ?: array();

	if (!empty($_FILES['gorseller']['name'][0])) {
		foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
			$name = $_FILES['gorseller']['name'][$key];
			$ext = pathinfo($name, PATHINFO_EXTENSION);
			$target_file = $uploads_dir . seo('banner-') . time() . '-' . $key . '.' . $ext;
			$yorum_img = substr($target_file, 3);

			if (@move_uploaded_file($tmp_name, $target_file)) {
				$uploaded_images[] = $yorum_img;
			}
		}
		$all_images = array_merge($existing_images, $uploaded_images);
	} else {
		$all_images = $existing_images;
	}

	$yorum_img_json = json_encode($all_images);

	$query = $conn->prepare("UPDATE yorumlar SET  
		yorum_adi = :yorum_adi,
		yorum_puan = :yorum_puan,
		yorum_aciklama = :yorum_aciklama,
		yorum_urun = :yorum_urun,
		yorum_img = :yorum_img
		WHERE yorum_id = :yorum_id
		");
	$update = $query->execute(
		array(
			"yorum_adi" => $_POST['yorum_adi'],
			"yorum_puan" => $_POST['yorum_puan'],
			"yorum_aciklama" => $_POST['yorum_aciklama'],
			"yorum_urun" => $_POST['urun_id'],
			"yorum_img" => $yorum_img_json,
			"yorum_id" => $yorum_id
		)
	);

	if ($update) {
		header("Location: urun-duzenle?durum=basarili&tap=yorumlar&id=" . $_POST['urun_id']);
	} else {
		header("Location: urun-duzenle?durum=basarisiz&tap=yorumlar&id=" . $_POST['urun_id']);
	}
}

if (isset($_POST['ayorumGorselDuzenle'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$uploads_dir = '../uploads/yorumlar/';
	$uploaded_images = array();
	$yorum_id = $_POST['yorum_id'];

	$stmt = $conn->prepare("SELECT yorum_img FROM a_yorumlar WHERE yorum_id = :yorum_id");
	$stmt->execute(array("yorum_id" => $yorum_id));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$existing_images = json_decode($row['yorum_img'], true) ?: array();

	if (!empty($_FILES['gorseller']['name'][0])) {
		foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
			$name = $_FILES['gorseller']['name'][$key];
			$ext = pathinfo($name, PATHINFO_EXTENSION);
			$target_file = $uploads_dir . seo('banner-') . time() . '-' . $key . '.' . $ext;
			$yorum_img = substr($target_file, 3);

			if (@move_uploaded_file($tmp_name, $target_file)) {
				$uploaded_images[] = $yorum_img;
			}
		}
		$all_images = array_merge($existing_images, $uploaded_images);
	} else {
		$all_images = $existing_images;
	}

	$yorum_img_json = json_encode($all_images);

	//var_dump($_POST);

	$query = $conn->prepare("UPDATE a_yorumlar SET  
		yorum_adi = :yorum_adi,
		yorum_puan = :yorum_puan,
		yorum_aciklama = :yorum_aciklama,
		urun_id = :urun_id,
		yorum_img = :yorum_img
		WHERE yorum_id = :yorum_id
		");
	$update = $query->execute(
		array(
			"yorum_adi" => $_POST['yorum_adi'],
			"yorum_puan" => $_POST['yorum_puan'],
			"yorum_aciklama" => $_POST['yorum_aciklama'],
			"urun_id" => $_POST['urun_id'],
			"yorum_img" => $yorum_img_json,
			"yorum_id" => $yorum_id
		)
	);

	if ($update) {
		header("Location: urun-yorumlari?durum=basarili&tap=yorumlar&id=" . $_POST['urun_id']);
	} else {
		header("Location: urun-yorumlari?durum=basarisiz&tap=yorumlar&id=" . $_POST['urun_id']);
	}
}


if (isset($_POST['kargoEkle'])) {

	$sayfa_hizmet_id = 7;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');


	$query = $conn->prepare("INSERT INTO kargo_firmalar SET     
		kargo_adi = :kargo_adi,
		kargo_teslim = :kargo_teslim,    
		kargo_komisyon = :kargo_komisyon,    
		kargo_iade = :kargo_iade
		");
	$insert = $query->execute(
		array(
			"kargo_adi" => $_POST['kargo_adi'],
			"kargo_teslim" => $_POST['kargo_teslim'],
			"kargo_komisyon" => $_POST['kargo_komisyon'],
			"kargo_iade" => $_POST['kargo_iade']
		)
	);
	$fiyat_kargo = $conn->lastInsertId();
	if (isset($_POST['tutar']) and $_POST['tutar'] != '') {
		foreach ($_POST['tutar'] as $key => $tutar) {
			$query = $conn->prepare("INSERT INTO kargo_araliklar SET      
				aralik_kargo_id = :aralik_kargo_id,     
				aralik_ucret = :aralik_ucret,
				aralik_baslangic = :aralik_baslangic,
				aralik_bitis = :aralik_bitis
				");
			$insert = $query->execute(
				array(
					'aralik_kargo_id' => $fiyat_kargo,
					'aralik_ucret' => $tutar,
					'aralik_baslangic' => $_POST['baslangic'][$key],
					'aralik_bitis' => $_POST['bitis'][$key]
				)
			);
		}
	}
	if ($insert) {
		header("Location: kargo-duzenle?id=$fiyat_kargo&durum=basarili");
	} else {
		header("Location: kargolar?durum=basarisiz");
	}
}
if (isset($_POST['kargoDuzenle'])) {

	$sayfa_hizmet_id = 7;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');


	$kargo_id = $_POST['kargo_id'];
	$query = $conn->prepare("UPDATE kargo_firmalar SET      
		kargo_adi = :kargo_adi,    
		kargo_teslim = :kargo_teslim,    
		kargo_komisyon = :kargo_komisyon,    
		kargo_iade = :kargo_iade
		WHERE kargo_id = :kargo_id
		");
	$insert = $query->execute(
		array(
			"kargo_adi" => $_POST['kargo_adi'],
			"kargo_teslim" => $_POST['kargo_teslim'],
			"kargo_komisyon" => $_POST['kargo_komisyon'],
			"kargo_iade" => $_POST['kargo_iade'],
			"kargo_id" => $kargo_id
		)
	);

	if (isset($_POST['tutar']) and $_POST['tutar'] != '') {
		$sonuc = $conn->exec("DELETE FROM kargo_araliklar WHERE aralik_kargo_id = $kargo_id ");
		foreach ($_POST['tutar'] as $key => $tutar) {
			$query = $conn->prepare("INSERT INTO kargo_araliklar SET      
				aralik_kargo_id = :aralik_kargo_id,     
				aralik_ucret = :aralik_ucret,
				aralik_baslangic = :aralik_baslangic,
				aralik_bitis = :aralik_bitis
				");
			$insert = $query->execute(
				array(
					'aralik_kargo_id' => $kargo_id,
					'aralik_ucret' => $tutar,
					'aralik_baslangic' => $_POST['baslangic'][$key],
					'aralik_bitis' => $_POST['bitis'][$key]
				)
			);
		}
	}
	if ($insert) {
		header("Location: kargo-duzenle?id=$kargo_id&durum=basarili");
	} else {
		header("Location: kargo-duzenle?id=$kargo_id&durum=basarisiz");
	}
}
if (isset($_POST['durumEkle'])) {

	$sayfa_hizmet_id = 8;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');


	$query = $conn->prepare("INSERT INTO siparis_durumlari SET     
		siparis_durum_adi = :siparis_durum_adi
		");
	$insert = $query->execute(
		array(
			"siparis_durum_adi" => $_POST['siparis_durum_adi']
		)
	);
	if ($insert) {
		header("Location: durum-listesi?durum=basarili");
	} else {
		header("Location: durum-listesi?durum=basarisiz");
	}
}
if (isset($_POST['durumDuzenle'])) {

	$sayfa_hizmet_id = 8;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$query = $conn->prepare("UPDATE siparis_durumlari SET      
		siparis_durum_adi = :siparis_durum_adi
		WHERE siparis_durum_id = :siparis_durum_id
		");
	$insert = $query->execute(
		array(
			"siparis_durum_adi" => $_POST['siparis_durum_adi'],
			"siparis_durum_id" => $_POST['siparis_durum_id']
		)
	);
	if ($insert) {
		header("Location: durum-listesi?durum=basarili");
	} else {
		header("Location: durum-listesi?durum=basarisiz");
	}
}

/////////////////////////////////////////////////////////////////////
if (isset($_POST['stokEkle'])) {

	$sayfa_hizmet_id = 4;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');

	$stok_img = null;
	if ($_FILES['stok_img']["size"] > 0) {
		$uploads_dir = 'belgeler/';
		@$tmp_name = $_FILES['stok_img']["tmp_name"];
		$name = $_FILES['stok_img']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo($_POST['stok_adi']) . '-' . time() . '.' . $ext;
		$stok_img = substr($target_file, 0);
		@move_uploaded_file($tmp_name, $target_file);
	}
	$query = $conn->prepare("INSERT INTO stok_urunler SET      
		stok_img = :stok_img,
		stok_adi = :stok_adi,
		stok_adet = :stok_adet
		");
	$insert = $query->execute(
		array(
			'stok_img' => $stok_img,
			'stok_adi' => $_POST['stok_adi'],
			'stok_adet' => 0
		)
	);
	$stok_id = $conn->lastInsertId();

	if ($insert) {
		header("Location: stok-duzenle?durum=basarili&id=" . $stok_id);
	} else {
		header("Location: stok-ekle?durum=basarisiz");
	}
}

/////////////////////////////////////////////////////////////////////
if (isset($_POST['stokDuzenle'])) {

	$sayfa_hizmet_id = 4;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$stok_id = $_POST['stok_id'];
	if ($_FILES['stok_img']["size"] > 0) {
		$uploads_dir = 'belgeler/';
		@$tmp_name = $_FILES['stok_img']["tmp_name"];
		$name = $_FILES['stok_img']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo($_POST['stok_adi']) . '-' . time() . '.' . $ext;
		$stok_img = substr($target_file, 0);
		@move_uploaded_file($tmp_name, $target_file);
		$query = $conn->prepare("UPDATE stok_urunler SET      
			stok_img = :stok_img
			WHERE stok_id = :stok_id
			");
		$update = $query->execute(
			array(
				'stok_img' => $stok_img,
				'stok_id' => $stok_id
			)
		);
	}

	$query = $conn->prepare("UPDATE stok_urunler SET      
		stok_adi = :stok_adi
		WHERE stok_id = :stok_id
		");
	$update = $query->execute(
		array(
			'stok_adi' => $_POST['stok_adi'],
			'stok_id' => $stok_id
		)
	);
	if ($update) {
		header("Location: stok-duzenle?durum=basarili&id=" . $stok_id);
	} else {
		header("Location: stok-ekle?durum=basarisiz");
	}
}

/////////////////////////////////////////////////////////////////////
if (isset($_POST['hareketEkle'])) {

	$sayfa_hizmet_id = 4;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');

	$hareket_belge = null;
	$stok_id = $_POST['hareket_stok_id'];
	if ($_FILES['hareket_belge']["size"] > 0) {
		$uploads_dir = 'belgeler/';
		@$tmp_name = $_FILES['hareket_belge']["tmp_name"];
		$name = $_FILES['hareket_belge']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo('hareket') . '-' . time() . '.' . $ext;
		$hareket_belge = substr($target_file, 0);
		@move_uploaded_file($tmp_name, $target_file);
	}
	$query = $conn->prepare("INSERT INTO stok_hareketler SET      
		hareket_belge = :hareket_belge,
		hareket_stok_id = :hareket_stok_id,
		hareket_tur = :hareket_tur,
		hareket_alist_tutar = :hareket_alist_tutar,
		hareket_aciklama = :hareket_aciklama,
		hareket_adet = :hareket_adet
		");
	$insert = $query->execute(
		array(
			'hareket_belge' => $hareket_belge,
			'hareket_stok_id' => $stok_id,
			'hareket_tur' => $_POST['hareket_tur'],
			'hareket_alist_tutar' => $_POST['hareket_alist_tutar'],
			'hareket_aciklama' => $_POST['hareket_aciklama'],
			'hareket_adet' => $_POST['hareket_adet']
		)
	);
	if ($insert) {
		$hareket_id = $conn->lastInsertId();

		$yeni_isaret = ($_POST['hareket_tur'] == 1) ? '+' : '-';

		// Yeni hareketi işleme
		if ($yeni_isaret == '+') {
			$stokGuncelle = $conn->prepare("UPDATE stok_urunler SET stok_adet = stok_adet + :yeni_adet WHERE stok_id = :id");
		} else {
			$stokGuncelle = $conn->prepare("UPDATE stok_urunler SET stok_adet = stok_adet - :yeni_adet WHERE stok_id = :id");
		}

		$guncelle = $stokGuncelle->execute(array(
			'yeni_adet' => $_POST['hareket_adet'],
			'id' => $stok_id
		));

		if ($guncelle) {
			header("Location: stok-duzenle?durum=basarili&id=" . $stok_id);
		} else {
			$sonuc = $conn->exec("DELETE FROM stok_hareketler WHERE hareket_id = $hareket_id");
			header("Location: hareket-ekle?durum=basarisiz");
		}
	} else {
		header("Location: stok-ekle?durum=basarisiz");
	}
}

/////////////////////////////////////////////////////////////////////
if (isset($_POST['hareketDuzenle'])) {

	$sayfa_hizmet_id = 4;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$hareket_id = $_POST['hareket_id'];

	// Önceki hareket bilgilerini al
	$data = $conn->query("SELECT * FROM stok_hareketler WHERE hareket_id = $hareket_id")->fetch(PDO::FETCH_ASSOC);
	$onceki_adet = $data['hareket_adet'];
	$onceki_isaret = ($data['hareket_tur'] == 1) ? '+' : '-';
	$stok_id = $data['hareket_stok_id']; // stok_id'yi alıyoruz

	// Belge yükleme işlemi
	if ($_FILES['hareket_belge']["size"] > 0) {
		$uploads_dir = 'belgeler/';
		@$tmp_name = $_FILES['hareket_belge']["tmp_name"];
		$name = $_FILES['hareket_belge']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo('hareket') . '-' . time() . '.' . $ext;
		$hareket_belge = substr($target_file, 0);
		@move_uploaded_file($tmp_name, $target_file);
		$query = $conn->prepare("UPDATE stok_hareketler SET      
    		hareket_belge = :hareket_belge
    		WHERE hareket_id = :hareket_id
    		");
		$query->execute(
			array(
				'hareket_belge' => $hareket_belge,
				'hareket_id' => $hareket_id
			)
		);
	}

	// Eski hareketi geri al
	if ($onceki_isaret == '+') {
		$stokGuncelle = $conn->prepare("UPDATE stok_urunler SET stok_adet = stok_adet - :onceki_adet WHERE stok_id = :id");
	} else {
		$stokGuncelle = $conn->prepare("UPDATE stok_urunler SET stok_adet = stok_adet + :onceki_adet WHERE stok_id = :id");
	}
	$stokGuncelle->execute(array(
		'onceki_adet' => $onceki_adet,
		'id' => $stok_id
	));

	// Yeni hareket türü ve adeti güncelle
	$query = $conn->prepare("UPDATE stok_hareketler SET
    	hareket_tur = :hareket_tur,
    	hareket_adet = :hareket_adet,
    	hareket_alist_tutar = :hareket_alist_tutar,
    	hareket_aciklama = :hareket_aciklama
    	WHERE hareket_id = :hareket_id
    	");
	$update = $query->execute(
		array(
			'hareket_tur' => $_POST['hareket_tur'],
			'hareket_adet' => $_POST['hareket_adet'],
			'hareket_alist_tutar' => $_POST['hareket_alist_tutar'],
			'hareket_aciklama' => $_POST['hareket_aciklama'],
			'hareket_id' => $hareket_id
		)
	);

	if ($update) {
		$yeni_adet = $_POST['hareket_adet'];
		$yeni_isaret = ($_POST['hareket_tur'] == 1) ? '+' : '-';

		// Yeni hareketi işleme
		if ($yeni_isaret == '+') {
			$stokGuncelle = $conn->prepare("UPDATE stok_urunler SET stok_adet = stok_adet + :yeni_adet WHERE stok_id = :id");
		} else {
			$stokGuncelle = $conn->prepare("UPDATE stok_urunler SET stok_adet = stok_adet - :yeni_adet WHERE stok_id = :id");
		}
		$guncelle = $stokGuncelle->execute(array(
			'yeni_adet' => $yeni_adet,
			'id' => $stok_id
		));

		if ($guncelle) {
			header("Location: stok-duzenle?durum=basarili&id=" . $stok_id);
		} else {
			$conn->exec("DELETE FROM stok_hareketler WHERE hareket_id = $hareket_id");
			header("Location: hareket-ekle?durum=basarisiz");
		}

		header("Location: hareket-duzenle?durum=basarili&id=" . $hareket_id);
	} else {
		header("Location: hareket-duzenle?durum=basarisiz&id=" . $hareket_id);
	}
}


/////////////////////////////////////////////////////////////////////
if (isset($_POST['reklamMaliyetEkle'])) {

	$sayfa_hizmet_id = 5;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');

	$query = $conn->prepare("INSERT INTO reklam_maliyetler SET      
		rekalm_maliyet_urun = :rekalm_maliyet_urun,  
		rekalm_maliyet_domain = :rekalm_maliyet_domain,  
		rekalm_maliyet_meta = :rekalm_maliyet_meta,  
		rekalm_maliyet_tiktok = :rekalm_maliyet_tiktok,  
		rekalm_maliyet_google = :rekalm_maliyet_google,  
		rekalm_maliyet_twitter = :rekalm_maliyet_twitter,  
		rekalm_maliyet_man = :rekalm_maliyet_man,  
		rekalm_maliyet_man_2 = :rekalm_maliyet_man_2,  
		rekalm_maliyet_not = :rekalm_maliyet_not
		");
	$insert = $query->execute(
		array(
			'rekalm_maliyet_urun' => $_POST['urun_id'],
			'rekalm_maliyet_domain' => $_POST['domain'],
			'rekalm_maliyet_meta' => $_POST['meta'],
			'rekalm_maliyet_tiktok' => $_POST['tiktok'],
			'rekalm_maliyet_google' => $_POST['google'],
			'rekalm_maliyet_twitter' => $_POST['twitter'],
			'rekalm_maliyet_man' => $_POST['manuel_1'],
			'rekalm_maliyet_man_2' => $_POST['manuel_2'],
			'rekalm_maliyet_not' => $_POST['not']
		)
	);
	$maliyet_id = $conn->lastInsertId();

	if ($insert) {
		header("Location: reklam-maliyet-duzenle?durum=basarili&id=" . $maliyet_id);
	} else {
		header("Location: reklam-maliyet-ekle?durum=basarisiz");
	}
}


/////////////////////////////////////////////////////////////////////
if (isset($_POST['reklamMaliyetDuzenle'])) {

	$sayfa_hizmet_id = 5;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$maliyet_id = $_POST['maliyet_id'];
	$query = $conn->prepare("UPDATE reklam_maliyetler SET      
		rekalm_maliyet_urun = :rekalm_maliyet_urun,  
		rekalm_maliyet_domain = :rekalm_maliyet_domain,  
		rekalm_maliyet_meta = :rekalm_maliyet_meta,  
		rekalm_maliyet_tiktok = :rekalm_maliyet_tiktok,  
		rekalm_maliyet_google = :rekalm_maliyet_google,  
		rekalm_maliyet_twitter = :rekalm_maliyet_twitter,  
		rekalm_maliyet_man = :rekalm_maliyet_man,  
		rekalm_maliyet_man_2 = :rekalm_maliyet_man_2,   
		rekalm_maliyet_not = :rekalm_maliyet_not
		WHERE rekalm_maliyet_id =:rekalm_maliyet_id
		");
	$update = $query->execute(
		array(
			'rekalm_maliyet_urun' => $_POST['urun_id'],
			'rekalm_maliyet_domain' => $_POST['domain'],
			'rekalm_maliyet_meta' => $_POST['meta'],
			'rekalm_maliyet_tiktok' => $_POST['tiktok'],
			'rekalm_maliyet_google' => $_POST['google'],
			'rekalm_maliyet_twitter' => $_POST['twitter'],
			'rekalm_maliyet_man' => $_POST['manuel_1'],
			'rekalm_maliyet_man_2' => $_POST['manuel_2'],
			'rekalm_maliyet_not' => $_POST['not'],
			'rekalm_maliyet_id' => $_POST['maliyet_id']
		)
	);

	if ($update) {
		header("Location: reklam-maliyet-listesi?durum=basarili");
	} else {
		header("Location: reklam-maliyet-duzenle?durum=basarisiz&id=" . $maliyet_id);
	}
}


if (isset($_POST['topluHareketEkle'])) {
	$hareket_belge = null;

	if ($_FILES['hareket_belge']["size"] > 0) {
		$uploads_dir = 'belgeler/';
		@$tmp_name = $_FILES['hareket_belge']["tmp_name"];
		$name = $_FILES['hareket_belge']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo('hareket') . '-' . time() . '.' . $ext;
		$hareket_belge = substr($target_file, 0);
		@move_uploaded_file($tmp_name, $target_file);
	}

	if (isset($_POST['urun']) and $_POST['urun'] != '') {
		foreach ($_POST['urun'] as $key => $urun) {
			$query = $conn->prepare("INSERT INTO stok_hareketler SET      
				hareket_belge = :hareket_belge,
				hareket_stok_id = :hareket_stok_id,
				hareket_tur = :hareket_tur,
				hareket_alist_tutar = :hareket_alist_tutar,
				hareket_aciklama = :hareket_aciklama,
				hareket_adet = :hareket_adet
				");
			$insert = $query->execute(
				array(
					'hareket_belge' => $hareket_belge,
					'hareket_stok_id' => $urun,
					'hareket_tur' => $_POST['hareket_tipi'][$key],
					'hareket_alist_tutar' => $_POST['alis_tutar'][$key],
					'hareket_aciklama' => $_POST['hareket_aciklama'],
					'hareket_adet' => $_POST['adet'][$key]
				)
			);
			if ($insert) {
				$hareket_id = $conn->lastInsertId();
				$yeni_isaret = ($_POST['hareket_tipi'][$key] == 1) ? '+' : '-';

				// Yeni hareketi işleme
				if ($yeni_isaret == '+') {
					$stokGuncelle = $conn->prepare("UPDATE stok_urunler SET stok_adet = stok_adet + :yeni_adet WHERE stok_id = :id");
				} else {
					$stokGuncelle = $conn->prepare("UPDATE stok_urunler SET stok_adet = stok_adet - :yeni_adet WHERE stok_id = :id");
				}

				$guncelle = $stokGuncelle->execute(array(
					'yeni_adet' => $_POST['adet'][$key],
					'id' => $urun
				));

				if ($guncelle) {
					// header("Location: stok-duzenle?durum=basarili&id=" . $urun);
				} else {
					$sonuc = $conn->exec("DELETE FROM stok_hareketler WHERE hareket_id = $hareket_id");
					//header("Location: hareket-ekle?durum=basarisiz");
				}
			} else {
				// header("Location: stok-ekle?durum=basarisiz");
			}
		}
		if ($guncelle and $insert) {
			header("Location: toplu-hareket-ekle?durum=basarili");
		} else {
			header("Location: toplu-hareket-ekle?durum=basarisiz");
		}
	}
}


if (isset($_POST['sssEkle'])) {

	$sayfa_hizmet_id = 12;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');


	$query = $conn->prepare("INSERT INTO sss SET     
		soru = :soru,
		cevap = :cevap
		");
	$insert = $query->execute(
		array(
			"soru" => $_POST['soru'],
			"cevap" => $_POST['cevap']
		)
	);
	if ($insert) {
		header("Location: sss-listesi?durum=basarili");
	} else {
		header("Location: sss-listesi?durum=basarisiz");
	}
}
if (isset($_POST['sssDuzenle'])) {

	$sayfa_hizmet_id = 12;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$query = $conn->prepare("UPDATE sss SET      
		soru = :soru, 
		cevap = :cevap
		WHERE id = :id
		");
	$insert = $query->execute(
		array(
			"soru" => $_POST['soru'],
			"cevap" => $_POST['cevap'],
			"id" => $_POST['id']
		)
	);
	if ($insert) {
		header("Location: sss-listesi?durum=basarili");
	} else {
		header("Location: sss-listesi?durum=basarisiz");
	}
}

//////////////////////////////////////////////////////////
if (isset($_POST['promosyonGorselEkle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');
	$uploads_dir = '../uploads/';
	foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
		$name = $_FILES['gorseller']['name'][$key];
		$size = $_FILES['gorseller']['size'][$key];
		$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		if ($size > 0 && in_array($ext, $allowedExtensions)) {
			$target_file = $uploads_dir . 'promosyongorsel' . time() . '_' . mt_rand(0, 999) . '_' . $key . '.' . $ext;
			move_uploaded_file($tmp_name, $target_file);
			$imgyol = substr($target_file, 3);
			$query = $conn->prepare("INSERT INTO promosyon_gorseller SET     
				urun_id = :urun_id,
				img = :img
				");
			$insert = $query->execute(
				array(
					"urun_id" => $_POST['urun_id'],
					"img" => $imgyol
				)
			);
		}
	}
	if ($insert) {
		header("Location: urun-duzenle?durum=basarili&tap=promosyonGorsel&id=" . $_POST['urun_id']);
	} else {
		header("Location: urun-duzenle?durum=basarisiz&tap=promosyonGorsel&id=" . $_POST['urun_id']);
	}
}


//*****************************************************************
#region EKLEDİĞİM KODLAR
if (isset($_POST['promosyonGorselleriEkle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

	foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
		$name = $_FILES['gorseller']['name'][$key];
		$size = $_FILES['gorseller']['size'][$key];
		$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		if ($size > 0 && in_array($ext, $allowedExtensions)) {
			//$file_rename = 'promosyongorsel' . time() . '_' . mt_rand(0, 999) . '_' . $key . '.' . $ext;
			$file_rename = $name;

			#region MEVCUT DOMAİNE YÜKLE
			$target_file = '../uploads/' . $file_rename;
			$thumb_file = '../thumbs/uploads/' . $file_rename;
			move_uploaded_file($tmp_name, $target_file);

			$image = new ImageResize($target_file);
			$image->resizeToLongSide(320);
			$image->save($thumb_file);
			#endregion MEVCUT DOMAİNE YÜKLE

			$imgyol = substr($target_file, 3);

			#region BAŞKA DOMAİNE YÜKLE			
			$target_file = $anasayfa_url . "uploads/" . $file_rename;
			$thumb_file = $anasayfa_url . "thumbs/uploads/" . $file_rename;
			move_uploaded_file($tmp_name, $target_file);

			$image->save($thumb_file);
			#endregion BAŞKA DOMAİNE YÜKLE

			$query = $conn->prepare("INSERT INTO a_promosyongorselleri SET
				img = :img
				");
			$insert = $query->execute(
				array(
					"img" => $file_rename
				)
			);
		}
	}
	if ($insert) {
		header("Location: promosyon-gorsel-listesi?durum=basarili&tap=promosyonGorsel&id=" . $_POST['promosyon_id']);
	} else {
		header("Location: promosyon-gorsel-listesi?durum=basarisiz&tap=promosyonGorsel&id=" . $_POST['promosyon_id']);
	}
}

if (isset($_POST['promosyonEkle'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');

	$query = $conn->prepare("INSERT INTO a_promosyonlar SET      
		promosyon_adi = :promosyon_adi,
		promosyon_kisa_adi = :promosyon_kisa_adi,
		promosyon_onceki = :promosyon_onceki,
		promosyon_ucret = :promosyon_ucret,
		promosyon_video = :promosyon_video
		");
	$insert = $query->execute(
		array(
			'promosyon_adi' => $_POST['promosyon_adi'],
			'promosyon_kisa_adi' => $_POST['promosyon_kisa_adi'],
			'promosyon_onceki' => $_POST['promosyon_onceki'],
			'promosyon_ucret' => $_POST['promosyon_ucret'],
			'promosyon_video' => $_POST['promosyon_video']
		)
	);
	$promosyon_id = $conn->lastInsertId();
	if ($insert) {
		header("Location: promosyon-listesi?durum=basarili&id=" . $promosyon_id);
	} else {
		header("Location: promosyon-ekle?durum=basarisiz&id=" . $promosyon_id);
	}
}

if (isset($_POST['promosyonDuzenle'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$query = $conn->prepare("UPDATE a_promosyonlar SET      
		promosyon_adi = :promosyon_adi,
		promosyon_kisa_adi = :promosyon_kisa_adi,
		promosyon_onceki = :promosyon_onceki,
		promosyon_ucret = :promosyon_ucret,
		promosyon_video = :promosyon_video
		WHERE promosyon_id = :promosyon_id
		");
	$insert = $query->execute(
		array(
			"promosyon_adi" => $_POST['promosyon_adi'],
			'promosyon_kisa_adi' => $_POST['promosyon_kisa_adi'],
			"promosyon_onceki" => $_POST['promosyon_onceki'],
			"promosyon_ucret" => $_POST['promosyon_ucret'],
			"promosyon_video" => $_POST['promosyon_video'],
			"promosyon_id" => $_POST['promosyon_id']
		)
	);
	if ($insert) {
		header("Location: promosyon-listesi?durum=basarili");
	} else {
		header("Location: promosyon-listesi?durum=basarisiz");
	}
}

if (isset($_POST['promosyonaGorselEkle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	try {
		$sonuc = $conn->exec("DELETE FROM a_promosyonlar_promosyongorselleri WHERE promosyon_id = " . $_POST['promosyon_id']);

		foreach ($_POST["promosyongorsel_id"] as $key => $promosyongorsel_id) {
			$query = $conn->prepare("INSERT INTO a_promosyonlar_promosyongorselleri SET     
				promosyon_id = :promosyon_id,
				promosyongorsel_id = :promosyongorsel_id
				");
			$insert = $query->execute(
				array(
					"promosyon_id" => $_POST['promosyon_id'],
					"promosyongorsel_id" => $promosyongorsel_id
				)
			);
		}
		$response["status"] = "success";
		$response["message"] = "Promosyon görseli/görselleri başarıyla düzenlendi.";
		header("Location: promosyon-listesi?durum=basarili&id=" . $_POST['promosyon_id']);
	} catch (Exception $e) {
		$response["status"] = "error";
		$response["message"] = "Promosyon görseli silinirken bir hata oluştu.";
		//$response["message"] = $e->getMessage();
		header("Location: promosyona-gorsel-ekle?durum=basarisiz&id=" . $_POST['promosyon_id']);
	}
}

if (isset($_POST['urunePromosyonEkle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	try {
		$sonuc = $conn->exec("DELETE FROM a_urunler_promosyonlar WHERE urun_id = " . $_POST['urun_id']);

		foreach ($_POST["promosyon_id"] as $key => $promosyon_id) {
			$query = $conn->prepare("INSERT INTO a_urunler_promosyonlar SET     
				urun_id = :urun_id,
				promosyon_id = :promosyon_id
				");
			$insert = $query->execute(
				array(
					"urun_id" => $_POST['urun_id'],
					"promosyon_id" => $promosyon_id
				)
			);
		}
		$response["status"] = "success";
		$response["message"] = "Ürün promosyonu/promosyonları başarıyla düzenlendi.";
		header("Location: urun-promosyon-listesi?durum=basarili&id=" . $_POST['urun_id']);
	} catch (Exception $e) {
		$response["status"] = "error";
		//$response["message"] = "Ürün Promosyonu silinirken bir hata oluştu.";
		$response["message"] = $e->getMessage();
		header("Location: urune-promosyon-ekle?durum=basarisiz&id=" . $_POST['urun_id']);
	}
}


if (isset($_POST['urunGorselleriEkle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$allowedExtensions = array('jpg', 'jpeg', 'png', 'gif', 'webp');

	foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
		$name = $_FILES['gorseller']['name'][$key];
		$size = $_FILES['gorseller']['size'][$key];
		$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
		if ($size > 0 && in_array($ext, $allowedExtensions)) {
			//$file_rename = 'urungorsel' . time() . '_' . mt_rand(0, 999) . '_' . $key . '.' . $ext;
			$file_rename = $name;

			#region MEVCUT DOMAİNE YÜKLE
			$target_file = '../uploads/' . $file_rename;
			$thumb_file = '../thumbs/uploads/' . $file_rename;
			move_uploaded_file($tmp_name, $target_file);

			$image = new ImageResize($target_file);
			//$image->resizeToLongSide(640);
			$image->resizeToWidth(320);
			$image->save($thumb_file);
			#endregion MEVCUT DOMAİNE YÜKLE

			$imgyol = substr($target_file, 3);

			#region BAŞKA DOMAİNE YÜKLE			
			$target_file = $anasayfa_url . "uploads/" . $file_rename;
			$thumb_file = $anasayfa_url . "thumbs/uploads/" . $file_rename;
			move_uploaded_file($tmp_name, $target_file);

			$image->save($thumb_file);
			#endregion BAŞKA DOMAİNE YÜKLE

			$query = $conn->prepare("INSERT INTO a_urungorselleri SET
				img = :img
				");
			$insert = $query->execute(
				array(
					//"img" => $file_rename
					"img" => $imgyol
				)
			);
		}
	}
	if ($insert) {
		header("Location: urun-gorsel-listesi?durum=basarili&tap=urunGorsel&id=" . $_POST['urun_id']);
	} else {
		header("Location: urun-gorsel-listesi?durum=basarisiz&tap=urunGorsel&id=" . $_POST['urun_id']);
	}
}

if (isset($_POST['uruneGorselEkle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	try {
		$sonuc = $conn->exec("DELETE FROM a_urunler_urungorselleri WHERE urun_id = " . $_POST['urun_id']);

		foreach ($_POST["urungorsel_id"] as $key => $urungorsel_id) {
			$query = $conn->prepare("INSERT INTO a_urunler_urungorselleri SET     
				urun_id = :urun_id,
				urungorsel_id = :urungorsel_id
				");
			$insert = $query->execute(
				array(
					"urun_id" => $_POST['urun_id'],
					"urungorsel_id" => $urungorsel_id
				)
			);
		}
		$response["status"] = "success";
		$response["message"] = "Ürün görseli/görselleri başarıyla düzenlendi.";
		header("Location: urun-urungorsel-listesi?durum=basarili&id=" . $_POST['urun_id']);
	} catch (Exception $e) {
		$response["status"] = "error";
		//$response["message"] = "Ürün görseli silinirken bir hata oluştu.";
		$response["message"] = $e->getMessage();
		header("Location: urune-gorsel-ekle?durum=basarisiz&id=" . $_POST['urun_id']);
	}
}

if (isset($_POST['urunKaydet'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'ekle');

	$urun_img = null;
	if ($_FILES['urun_img']["size"] > 0) {
		$uploads_dir = '../uploads/';
		$tmp_name = $_FILES['urun_img']["tmp_name"];
		$name = $_FILES['urun_img']["name"];
		$ext = pathinfo($name, PATHINFO_EXTENSION);

		//$file_rename = 'urunanagorsel' . time() . '_' . mt_rand(0, 999) . '_' . $key . '.' . $ext;
		$file_rename = $name;

		#region MEVCUT DOMAİNE YÜKLE
		$target_file = '../uploads/' . $file_rename;
		$thumb_file = '../thumbs/uploads/' . $file_rename;
		move_uploaded_file($tmp_name, $target_file);

		$image = new ImageResize($target_file);
		$image->resizeToWidth(320);
		$image->save($thumb_file);
		#endregion MEVCUT DOMAİNE YÜKLE

		$imgyol = substr($target_file, 3);

		#region BAŞKA DOMAİNE YÜKLE			
		$target_file = $anasayfa_url . "uploads/" . $file_rename;
		$thumb_file = $anasayfa_url . "thumbs/uploads/" . $file_rename;
		move_uploaded_file($tmp_name, $target_file);

		$image->save($thumb_file);
		#endregion BAŞKA DOMAİNE YÜKLE
	}
	$query = $conn->prepare("INSERT INTO a_urunler SET      
		urun_img = :urun_img,
		urun_subdomain = :urun_subdomain,
		urun_whatsapp = :urun_whatsapp,
		urun_script = :urun_script,
		urun_tesekkur_script = :urun_tesekkur_script,
		urun_css = :urun_css,
		urun_stok = :urun_stok,
		urun_aciklama = :urun_aciklama,
		urun_video = :urun_video,
		promosyon_video = :promosyon_video,
		urun_stok_kodu = :urun_stok_kodu,
		urun_adi = :urun_adi,
		urun_kisa_adi = :urun_kisa_adi,
		urun_fiyat = :urun_fiyat,
		urun_maliyet = :urun_maliyet,
		urun_iade_orani = :urun_iade_orani,
		urun_seo_title = :urun_seo_title,
		urun_seo_desc = :urun_seo_desc,
		urun_seo_keyw = :urun_seo_keyw
		");
	$insert = $query->execute(
		array(
			'urun_img' => $imgyol,
			'urun_subdomain' => $_POST['urun_subdomain'],
			'urun_whatsapp' => $_POST['urun_whatsapp'],
			'urun_script' => $_POST['urun_script'],
			'urun_tesekkur_script' => $_POST['urun_tesekkur_script'],
			'urun_css' => $_POST['urun_css'],
			'urun_stok' => $_POST['urun_stok'],
			'urun_aciklama' => $_POST['urun_aciklama'],
			'urun_video' => $_POST['urun_video'],
			'promosyon_video' => $_POST['promosyon_video'],
			'urun_stok_kodu' => $_POST['urun_stok_kodu'],
			'urun_adi' => $_POST['urun_adi'],
			'urun_kisa_adi' => $_POST['urun_kisa_adi'],
			'urun_fiyat' => $_POST['urun_fiyat'],
			'urun_maliyet' => $_POST['urun_maliyet'],
			'urun_iade_orani' => $_POST['urun_iade_orani'],
			'urun_seo_title' => SEOLink($_POST['urun_seo_desc']),
			'urun_seo_desc' => $_POST['urun_seo_desc'],
			'urun_seo_keyw' => $_POST['urun_seo_keyw']
		)
	);

	$fiyat_urun = $conn->lastInsertId();
	if (isset($_POST['adet']) and $_POST['adet'] != '') {
		foreach ($_POST['adet'] as $key => $fiyat_adet) {
			$query = $conn->prepare("INSERT INTO a_urun_fiyatlandirma SET      
				urun_id = :urun_id,     
				adet = :adet,
				onceki = :onceki,
				fiyat = :fiyat,
				kargo_tutar = :kargo_tutar,
				kargo_durum = :kargo_durum
				");
			$insert = $query->execute(
				array(
					'urun_id' => $fiyat_urun,
					'adet' => $fiyat_adet,
					'onceki' => $_POST['onceki'][$key],
					'fiyat' => $_POST['fiyat'][$key],
					'kargo_tutar' => $_POST['kargo_tutar'][$key],
					'kargo_durum' => $_POST['kargo_durum'][$key]
				)
			);
		}
	}
	//die($insert);
	if ($insert) {
		header("Location: urun-urungorsel-listesi?durum=basarili&id=" . $fiyat_urun);
	} else {
		header("Location: urun-urungorsel-listesi?durum=basarisiz&id=" . $fiyat_urun);
	}
}

if (isset($_POST['varyantKaydet'])) {
	try {
		$query = $conn->prepare("INSERT INTO a_urun_varyantlar SET      
		urun_id = :urun_id,     
		varyant_adi = :varyant_adi,
		degerler = :degerler
		");
		$insert = $query->execute(
			array(
				'urun_id' => $_POST['urun_id'],
				'varyant_adi' => $_POST['varyant_adi'],
				'degerler' => $_POST['varyasyon_degerleri']
			)
		);
		header("Location: urun-varyant-kaydet?durum=basarili&id=" . $_POST['urun_id']);
	} catch (Exception $e) {
		$response["status"] = "error";
		$response["message"] = $e->getMessage();
		//die($response);
		header("Location: urun-varyant-kaydet?durum=basarisiz&id=" . $_POST['urun_id']);
	}
}

if (isset($_POST['varyantGuncelle'])) {

	$sayfa_hizmet_id = 5;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	try {
		$query = $conn->prepare("UPDATE a_urun_varyantlar SET   
		varyant_adi = :varyant_adi,
		degerler = :degerler
		WHERE urun_varyant_id = :urun_varyant_id
		");
		$insert = $query->execute(
			array(
				'varyant_adi' => $_POST['varyant_adi'],
				'degerler' => $_POST['varyasyon_degerleri'],
				'urun_varyant_id' => $_POST['urun_varyant_id']
			)
		);
		header("Location: urun-varyant-kaydet?durum=basarili&id=" . $_POST['urun_id']);
	} catch (Exception $e) {
		$response["status"] = "error";
		$response["message"] = $e->getMessage();
		//die($response);
		header("Location: urun-varyant-guncelle?durum=basarisiz&id=" . $_POST['urun_id']);
	}
}

if (isset($_POST['urunGuncelle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	try {
		if ($_FILES['urun_img']["size"] > 0) {
			$uploads_dir = '../uploads/';
			$tmp_name = $_FILES['urun_img']["tmp_name"];
			$name = $_FILES['urun_img']["name"];
			$ext = pathinfo($name, PATHINFO_EXTENSION);

			//$file_rename = 'urunanagorsel' . time() . '_' . mt_rand(0, 999) . '_' . $key . '.' . $ext;
			$file_rename = $name;

			#region MEVCUT DOMAİNE YÜKLE
			$target_file = '../uploads/' . $file_rename;
			$thumb_file = '../thumbs/uploads/' . $file_rename;
			move_uploaded_file($tmp_name, $target_file);

			$image = new ImageResize($target_file);
			$image->resizeToWidth(320);
			$image->save($thumb_file);
			#endregion MEVCUT DOMAİNE YÜKLE

			$imgyol = substr($target_file, 3);

			#region BAŞKA DOMAİNE YÜKLE			
			$target_file = $anasayfa_url . "uploads/" . $file_rename;
			$thumb_file = $anasayfa_url . "thumbs/uploads/" . $file_rename;
			move_uploaded_file($tmp_name, $target_file);

			$image->save($thumb_file);
			#endregion BAŞKA DOMAİNE YÜKLE

			$query = $conn->prepare("UPDATE a_urunler SET      
			urun_img = :urun_img
			WHERE urun_id = :urun_id
			");
			$update = $query->execute(
				array(
					//'urun_img' => $file_rename,
					'urun_img' => $imgyol,
					'urun_id' => $_POST['urun_id']
				)
			);
		}
		$query = $conn->prepare("UPDATE a_urunler SET
		urun_subdomain = :urun_subdomain,
		urun_whatsapp = :urun_whatsapp,
		urun_script = :urun_script,
		urun_tesekkur_script = :urun_tesekkur_script,
		urun_css = :urun_css,
		urun_aciklama = :urun_aciklama,
		urun_video = :urun_video,
		promosyon_video = :promosyon_video,
		urun_stok = :urun_stok,
		urun_stok_kodu = :urun_stok_kodu,
		urun_adi = :urun_adi,
		urun_kisa_adi = :urun_kisa_adi,
		urun_fiyat = :urun_fiyat,
		urun_maliyet = :urun_maliyet,
		urun_iade_orani = :urun_iade_orani,
		urun_seo_title = :urun_seo_title,
		urun_seo_desc = :urun_seo_desc,
		urun_seo_keyw = :urun_seo_keyw
		WHERE urun_id = :urun_id
		");
		$insert = $query->execute(
			array(
				'urun_subdomain' => $_POST['urun_subdomain'],
				'urun_whatsapp' => $_POST['urun_whatsapp'],
				'urun_script' => $_POST['urun_script'],
				'urun_tesekkur_script' => $_POST['urun_tesekkur_script'],
				'urun_css' => $_POST['urun_css'],
				'urun_aciklama' => $_POST['urun_aciklama'],
				'urun_video' => $_POST['urun_video'],
				'promosyon_video' => $_POST['promosyon_video'],
				'urun_stok' => $_POST['urun_stok'],
				'urun_stok_kodu' => $_POST['urun_stok_kodu'],
				'urun_adi' => $_POST['urun_adi'],
				'urun_kisa_adi' => $_POST['urun_kisa_adi'],
				'urun_fiyat' => $_POST['urun_fiyat'],
				'urun_maliyet' => $_POST['urun_maliyet'],
				'urun_iade_orani' => $_POST['urun_iade_orani'],
				'urun_seo_title' => SEOLink($_POST['urun_seo_desc']),
				'urun_seo_desc' => $_POST['urun_seo_desc'],
				'urun_seo_keyw' => $_POST['urun_seo_keyw'],
				'urun_id' => $_POST['urun_id']
			)
		);

		// $urun_id = $_POST['urun_id'];

		// if (isset($_POST['adet']) and $_POST['adet'] != '') {
		// 	$sonuc = $conn->exec("DELETE FROM a_urun_fiyatlandirma WHERE urun_id = $urun_id ");
		// 	foreach ($_POST['adet'] as $key => $fiyat_adet) {
		// 		$query = $conn->prepare("INSERT INTO a_urun_fiyatlandirma SET      
		// 		urun_id = :urun_id,     
		// 		adet = :adet,
		// 		onceki = :onceki,
		// 		fiyat = :fiyat,
		// 		kargo_tutar = :kargo_tutar,
		// 		kargo_durum = :kargo_durum
		// 		");
		// 		$insert = $query->execute(
		// 			array(
		// 				'urun_id' => $urun_id,
		// 				'adet' => $fiyat_adet,
		// 				'onceki' => $_POST['onceki'][$key],
		// 				'fiyat' => $_POST['fiyat'][$key],
		// 				'kargo_tutar' => $_POST['kargo_tutar'][$key],
		// 				'kargo_durum' => $_POST['kargo_durum'][$key]
		// 			)
		// 		);
		// 	}
		// }
		header("Location: urunler?durum=basarili&id=" . $urun_id);
	} catch (Exception $e) {
		$response["status"] = "error";
		$response["message"] = $e->getMessage();
		header("Location: urun-guncelle?durum=basarisiz&id=" . $_POST['urun_id']);
	}
}

if (isset($_POST['urunKargoFiyati'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$sonuc = $conn->exec("DELETE FROM a_urun_fiyatlandirma WHERE urun_id = " . $_POST['urun_id']);
	foreach ($_POST['adet'] as $key => $fiyat_adet) {
		$query = $conn->prepare("INSERT INTO a_urun_fiyatlandirma SET      
				urun_id = :urun_id,     
				adet = :adet,
				onceki = :onceki,
				fiyat = :fiyat,
				kargo_tutar = :kargo_tutar,
				kargo_durum = :kargo_durum,
				durum = :durum");
		$insert = $query->execute(
			array(
				'urun_id' => $_POST['urun_id'],
				'adet' => $fiyat_adet,
				'onceki' => $_POST['onceki'][$key],
				'fiyat' => $_POST['fiyat'][$key],
				'kargo_tutar' => $_POST['kargo_tutar'][$key],
				'kargo_durum' => $_POST['kargo_durum'][$key],
				'durum' => $_POST['durum'][$key] == 'on' ? 1 : 0
			)
		);
	}
	header("Location: urun-fiyatlandirma?durum=basarili&id=" . $_POST['urun_id']);
}

if (isset($_POST['urunYorumEkle'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$uploads_dir = '../uploads/yorumlar/';
	$uploaded_images = array();

	foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
		$name = $_FILES['gorseller']['name'][$key];
		$ext = pathinfo($name, PATHINFO_EXTENSION);
		$target_file = $uploads_dir . seo('banner-') . time() . '-' . $key . '.' . $ext;
		$yorum_img = substr($target_file, 3);

		if (@move_uploaded_file($tmp_name, $target_file)) {
			$uploaded_images[] = $yorum_img;

			$image = new ImageResize($target_file);
			$image->resizeToLongSide(640);
			$image->save($target_file); //resmi yeniden boyutlandır ve üstüne kaydet
		}
	}

	$yorum_img_json = json_encode($uploaded_images);

	$query = $conn->prepare("INSERT INTO a_yorumlar SET  
		yorum_adi = :yorum_adi,
		yorum_puan = :yorum_puan,
		yorum_aciklama = :yorum_aciklama,
		urun_id = :urun_id,
		yorum_img = :yorum_img
		");
	$insert = $query->execute(
		array(
			"yorum_adi" => $_POST['yorum_adi'],
			"yorum_puan" => $_POST['yorum_puan'],
			"yorum_aciklama" => $_POST['yorum_aciklama'],
			"urun_id" => $_POST['urun_id'],
			"yorum_img" => $yorum_img_json
		)
	);

	if ($insert) {
		header("Location: urun-yorumlari?durum=basarili&id=" . $_POST['urun_id']);
	} else {
		header("Location: urun-yorumlari?durum=basarisiz&id=" . $_POST['urun_id']);
	}
}
if (isset($_POST['urunYorumDuzenle'])) {
	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$uploads_dir = '../uploads/yorumlar/';
	$uploaded_images = array();
	$yorum_id = $_POST['yorum_id'];

	$stmt = $conn->prepare("SELECT yorum_img FROM yorumlar WHERE yorum_id = :yorum_id");
	$stmt->execute(array("yorum_id" => $yorum_id));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$existing_images = json_decode($row['yorum_img'], true) ?: array();

	if (!empty($_FILES['gorseller']['name'][0])) {
		foreach ($_FILES['gorseller']['tmp_name'] as $key => $tmp_name) {
			$name = $_FILES['gorseller']['name'][$key];
			$ext = pathinfo($name, PATHINFO_EXTENSION);
			$target_file = $uploads_dir . seo('banner-') . time() . '-' . $key . '.' . $ext;
			$yorum_img = substr($target_file, 3);

			if (@move_uploaded_file($tmp_name, $target_file)) {
				$uploaded_images[] = $yorum_img;
			}
		}
		$all_images = array_merge($existing_images, $uploaded_images);
	} else {
		$all_images = $existing_images;
	}

	$yorum_img_json = json_encode($all_images);

	$query = $conn->prepare("UPDATE a_yorumlar SET  
		yorum_adi = :yorum_adi,
		yorum_puan = :yorum_puan,
		yorum_aciklama = :yorum_aciklama,
		urun_id = :urun_id,
		yorum_img = :yorum_img
		WHERE yorum_id = :yorum_id
		");
	$update = $query->execute(
		array(
			"yorum_adi" => $_POST['yorum_adi'],
			"yorum_puan" => $_POST['yorum_puan'],
			"yorum_aciklama" => $_POST['yorum_aciklama'],
			"urun_id" => $_POST['urun_id'],
			"yorum_img" => $yorum_img_json,
			"yorum_id" => $yorum_id
		)
	);

	if ($update) {
		header("Location: urun-yorumlari?durum=basarili&id=" . $_POST['urun_id']);
	} else {
		header("Location: urun-yorumlari?durum=basarisiz&id=" . $_POST['urun_id']);
	}
}

if (isset($_POST['a_yorumSayisiDuzenle'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$query = $conn->prepare("UPDATE a_urunler SET      
		yorum_sayisi = :yorum_sayisi
		WHERE urun_id = :urun_id
		");
	$update = $query->execute(
		array(
			"yorum_sayisi" => abs($_POST['yorum_sayisi']),
			"urun_id" => $_POST['urun_id']
		)
	);
	if ($update) {
		header("Location: urun-guncelle?id=" . $_POST['urun_id'] . "&durum=basarili");
	} else {
		header("Location: urun-guncelle?id=" . $_POST['urun_id'] . "&durum=basarisiz");
	}
}

if (isset($_POST['a_yorumSayisiSil'])) {

	$sayfa_hizmet_id = 3;
	redirectToUnauthorized($sayfa_hizmet_id, 'duzenle');

	$query = $conn->prepare("UPDATE a_urunler SET      
		yorum_sayisi = :yorum_sayisi
		WHERE urun_id = :urun_id
		");
	$update = $query->execute(
		array(
			"yorum_sayisi" => NULL,
			"urun_id" => $_POST['urun_id']
		)
	);
	if ($update) {
		header("Location: urun-guncelle?id=" . $_POST['urun_id'] . "&durum=basarili");
	} else {
		header("Location: urun-guncelle?id=" . $_POST['urun_id'] . "&durum=basarisiz");
	}
}
#endregion EKLEDİĞİM KODLAR