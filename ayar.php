<?php
$host = "localhost";
$db_name = "mrtcknsi_favim1334";
$db_user = "mrtcknsi_favim1334";
$pass = 'Q4gYChwCx6sFz4L8fxzF';

//$db_user = "root";
//$pass = '';

$separator = ' | ';
try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $db_user, $pass);
    $siteData = $conn->query('SELECT * FROM ayarlar')->fetch(PDO::FETCH_ASSOC);
    $siteLink = $siteData['anasayfa_url'].'/';
    include 'helper.php';
} catch (PDOException $e) {
    echo $e->getMessage();
}