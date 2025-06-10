<?php
ob_start();
session_start();
if (isset($_GET['route']) && $_GET['route'] != '') {
	include('ayar.php');
    if (is_numeric($_GET['route'])) {
        $data = getOneId("a_urunler","urun_id",(int)$_GET['route']);
    }else{
		if($_GET['route'] == "panel"){
			header("Location: index.php");
			die();
		}
        $data = getOneSql("SELECT * FROM a_urunler WHERE urun_seo_title = '" . @$_GET['route'] . "';");
    }
}else{
	//$data = getOneId("urunler","urun_id",(int)$urun_id);
	//include 'panel/index.php';
	include 'anasayfa.php';
	die();
}

if(!isset($data) || $data == ''){
	die("Bu ürün mevcut değil.");
}

$urun_id = (int)$data['urun_id'];

$urunSayisi = count($data);

$_SESSION['urun_id'] = $urun_id;

if ($urunSayisi > 0) {
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
	$ilk_fiyatlandirma = (float)getOneSql("SELECT * FROM a_urun_fiyatlandirma WHERE urun_id = $urun_id ORDER BY adet ASC LIMIT 1");
	$yorumSayi = getOneSql("SELECT COUNT(*) AS toplam FROM a_yorumlar WHERE urun_id = $urun_id")["toplam"];
	$yorumSayi = $yorumSayi ? $yorumSayi : 0;
	$yorumToplamPuan = getOneSql("SELECT SUM(yorum_puan) AS toplam FROM a_yorumlar WHERE urun_id = $urun_id")["toplam"];
	$ortalamaYorumPuan = ($yorumSayi > 0) ? ((int)$yorumToplamPuan / $yorumSayi) : 0;
} else {
	header('Location: ' . $anasayfa_url);
}