<?php
@ob_start();
@session_start();
if (!isset($_SESSION["giris"])) {
	header('location:giris');
}else {
	include 'ayar.php';
	$kul_id = $_SESSION['kul_id'];
	$userData = $conn->query("SELECT * FROM kullanicilar WHERE kul_id = $kul_id ")->fetch(PDO::FETCH_ASSOC);
}
?>